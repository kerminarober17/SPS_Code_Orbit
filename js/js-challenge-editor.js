/**
 * SPS Code Orbit — Coding mission UI (EN + AR feedback)
 */
(function (global) {
  'use strict';

  function t(key, fallback) {
    try {
      if (global.i18n && typeof global.i18n.t === 'function') {
        var v = global.i18n.t(key);
        if (v && v !== key && typeof v === 'string') return v;
      }
    } catch (e) {}
    return fallback;
  }

  function escapeHtml(s) {
    return String(s == null ? '' : s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function b64encode(str) {
    try {
      return btoa(unescape(encodeURIComponent(String(str == null ? '' : str))));
    } catch (e) {
      return '';
    }
  }

  function b64decode(str) {
    try {
      return decodeURIComponent(escape(atob(String(str || ''))));
    } catch (e) {
      return '';
    }
  }

  function formatInstruction(s) {
    return escapeHtml(s).replace(/\n/g, '<br>');
  }

  function handleTab(e) {
    if (e.key !== 'Tab' || e.ctrlKey || e.metaKey || e.altKey) return;
    var ta = e.target;
    if (!ta || ta.tagName !== 'TEXTAREA') return;
    e.preventDefault();
    var start = ta.selectionStart;
    var end = ta.selectionEnd;
    var val = ta.value;
    if (e.shiftKey) {
      var lineStart = val.lastIndexOf('\n', start - 1) + 1;
      var block = val.slice(lineStart, end);
      var un = block.replace(/^ {1,2}/gm, '');
      ta.value = val.slice(0, lineStart) + un + val.slice(end);
      var removed = block.length - un.length;
      ta.selectionStart = Math.max(lineStart, start - Math.min(2, removed));
      ta.selectionEnd = end - removed;
    } else {
      var insert = '  ';
      ta.value = val.slice(0, start) + insert + val.slice(end);
      ta.selectionStart = ta.selectionEnd = start + insert.length;
    }
  }

  function fbBox(kind, title, body) {
    var bg = kind === 'ok' ? 'rgba(16,185,129,0.15)'
      : kind === 'warn' ? 'rgba(245,158,11,0.15)'
      : kind === 'error' ? 'rgba(239,68,68,0.15)'
      : 'rgba(56,189,248,0.12)';
    var border = kind === 'ok' ? 'rgba(16,185,129,0.45)'
      : kind === 'warn' ? 'rgba(245,158,11,0.45)'
      : kind === 'error' ? 'rgba(239,68,68,0.45)'
      : 'rgba(56,189,248,0.35)';
    var color = kind === 'ok' ? '#6EE7B7'
      : kind === 'warn' ? '#FCD34D'
      : kind === 'error' ? '#FCA5A5'
      : '#7DD3FC';
    return (
      '<div class="js-ch-fb js-ch-fb-' + kind + '" style="display:block;margin-top:0.5rem;padding:0.85rem 1rem;border-radius:10px;background:' + bg + ';border:1px solid ' + border + ';color:' + color + ';">' +
      '<strong style="display:block;margin-bottom:0.25rem;">' + escapeHtml(title) + '</strong>' +
      '<span style="opacity:0.95;">' + escapeHtml(body) + '</span></div>'
    );
  }

  function buildChallengeHtml(idx, content) {
    content = content || {};
    var instruction = content.instruction || content.title || t('challenge.defaultMission', 'Complete this coding mission.');
    var title = content.title || t('challenge.codingChallenge', 'Coding Challenge');
    var initial = content.initialCode || content.code || '// Write your code here\n';
    var expected = content.expectedOutput || '';
    var successMsg = content.successMessage || t('challenge.successDefault', 'Great job! Your output matches the expected result.');
    var lang = content.language || content.lang || 'JavaScript';
    var testInput = content.testInput || content.test_input || '';

    return (
      '<div class="js-ch" data-js-challenge="1" data-idx="' + idx + '"' +
      ' data-lang="' + escapeHtml(lang) + '"' +
      ' data-expected-b64="' + b64encode(expected) + '"' +
      ' data-test-input-b64="' + b64encode(testInput) + '"' +
      ' data-success-b64="' + b64encode(successMsg) + '">' +
      '  <div class="js-ch-header">' + escapeHtml(t('challenge.missionHeader', 'CODING MISSION')) + '</div>' +
      '  <div class="js-ch-mission">' +
      '    <div class="js-ch-kicker">' + escapeHtml(t('challenge.yourMission', 'Your Mission')) + '</div>' +
      '    <h3 class="js-ch-title">' + escapeHtml(title) + '</h3>' +
      '    <p class="js-ch-instruction">' + formatInstruction(instruction) + '</p>' +
      (expected
        ? '    <div class="js-ch-expected"><span class="js-ch-expected-label">' +
          escapeHtml(t('challenge.expectedResult', 'Expected result')) +
          '</span><pre class="js-ch-expected-pre" style="direction:ltr;text-align:left;">' + escapeHtml(expected) + '</pre></div>'
        : '') +
      '  </div>' +
      '  <div class="js-ch-code-label">' + escapeHtml(t('challenge.yourCode', 'Your Code')) + '</div>' +
      '  <textarea class="js-ch-editor" id="js-ch-editor-' + idx + '" spellcheck="false" aria-label="' +
      escapeHtml(t('challenge.yourCode', 'Your Code')) + '" style="direction:ltr;text-align:left;">' + escapeHtml(initial) + '</textarea>' +
      '  <div class="js-ch-actions">' +
      '    <button type="button" class="btn btn-run-code js-ch-test" data-action="test">' +
      escapeHtml(t('challenge.runCode', 'Run Code')) + '</button>' +
      '    <button type="button" class="btn btn-secondary js-ch-reset" data-action="reset">' +
      escapeHtml(t('challenge.resetCode', 'Reset Code')) + '</button>' +
      '  </div>' +
      '  <div class="js-ch-status" aria-live="polite"></div>' +
      '  <div class="js-ch-output-wrap">' +
      '    <div class="js-ch-out-label">' + escapeHtml(t('challenge.programOutput', 'Program Output')) + '</div>' +
      '    <pre class="js-ch-output" aria-live="polite" style="direction:ltr;text-align:left;min-height:2.5rem;"></pre>' +
      '  </div>' +
      '  <div class="js-ch-feedback" aria-live="polite" style="display:block;min-height:0;"></div>' +
      '</div>'
    );
  }

  function evaluate(code, expected, lang, testInput) {
    if (!global.codeRunner) {
      if (typeof global.SafeCodeRunner === 'function') {
        global.codeRunner = new global.SafeCodeRunner();
      } else {
        return Promise.reject(new Error('Code runner not loaded'));
      }
    }
    try {
      if (testInput) {
        global.codeRunner.setStdin(String(testInput).split(/\r?\n/));
      } else {
        global.codeRunner.setStdin([]);
      }
    } catch (e) {}
    return global.codeRunner.evaluatePracticeAsync(code, expected, lang || 'JavaScript');
  }

  function setStatus(el, text, kind) {
    if (!el) return;
    el.textContent = text || '';
    el.className = 'js-ch-status' + (kind ? ' is-' + kind : '');
  }

  function bindRoot(root) {
    if (!root || root.getAttribute('data-bound') === '1') return;
    root.setAttribute('data-bound', '1');

    var editor = root.querySelector('.js-ch-editor');
    var outputEl = root.querySelector('.js-ch-output');
    var feedbackEl = root.querySelector('.js-ch-feedback');
    var statusEl = root.querySelector('.js-ch-status');
    var expected = b64decode(root.getAttribute('data-expected-b64') || '');
    var lang = root.getAttribute('data-lang') || 'JavaScript';
    var testInput = b64decode(root.getAttribute('data-test-input-b64') || '');
    var successMsg = b64decode(root.getAttribute('data-success-b64') || '') || t('challenge.successDefault', 'Great job!');
    var initial = editor ? editor.value : '';
    var passedOnce = false;

    if (editor) editor.addEventListener('keydown', handleTab);

    root.addEventListener('click', function (ev) {
      var btn = ev.target && ev.target.closest ? ev.target.closest('[data-action]') : null;
      if (!btn || !root.contains(btn)) return;
      var action = btn.getAttribute('data-action');

      if (action === 'reset') {
        if (editor) editor.value = initial;
        if (outputEl) outputEl.textContent = '';
        if (feedbackEl) feedbackEl.innerHTML = '';
        setStatus(statusEl, '');
        return;
      }

      if (action === 'test') {
        var code = editor ? editor.value : '';
        setStatus(statusEl, t('challenge.running', 'Running…'), 'busy');
        if (feedbackEl) feedbackEl.innerHTML = '';
        evaluate(code, expected, lang, testInput)
          .then(function (result) {
            try {
              setStatus(statusEl, '');
              var output = (result && result.output != null) ? String(result.output) : '';
              var runtimeError = result && (result.runtimeError || result.error);
              var passed = !!(result && result.passed);
              if (outputEl) outputEl.textContent = output || (runtimeError ? '' : '(empty)');

              var isPy = String(lang).toLowerCase().indexOf('python') >= 0;
              var errLabel = isPy
                ? t('challenge.pythonError', 'Python Error')
                : t('challenge.jsError', 'JavaScript Error');

              if (runtimeError) {
                if (feedbackEl) feedbackEl.innerHTML = fbBox('error', errLabel, String(runtimeError));
                return;
              }

              if (!String(expected || '').trim()) {
                if (feedbackEl) {
                  feedbackEl.innerHTML = fbBox(
                    'info',
                    t('challenge.openEndedTitle', 'Open-ended challenge'),
                    t('challenge.openEndedBody', 'Your code can be run, but this challenge does not have automatic pass/fail validation.')
                  );
                }
                return;
              }

              if (passed) {
                if (feedbackEl) {
                  feedbackEl.innerHTML = fbBox(
                    'ok',
                    t('challenge.missionComplete', 'Mission Complete!'),
                    successMsg
                  );
                }
                if (!passedOnce) {
                  passedOnce = true;
                  try {
                    if (global.OrbitFeedback && typeof global.OrbitFeedback.celebrateChallenge === 'function') {
                      global.OrbitFeedback.celebrateChallenge({
                        title: t('challenge.missionComplete', 'Mission Complete!'),
                        message: successMsg,
                        xp: null,
                      });
                    } else if (typeof global.showToast === 'function') {
                      global.showToast(t('challenge.missionComplete', 'Mission Complete!'), 'success');
                    }
                  } catch (ce) {}
                } else if (typeof global.showToast === 'function') {
                  global.showToast(t('challenge.alreadyComplete', 'Already completed ✓'), 'success');
                }
                return;
              }

              if (feedbackEl) {
                feedbackEl.innerHTML = fbBox(
                  'warn',
                  t('challenge.notQuite', 'Not quite yet!'),
                  t('challenge.tryAgainBody', "Your output doesn't match the expected result. Review Program Output and try again.")
                );
              }
            } catch (renderErr) {
              console.error('challenge feedback render error', renderErr);
              if (feedbackEl) {
                feedbackEl.innerHTML = fbBox('error', 'Error', String(renderErr && renderErr.message ? renderErr.message : renderErr));
              }
            }
          })
          .catch(function (err) {
            setStatus(statusEl, '');
            if (outputEl) outputEl.textContent = '';
            if (feedbackEl) {
              feedbackEl.innerHTML = fbBox(
                'error',
                t('challenge.testError', 'Test error'),
                err && err.message ? err.message : String(err)
              );
            }
            console.error('challenge test error', err);
          });
      }
    });
  }

  function bindAll(scope) {
    (scope || document).querySelectorAll('[data-js-challenge]').forEach(bindRoot);
  }

  global.JSChallengeEditor = {
    buildChallengeHtml: buildChallengeHtml,
    bindAll: bindAll,
    bindRoot: bindRoot,
  };
})(typeof window !== 'undefined' ? window : this);
