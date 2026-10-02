/**
 * Mobile side-drawer nav — works when #mobile-nav-btn and #primary-nav-links exist.
 * Desktop (min-width 901px): drawer forced closed; hamburger remains CSS-hidden.
 * Mobile behavior preserved exactly under max-width 900px.
 */
(function () {
  var DESKTOP_MIN = 901;

  function init() {
    var btn = document.getElementById('mobile-nav-btn');
    var nav = document.getElementById('primary-nav-links');
    var backdrop = document.getElementById('mobile-nav-backdrop');
    if (!btn || !nav) return;

    function isDesktop() {
      return window.matchMedia('(min-width: ' + DESKTOP_MIN + 'px)').matches;
    }

    function setOpen(open) {
      if (isDesktop()) open = false;

      nav.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      btn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      if (backdrop) {
        backdrop.hidden = !open;
        backdrop.classList.toggle('is-open', open);
        backdrop.style.pointerEvents = open ? 'auto' : 'none';
      }
      var header = document.getElementById('main-nav-header');
      if (header) {
        header.classList.toggle('is-nav-open', open);
      }
      document.body.classList.toggle('mobile-nav-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
      var icon = btn.querySelector('[data-lucide]');
      if (icon) {
        icon.setAttribute('data-lucide', open ? 'x' : 'menu');
        if (window.lucide && typeof lucide.createIcons === 'function') {
          try { lucide.createIcons({ nodes: [btn] }); } catch (e) {}
        }
      }
    }

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      if (isDesktop()) {
        setOpen(false);
        return;
      }
      setOpen(!nav.classList.contains('is-open'));
    });
    if (backdrop) {
      backdrop.addEventListener('click', function (e) {
        e.stopPropagation();
        setOpen(false);
      });
    }
    // Clicks inside the drawer must not fall through to the backdrop
    nav.addEventListener('click', function (e) {
      e.stopPropagation();
    });
    nav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.stopPropagation();
        setOpen(false);
      });
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setOpen(false);
    });

    var mq = window.matchMedia('(min-width: ' + DESKTOP_MIN + 'px)');
    function onBreakpointChange() {
      if (mq.matches) setOpen(false);
    }
    if (typeof mq.addEventListener === 'function') {
      mq.addEventListener('change', onBreakpointChange);
    } else if (typeof mq.addListener === 'function') {
      mq.addListener(onBreakpointChange);
    }
    window.addEventListener('resize', function () {
      if (isDesktop()) setOpen(false);
    });

    setOpen(false);
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
