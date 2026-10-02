/**
 * Shared Admin top navigation for SPS Code Orbit.
 * Renders consistent links on every admin page; highlights the active section.
 */
(function () {
  'use strict';

  const ADMIN_LINKS = [
    { key: 'dashboard', href: '/admin/dashboard.html', label: 'Dashboard', icon: 'layout-dashboard' },
    { key: 'teachers', href: '/admin/teachers.html', label: 'Teachers', icon: 'user-check' },
    { key: 'students', href: '/admin/students.html', label: 'Students', icon: 'users' },
    { key: 'challenges', href: '/admin/challenges.html', label: 'Challenges', icon: 'trophy' },
    { key: 'assessments', href: '/admin/assessments.html', label: 'Assessments', icon: 'award' },
  ];

  function detectActiveKey() {
    const path = (window.location.pathname || '').toLowerCase();
    if (path.indexOf('/admin/challenges') !== -1) return 'challenges';
    if (path.indexOf('/admin/students') !== -1) return 'students';
    if (path.indexOf('/admin/teachers') !== -1) return 'teachers';
    if (path.indexOf('/admin/assessments') !== -1) return 'assessments';
    if (path.indexOf('/admin/dashboard') !== -1 || path.endsWith('/admin/') || path.endsWith('/admin')) return 'dashboard';
    return '';
  }

  /**
   * @param {string} [activeKey] - optional override
   * @param {HTMLElement|string} [target] - nav element or selector; defaults to .admin-nav-links
   */
  window.renderAdminNav = function (activeKey, target) {
    const key = activeKey || detectActiveKey();
    let nav = null;
    if (typeof target === 'string') {
      nav = document.querySelector(target);
    } else if (target && target.nodeType === 1) {
      nav = target;
    } else {
      nav = document.querySelector('.admin-nav-links') || document.getElementById('admin-nav-root');
    }
    if (!nav) return;

    nav.innerHTML = ADMIN_LINKS.map(function (link) {
      const active = link.key === key;
      const style = active
        ? 'background: rgba(59, 130, 246, 0.2); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.4); text-decoration: none; font-weight: 700;'
        : 'text-decoration: none;';
      const cls = active ? 'btn btn-sm' : 'btn btn-sm btn-outline';
      return (
        '<a href="' + link.href + '" class="' + cls + '" style="' + style + '" data-admin-nav="' + link.key + '">' +
        '<i data-lucide="' + link.icon + '" style="width: 14px; height: 14px;"></i>' +
        '<span>' + link.label + '</span>' +
        '</a>'
      );
    }).join('');

    if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try { window.lucide.createIcons(); } catch (e) {}
    }
  };

  // Auto-render when DOM is ready if a nav container exists
  document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.admin-nav-links') || document.getElementById('admin-nav-root')) {
      window.renderAdminNav();
    }
  });
})();
