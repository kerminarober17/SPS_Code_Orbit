/**
 * SPS Code Orbit — reusable success feedback (challenge / XP / badge)
 * Only call celebrateChallenge when validation passed — not on bare "no syntax error".
 */
(function (global) {
  var reduced = false;
  try {
    reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  } catch (e) {}

  function ensureStyles() {
    /* css/ux-polish.css provides animations */
  }

  /**
   * @param {object} opts
   * @param {string} [opts.title]
   * @param {string} [opts.message]
   * @param {number|string} [opts.xp]
   * @param {number} [opts.durationMs]
   */
  function showSuccessCelebration(opts) {
    opts = opts || {};
    ensureStyles();
    var existing = document.querySelector('.orbit-celebrate');
    if (existing) existing.remove();

    if (reduced) {
      if (typeof global.showToast === 'function') {
        global.showToast(
          (opts.title || 'Success') + (opts.xp ? ' (+' + opts.xp + ' XP)' : ''),
          'success'
        );
      }
      return;
    }

    var root = document.createElement('div');
    root.className = 'orbit-celebrate';
    root.setAttribute('role', 'status');
    root.setAttribute('aria-live', 'polite');

    var burst = document.createElement('div');
    burst.className = 'orbit-celebrate-burst';
    for (var i = 0; i < 12; i++) {
      var s = document.createElement('span');
      var angle = (i / 12) * Math.PI * 2;
      s.style.setProperty('--dx', Math.cos(angle) * (60 + Math.random() * 40) + 'px');
      s.style.setProperty('--dy', Math.sin(angle) * (60 + Math.random() * 40) + 'px');
      s.style.left = '50%';
      s.style.top = '45%';
      s.style.background = i % 3 === 0 ? '#6ee7b7' : i % 3 === 1 ? '#70d6ff' : '#ffe699';
      burst.appendChild(s);
    }

    var card = document.createElement('div');
    card.className = 'orbit-celebrate-card';
    card.innerHTML =
      '<h3>' +
      escapeHtml(opts.title || 'Challenge complete') +
      '</h3><p>' +
      escapeHtml(opts.message || 'Great work — keep going!') +
      '</p>' +
      (opts.xp
        ? '<div class="orbit-celebrate-xp">+' + escapeHtml(String(opts.xp)) + ' XP</div>'
        : '');

    root.appendChild(burst);
    root.appendChild(card);
    document.body.appendChild(root);

    var duration = opts.durationMs || 1600;
    setTimeout(function () {
      if (root.parentNode) root.parentNode.removeChild(root);
    }, duration);
  }

  function celebrateChallenge(opts) {
    opts = opts || {};
    opts.title = opts.title || 'Challenge complete!';
    showSuccessCelebration(opts);
    if (typeof global.showToast === 'function' && reduced) {
      /* already toasted in showSuccessCelebration */
    }
  }

  function escapeHtml(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  global.OrbitFeedback = {
    showSuccessCelebration: showSuccessCelebration,
    celebrateChallenge: celebrateChallenge,
  };
})(typeof window !== 'undefined' ? window : this);
