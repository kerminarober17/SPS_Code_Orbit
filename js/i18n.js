/**
 * SPS Code Orbit — Centralized Localization (i18n)
 * Languages: en, ar
 * Persistence:
 *   - Unauthenticated: localStorage key 'sps_orbit_language'
 *   - Authenticated: profiles.preferred_language (MySQL) is authoritative
 */

(function (global) {
  'use strict';

  const STORAGE_KEY = 'sps_orbit_language';
  const SUPPORTED = ['en', 'ar'];
  const DEFAULT_LANG = 'en';

  let currentLang = DEFAULT_LANG;
  let translations = {};
  let loaded = false;
  let userPreferredFromDb = null;

  function isValidLang(lang) {
    return SUPPORTED.includes(lang);
  }

  function getBrowserPreference() {
    try {
      const v = localStorage.getItem(STORAGE_KEY);
      if (isValidLang(v)) return v;
    } catch (e) {}
    return null;
  }

  function setBrowserPreference(lang) {
    if (!isValidLang(lang)) return;
    try {
      localStorage.setItem(STORAGE_KEY, lang);
    } catch (e) {}
  }

  async function loadLocale(lang) {
    if (!isValidLang(lang)) lang = DEFAULT_LANG;
    try {
      const res = await fetch(`/locales/${lang}.json?_t=${Date.now()}`);
      if (!res.ok) throw new Error('Locale load failed');
      translations = await res.json();
      loaded = true;
      return true;
    } catch (e) {
      console.warn('[i18n] Failed to load locale', lang, e);
      if (lang !== DEFAULT_LANG) {
        return loadLocale(DEFAULT_LANG);
      }
      translations = {};
      loaded = false;
      return false;
    }
  }

  function t(key, params) {
    if (!key) return '';
    const parts = key.split('.');
    let val = translations;
    for (const p of parts) {
      if (val && typeof val === 'object' && p in val) {
        val = val[p];
      } else {
        // Fallback: return key for detectability of missing translations
        return key;
      }
    }
    if (typeof val !== 'string') return key;
    if (params && typeof params === 'object') {
      return val.replace(/\{\{(\w+)\}\}/g, (_, k) => (params[k] != null ? String(params[k]) : ''));
    }
    return val;
  }

  function applyDocumentDirection(lang) {
    const html = document.documentElement;
    if (typeof window !== 'undefined' && window.__SPS_LANDING_ENGLISH_ONLY__) {
      html.setAttribute('lang', 'en');
      html.setAttribute('dir', 'ltr');
      html.classList.remove('rtl');
      return;
    }
    if (lang === 'ar') {
      html.setAttribute('lang', 'ar');
      html.setAttribute('dir', 'rtl');
      document.body && document.body.classList.add('lang-ar');
      document.body && document.body.classList.remove('lang-en');
    } else {
      html.setAttribute('lang', 'en');
      html.setAttribute('dir', 'ltr');
      document.body && document.body.classList.add('lang-en');
      document.body && document.body.classList.remove('lang-ar');
    }
  }

  function updateSwitcherUI() {
    document.querySelectorAll('[data-lang-switcher]').forEach((el) => {
      const enBtn = el.querySelector('[data-lang="en"]');
      const arBtn = el.querySelector('[data-lang="ar"]');
      if (enBtn) {
        enBtn.classList.toggle('active', currentLang === 'en');
        enBtn.setAttribute('aria-pressed', currentLang === 'en' ? 'true' : 'false');
      }
      if (arBtn) {
        arBtn.classList.toggle('active', currentLang === 'ar');
        arBtn.setAttribute('aria-pressed', currentLang === 'ar' ? 'true' : 'false');
      }
    });
  }

  async function setLanguage(lang, options = {}) {
    if (!isValidLang(lang)) return false;
    const prev = currentLang;
    currentLang = lang;
    setBrowserPreference(lang);
    applyDocumentDirection(lang);
    await loadLocale(lang);
    updateSwitcherUI();

    // Persist for authenticated users
    if (options.persistToServer !== false) {
      try {
        const user = (window.sessionManager && window.sessionManager.user) || null;
        if (user && user.id) {
          await fetch('/api/student/profile.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-User-Id': user.id,
              'Authorization': `Bearer ${user.id}`
            },
            body: JSON.stringify({ preferred_language: lang })
          }).catch(() => {});
        }
      } catch (e) {}
    }

    // Dispatch event so pages can re-render dynamic content
    window.dispatchEvent(new CustomEvent('languagechange', { detail: { lang, previous: prev } }));

    // Re-apply static data-i18n attributes
    applyStaticTranslations();
    return true;
  }

  function applyStaticTranslations() {
    if (typeof window !== 'undefined' && window.__SPS_LANDING_ENGLISH_ONLY__) {
      return;
    }
    document.querySelectorAll('[data-lang-switcher]').forEach(() => {});
    document.querySelectorAll('[data-i18n]').forEach((el) => {
      const key = el.getAttribute('data-i18n');
      if (!key) return;
      const translated = t(key);
      if (translated && translated !== key) {
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
          if (el.hasAttribute('placeholder')) {
            el.setAttribute('placeholder', translated);
          } else {
            el.value = translated;
          }
        } else if (el.hasAttribute('data-i18n-attr')) {
          const attr = el.getAttribute('data-i18n-attr');
          el.setAttribute(attr, translated);
        } else {
          el.textContent = translated;
        }
      }
    });
    document.querySelectorAll('[data-i18n-html]').forEach((el) => {
      const key = el.getAttribute('data-i18n-html');
      if (!key) return;
      const translated = t(key);
      if (translated && translated !== key) {
        el.innerHTML = translated;
      }
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach((el) => {
      const key = el.getAttribute('data-i18n-placeholder');
      if (!key) return;
      const translated = t(key);
      if (translated && translated !== key) {
        el.setAttribute('placeholder', translated);
      }
    });
    document.querySelectorAll('[data-i18n-aria]').forEach((el) => {
      const key = el.getAttribute('data-i18n-aria');
      if (!key) return;
      const translated = t(key);
      if (translated && translated !== key) {
        el.setAttribute('aria-label', translated);
      }
    });
    document.querySelectorAll('[data-i18n-title]').forEach((el) => {
      const key = el.getAttribute('data-i18n-title');
      if (!key) return;
      const translated = t(key);
      if (translated && translated !== key) {
        el.setAttribute('title', translated);
      }
    });
  }

  function createSwitcherHTML(compact) {
    const enActive = currentLang === 'en' ? ' active' : '';
    const arActive = currentLang === 'ar' ? ' active' : '';
    return `
      <div class="lang-switcher" data-lang-switcher role="group" aria-label="Language">
        <button type="button" class="lang-btn${enActive}" data-lang="en" aria-pressed="${currentLang === 'en'}">EN</button>
        <span class="lang-sep" aria-hidden="true">|</span>
        <button type="button" class="lang-btn${arActive}" data-lang="ar" aria-pressed="${currentLang === 'ar'}">العربية</button>
      </div>
    `;
  }

  function bindSwitcherEvents(root) {
    const container = root || document;
    container.querySelectorAll('[data-lang-switcher] .lang-btn').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const lang = btn.getAttribute('data-lang');
        if (lang && lang !== currentLang) {
          setLanguage(lang);
        }
      });
    });
  }

  async function resolveInitialLanguage() {
    // 1. Authenticated DB preference (if available)
    try {
      if (window.sessionManager && typeof window.sessionManager.fetchUser === 'function') {
        await window.sessionManager.fetchUser().catch(() => {});
      }
      const user = (window.sessionManager && window.sessionManager.user) || null;
      if (user && user.preferred_language && isValidLang(user.preferred_language)) {
        userPreferredFromDb = user.preferred_language;
        return user.preferred_language;
      }
    } catch (e) {}

    // 2. Browser preference
    const browser = getBrowserPreference();
    if (browser) return browser;

    // 3. Default
    return DEFAULT_LANG;
  }

  function ensureSwitcherMounted() {
    // Landing page (index.html) is English-only — never mount language switcher there
    if (typeof window !== 'undefined' && window.__SPS_LANDING_ENGLISH_ONLY__) {
      return;
    }
    if (document.querySelector('[data-lang-switcher]')) {
      bindSwitcherEvents(document);
      updateSwitcherUI();
      return;
    }
    // Preferred hosts (public + student dashboard headers)
    let host = document.getElementById('exam-lang-switcher-host')
      || document.getElementById('header-auth-group')
      || document.querySelector('.nav-auth')
      || document.querySelector('.header-actions')
      || document.getElementById('top-header');

    // Lesson page uses a different top bar — mount into its right-side actions area
    if (!host) {
      const lessonNav = document.getElementById('lesson-top-nav');
      if (lessonNav) {
        // Prefer the trailing flex container (actions: Chapters btn + avatar)
        const flexKids = Array.from(lessonNav.children).filter(
          (el) => el.style && (el.style.display === 'flex' || getComputedStyle(el).display.includes('flex'))
        );
        host = flexKids.length > 1 ? flexKids[flexKids.length - 1] : lessonNav;
      }
    }

    // Auth pages (login/signup): mount into the header trailing side
    if (!host) {
      const authHeader = document.querySelector('.auth-page-header');
      if (authHeader) host = authHeader;
    }

    // Generic fallback: any primary header/nav bar
    if (!host) {
      host = document.querySelector('header.top-header, header.site-header, .app-header, nav.top-nav');
    }

    if (!host) return;
    const wrap = document.createElement('div');
    wrap.className = 'lang-switcher-host';
    wrap.style.cssText = 'display:inline-flex;align-items:center;flex-shrink:0;margin-inline-end:0.35rem;';
    wrap.innerHTML = createSwitcherHTML(true);
    if (host.firstChild) host.insertBefore(wrap, host.firstChild);
    else host.appendChild(wrap);
    bindSwitcherEvents(wrap);
    updateSwitcherUI();
  }

  async function init() {
    const lang = await resolveInitialLanguage();
    currentLang = lang;
    setBrowserPreference(lang);
    applyDocumentDirection(lang);
    await loadLocale(lang);
    ensureSwitcherMounted();
    updateSwitcherUI();
    applyStaticTranslations();
    bindSwitcherEvents(document);
    document.addEventListener('sps:auth-nav-updated', () => {
      setTimeout(ensureSwitcherMounted, 0);
    });
    return lang;
  }

  // Public API
  const i18n = {
    t,
    setLanguage,
    getLanguage: () => currentLang,
    init,
    applyStaticTranslations,
    createSwitcherHTML,
    bindSwitcherEvents,
    ensureSwitcherMounted,
    isRtl: () => currentLang === 'ar',
    SUPPORTED,
    STORAGE_KEY
  };

  global.i18n = i18n;
  global.t = t;

  // Auto-init when DOM ready if script is deferred/loaded late
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      // Delay slightly so sessionManager can attach if present
      setTimeout(() => i18n.init(), 50);
    });
  } else {
    setTimeout(() => i18n.init(), 50);
  }
})(typeof window !== 'undefined' ? window : globalThis);
