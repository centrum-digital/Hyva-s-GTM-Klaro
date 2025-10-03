(function () {
  function initCentGTM() {
    // search config <script id="centgtm-config">
    const cfgEl = document.getElementById('centgtm-config');
    let cfg = {};

    if (cfgEl) {
      try {
        cfg = JSON.parse(cfgEl.textContent || cfgEl.innerText || '{}');
      } catch (e) {
        console.warn('[CentGTM] Błąd parsowania configu:', e);
      }
    }

    window.CentGTM = window.CentGTM || {};
    window.CentGTM.cfg = cfg;

    // config ready
    document.dispatchEvent(new Event('centgtm:config_ready'));

    if (cfg.debug_mode) {
      console.debug('[CentGTM] config ready:', cfg);
    }
  }

  initCentGTM();
})();
