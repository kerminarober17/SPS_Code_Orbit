/**
 * SPS CODE ORBIT - Theme Engine
 * Dark Mode ONLY — Light Mode permanently removed.
 */
(function initTheme() {
  document.documentElement.setAttribute('data-theme', 'dark');
  try {
    localStorage.setItem('sps_orbit_theme', 'dark');
    localStorage.removeItem('sps_orbit_theme_light');
  } catch (e) { /* ignore */ }
})();

/** No-op: light mode is disabled permanently. */
function toggleTheme() {
  document.documentElement.setAttribute('data-theme', 'dark');
  try { localStorage.setItem('sps_orbit_theme', 'dark'); } catch (e) {}
}

window.toggleTheme = toggleTheme;
