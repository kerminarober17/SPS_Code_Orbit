/**
 * Cody — client helper for SPS Code Orbit AI Programming Tutor
 * Talks only to /api/cody/chat.php (never to OpenRouter directly).
 */
(function (global) {
  'use strict';

  const CODY_AVATAR = '/assets/cody/cody.png';
  const API_URL = '/cody_api.php';
  const MAX_HISTORY = 12;

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  /**
   * Safe lightweight markdown → HTML (code fences, inline code, bold, newlines).
   * Does NOT use innerHTML with raw model output without escaping first.
   */
  function formatCodyMarkdown(text) {
    if (!text) return '';
    let s = String(text);
    const blocks = [];
    s = s.replace(/```([a-zA-Z0-9_+-]*)\n?([\s\S]*?)```/g, function (_, lang, code) {
      const id = blocks.length;
      blocks.push({ lang: lang || 'code', code: code.replace(/\n$/, '') });
      return '\u0000CODEBLOCK' + id + '\u0000';
    });
    s = escapeHtml(s);
    s = s.replace(/\u0000CODEBLOCK(\d+)\u0000/g, function (_, id) {
      const b = blocks[Number(id)];
      const safeCode = escapeHtml(b.code);
      const langLabel = escapeHtml(b.lang);
      return (
        '<div class="cody-code-block">' +
        '<div class="cody-code-header"><span>' + langLabel + '</span>' +
        '<button type="button" class="cody-copy-btn" data-cody-copy="' + id + '">Copy</button></div>' +
        '<pre><code>' + safeCode + '</code></pre></div>'
      );
    });
    s = s.replace(/`([^`\n]+)`/g, function (_, code) {
      return '<code>' + code + '</code>';
    });
    s = s.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
    s = s.replace(/\n/g, '<br>');
    return s;
  }

  function attachCopyHandlers(root, blocksSourceText) {
    if (!root) return;
    const blocks = [];
    String(blocksSourceText || '').replace(/```([a-zA-Z0-9_+-]*)\n?([\s\S]*?)```/g, function (_, lang, code) {
      blocks.push(code.replace(/\n$/, ''));
      return '';
    });
    root.querySelectorAll('[data-cody-copy]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        const idx = parseInt(btn.getAttribute('data-cody-copy'), 10);
        const text = blocks[idx] || '';
        if (!text) return;
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(text).then(function () {
            btn.textContent = 'Copied';
            setTimeout(function () { btn.textContent = 'Copy'; }, 1500);
          }).catch(function () {
            fallbackCopy(text, btn);
          });
        } else {
          fallbackCopy(text, btn);
        }
      });
    });
  }

  function fallbackCopy(text, btn) {
    try {
      const ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.left = '-9999px';
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      document.body.removeChild(ta);
      if (btn) {
        btn.textContent = 'Copied';
        setTimeout(function () { btn.textContent = 'Copy'; }, 1500);
      }
    } catch (e) {}
  }

  async function getCsrf() {
    try {
      if (global.session && typeof global.session.getCsrfToken === 'function') {
        const t = await global.session.getCsrfToken();
        if (t) return t;
      }
    } catch (e) {}
    try {
      const res = await fetch('/api/auth/me.php?_t=' + Date.now(), {
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
      });
      const json = await res.json();
      const token = (json && json.data && json.data.csrf_token) || '';
      if (token && global.session) {
        global.session.csrfToken = token;
      }
      return token;
    } catch (e) {
      return '';
    }
  }

  /**
   * Send a message to Cody.
   * @returns {Promise<{ok:boolean, reply?:string, error?:string}>}
   */
  async function sendMessage(opts) {
    const message = (opts && opts.message) ? String(opts.message).trim() : '';
    if (!message) return { ok: false, error: 'Empty message' };

    const mode = (opts && opts.mode) || 'chat';
    const history = Array.isArray(opts.history) ? opts.history.slice(-MAX_HISTORY) : [];
    const context = (opts && opts.context) || {};
    const language = (opts && opts.language) ||
      (global.session && global.session.user && global.session.user.preferred_language) ||
      (localStorage.getItem('sps_orbit_language') || 'en');

    const csrf = await getCsrf();
    const body = {
      message: message,
      mode: mode,
      history: history,
      context: context,
      language: language,
      csrf_token: csrf
    };

    try {
      if (!csrf) {
        return { ok: false, error: 'Session expired. Please refresh the page and try again.' };
      }
      // Do NOT use apiFetch here: it attaches Authorization/X-User-Id headers
      // that some shared hosts (InfinityFree) block with a hard 403 portal.
      // Cody auth is cookie session + CSRF only.
      const res = await fetch(API_URL, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': csrf
        },
        body: JSON.stringify(body)
      });

      const rawText = await res.text();
      let json = null;
      try {
        json = rawText ? JSON.parse(rawText) : null;
      } catch (e) {
        // Host may have replaced the response with an HTML error portal (e.g. InfinityFree 403 page)
        if (/errors\.infinityfree|<!DOCTYPE|<html/i.test(rawText || '')) {
          return {
            ok: false,
            error: '🤖 Server blocked the request (hosting 403). Please refresh, log in again, and retry. If it continues, the host may be blocking the Cody API path.'
          };
        }
        return { ok: false, error: '🤖 Cody is temporarily unavailable. Please try again in a moment.' };
      }

      if (res.status === 401) {
        return { ok: false, error: (json && (json.error || json.message)) || 'Please log in to use Cody.' };
      }
      if (res.status === 400 && json && (json.error || json.message)) {
        return { ok: false, error: json.error || json.message };
      }
      if (!res.ok || !json || json.success === false) {
        const err = (json && (json.error || json.message)) ||
          '🤖 Cody is temporarily unavailable. Please try again in a moment.';
        return { ok: false, error: err };
      }
      const reply = json.data && json.data.reply;
      if (!reply) {
        return { ok: false, error: '🤖 Cody is temporarily unavailable. Please try again in a moment.' };
      }
      return { ok: true, reply: reply };
    } catch (e) {
      return { ok: false, error: '🤖 Network error. Please check your connection and try again.' };
    }
  }

  function renderMessageBubble(container, role, text, avatarUrl) {
    const row = document.createElement('div');
    row.className = 'cody-msg-row ' + (role === 'user' ? 'user' : 'assistant');
    const img = document.createElement('img');
    img.className = 'cody-msg-avatar';
    img.alt = role === 'user' ? 'You' : 'Cody';
    img.src = avatarUrl || (role === 'user'
      ? (global.session && global.session.user && global.session.user.avatar_url) ||
        'https://ui-avatars.com/api/?name=You&background=3B82F6&color=fff&size=64'
      : CODY_AVATAR);
    img.onerror = function () {
      this.onerror = null;
      this.src = role === 'user'
        ? 'https://ui-avatars.com/api/?name=You&background=3B82F6&color=fff&size=64'
        : '/assets/images/Violet_planet_character_smiling.png';
    };
    const bubble = document.createElement('div');
    bubble.className = 'cody-bubble';
    if (role === 'assistant') {
      bubble.innerHTML = formatCodyMarkdown(text);
      attachCopyHandlers(bubble, text);
    } else {
      bubble.textContent = text;
    }
    row.appendChild(img);
    row.appendChild(bubble);
    container.appendChild(row);
    container.scrollTop = container.scrollHeight;
    return row;
  }

  /**
   * Create a chat controller bound to DOM elements.
   */
  function createChatController(options) {
    const messagesEl = options.messagesEl;
    const inputEl = options.inputEl;
    const sendBtn = options.sendBtn;
    const typingEl = options.typingEl;
    const errorEl = options.errorEl;
    const emptyEl = options.emptyEl;
    let history = [];
    let busy = false;
    let mode = options.mode || 'chat';
    let contextProvider = options.contextProvider || function () { return {}; };

    function setBusy(v) {
      busy = v;
      if (sendBtn) sendBtn.disabled = v;
      if (inputEl) inputEl.disabled = v;
      if (typingEl) {
        typingEl.classList.toggle('is-visible', v);
        typingEl.textContent = v ? 'Cody is thinking…' : '';
      }
    }

    function showError(msg) {
      if (!errorEl) return;
      if (!msg) {
        errorEl.classList.remove('is-visible');
        errorEl.textContent = '';
        return;
      }
      errorEl.textContent = msg;
      errorEl.classList.add('is-visible');
    }

    function hideEmpty() {
      if (emptyEl) emptyEl.style.display = 'none';
    }

    async function submit(text, forceMode) {
      const msg = (text || (inputEl && inputEl.value) || '').trim();
      if (!msg || busy) return;
      showError('');
      hideEmpty();
      if (inputEl) inputEl.value = '';
      renderMessageBubble(messagesEl, 'user', msg);
      history.push({ role: 'user', content: msg });
      setBusy(true);
      const result = await sendMessage({
        message: msg,
        mode: forceMode || mode,
        history: history.slice(0, -1),
        context: contextProvider(),
        language: options.language
      });
      setBusy(false);
      if (!result.ok) {
        showError(result.error || 'Something went wrong.');
        return;
      }
      history.push({ role: 'assistant', content: result.reply });
      if (history.length > MAX_HISTORY * 2) {
        history = history.slice(-MAX_HISTORY * 2);
      }
      renderMessageBubble(messagesEl, 'assistant', result.reply);
    }

    function reset() {
      history = [];
      if (messagesEl) messagesEl.innerHTML = '';
      showError('');
      if (emptyEl) emptyEl.style.display = '';
      if (inputEl) inputEl.value = '';
    }

    if (sendBtn) {
      sendBtn.addEventListener('click', function (e) {
        e.preventDefault();
        submit();
      });
    }
    if (inputEl) {
      inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          submit();
        }
      });
    }

    return {
      submit: submit,
      reset: reset,
      setMode: function (m) { mode = m; },
      getHistory: function () { return history.slice(); },
      setContextProvider: function (fn) { contextProvider = fn; }
    };
  }

  /**
   * Collect lesson context from the current page (lesson.html).
   */
  function collectLessonContext() {
    const ctx = {};
    try {
      if (typeof lessonData !== 'undefined' && lessonData) {
        ctx.lesson_title = lessonData.title || '';
        ctx.course_title = lessonData.course_title || '';
        ctx.chapter_title = lessonData.chapter_title || '';
        ctx.topic = lessonData.title || '';
        if (lessonData.summary || lessonData.description) {
          ctx.explanation = String(lessonData.summary || lessonData.description || '').slice(0, 1200);
        }
      }
      const titleEl = document.getElementById('lesson-title-display');
      if (!ctx.lesson_title && titleEl) ctx.lesson_title = titleEl.textContent.trim();
      const chEl = document.getElementById('lesson-chapter-label');
      if (!ctx.chapter_title && chEl) ctx.chapter_title = chEl.textContent.trim();

      // Prefer practice challenge editor if present
      const practiceTa = document.querySelector('#practice-challenge-section textarea.ide-code-input') ||
        document.querySelector('textarea.ide-code-input');
      if (practiceTa && practiceTa.value) {
        ctx.student_code = practiceTa.value.slice(0, 4000);
      }
      const practiceOut = document.querySelector('#practice-challenge-section .console-output-text') ||
        document.querySelector('.console-output-text');
      if (practiceOut) {
        const txt = (practiceOut.innerText || practiceOut.textContent || '').trim();
        if (txt && txt.indexOf('Click "Run Code"') === -1) {
          ctx.compiler_output = txt.slice(0, 2000);
        }
      }
      // Language from IDE tab or challenge
      const langEl = document.querySelector('#practice-challenge-section .ide-tab-title span') ||
        document.querySelector('.ide-tab-title span');
      if (langEl) {
        const t = langEl.textContent || '';
        if (/python/i.test(t)) ctx.language = 'Python';
        else if (/javascript|js/i.test(t)) ctx.language = 'JavaScript';
        else if (/html/i.test(t)) ctx.language = 'HTML';
        else if (/css/i.test(t)) ctx.language = 'CSS';
      }
      // Exam page detection
      if (document.body && document.body.classList.contains('exam-page')) {
        ctx.is_exam = true;
      }
      if (window.location.pathname.indexOf('exam') !== -1) {
        ctx.is_exam = true;
      }
    } catch (e) {}
    return ctx;
  }


  /**
   * Mount the compact Cody panel inside a lesson page.
   * Safe no-op if panel already exists or container missing.
   */
  function mountCodyLessonPanel(container) {
    if (!container || typeof document === 'undefined') return;
    if (document.getElementById('cody-lesson-panel')) return;

    // Only show on pages that look like programming lessons (code editor present)
    const hasEditor = document.querySelector('textarea.ide-code-input') ||
      document.querySelector('#practice-challenge-section') ||
      document.querySelector('.ide-editor') ||
      document.querySelector('[data-code-runner]');
    if (!hasEditor) return;

    const panel = document.createElement('div');
    panel.id = 'cody-lesson-panel';
    panel.className = 'cody-lesson-panel';
    panel.innerHTML =
      '<div class="cody-lesson-header">' +
        '<img class="cody-avatar-sm" src="' + CODY_AVATAR + '" alt="Cody" ' +
          'onerror="this.onerror=null;this.src=\'/assets/images/Violet_planet_character_smiling.png\';">' +
        '<div class="cody-lesson-header-text">' +
          '<strong>🤖 Cody</strong>' +
          '<span data-i18n="cody.needHelp">Need help with this lesson?</span>' +
        '</div>' +
        '<button type="button" class="btn btn-secondary btn-sm" id="cody-lesson-toggle" style="min-height:36px;">' +
          '<span data-i18n="cody.openChat">Open</span>' +
        '</button>' +
      '</div>' +
      '<div class="cody-quick-actions" id="cody-quick-actions">' +
        '<button type="button" class="cody-quick-btn" data-cody-action="hint">💡 Hint</button>' +
        '<button type="button" class="cody-quick-btn" data-cody-action="debug">🐞 Explain Error</button>' +
        '<button type="button" class="cody-quick-btn" data-cody-action="concept">📖 Explain Concept</button>' +
        '<button type="button" class="cody-quick-btn" data-cody-action="review">🔍 Review Code</button>' +
        '<button type="button" class="cody-quick-btn" data-cody-action="ask">🤖 Ask Cody</button>' +
      '</div>' +
      '<div class="cody-lesson-body" id="cody-lesson-body">' +
        '<div class="cody-chat-messages" id="cody-lesson-messages" aria-live="polite"></div>' +
        '<div class="cody-error-banner" id="cody-lesson-error" role="alert"></div>' +
        '<div class="cody-typing" id="cody-lesson-typing" aria-live="polite"></div>' +
        '<div class="cody-chat-footer">' +
          '<div class="cody-input-row">' +
            '<textarea id="cody-lesson-input" rows="1" placeholder="Ask Cody about this lesson..." maxlength="4000"></textarea>' +
            '<button type="button" class="cody-send-btn" id="cody-lesson-send" aria-label="Send">' +
              '<span>Send</span>' +
            '</button>' +
          '</div>' +
        '</div>' +
      '</div>';

    // Prefer append after interactive stream / practice section
    const anchor = document.getElementById('practice-challenge-section') ||
      document.getElementById('interactive-stream') ||
      container;
    if (anchor && anchor.parentNode) {
      if (anchor.nextSibling) {
        anchor.parentNode.insertBefore(panel, anchor.nextSibling);
      } else {
        anchor.parentNode.appendChild(panel);
      }
    } else {
      container.appendChild(panel);
    }

    const bodyEl = document.getElementById('cody-lesson-body');
    const toggleBtn = document.getElementById('cody-lesson-toggle');
    if (toggleBtn && bodyEl) {
      toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const open = panel.classList.toggle('is-open');
        bodyEl.style.display = open ? 'flex' : 'none';
        toggleBtn.querySelector('span').textContent = open ? 'Close' : 'Open';
      });
    }

    const controller = createChatController({
      messagesEl: document.getElementById('cody-lesson-messages'),
      inputEl: document.getElementById('cody-lesson-input'),
      sendBtn: document.getElementById('cody-lesson-send'),
      typingEl: document.getElementById('cody-lesson-typing'),
      errorEl: document.getElementById('cody-lesson-error'),
      emptyEl: null,
      mode: 'lesson',
      contextProvider: collectLessonContext
    });

    const prompts = {
      hint: 'Give me a progressive hint for the current lesson challenge. Do not give the full solution yet.',
      debug: 'Explain the error or unexpected output from my current code. Distinguish syntax vs runtime vs logic if possible.',
      concept: 'Explain the main programming concept of this lesson in simple beginner-friendly terms with a short example.',
      review: 'Review my current code. Point out what looks correct and what I should improve, without rewriting everything for me.',
      ask: ''
    };

    panel.querySelectorAll('[data-cody-action]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        const action = btn.getAttribute('data-cody-action');
        // Open panel
        if (bodyEl) {
          panel.classList.add('is-open');
          bodyEl.style.display = 'flex';
          if (toggleBtn) toggleBtn.querySelector('span').textContent = 'Close';
        }
        if (action === 'ask') {
          const input = document.getElementById('cody-lesson-input');
          if (input) input.focus();
          return;
        }
        const modeMap = { hint: 'hint', debug: 'debug', concept: 'concept', review: 'lesson' };
        if (controller && typeof controller.setMode === 'function') {
          controller.setMode(modeMap[action] || 'lesson');
        }
        const msg = prompts[action] || '';
        if (msg && controller && typeof controller.submit === 'function') {
          controller.submit(msg);
        }
      });
    });
  }

  // Expose for lesson.html global call
  global.mountCodyLessonPanel = mountCodyLessonPanel;

  global.CodyTutor = {
    sendMessage: sendMessage,
    formatCodyMarkdown: formatCodyMarkdown,
    renderMessageBubble: renderMessageBubble,
    createChatController: createChatController,
    collectLessonContext: collectLessonContext,
    mountCodyLessonPanel: mountCodyLessonPanel,
    CODY_AVATAR: CODY_AVATAR
  };
})(typeof window !== 'undefined' ? window : this);
