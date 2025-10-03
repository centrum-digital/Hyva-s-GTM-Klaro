(function () {
  let firstPageViewSent = false;

  function startGtag(cons) {
    const cfg = window.CentGTM?.cfg;
    if (!cfg) {
      console.warn('[CentGTM] Brak configu – gtag init przerwany');
      return;
    }

    const GA_ID = cfg.ids?.ga4_measurement_id || null;
    const AW_ID = cfg.ids?.ads_conversion_id || null;
    const endpoint = cfg.endpoint?.url || 'https://dev-shop.pl/data';
    const anonymize_ip = true;

    if (!window.gtag) {
      // start gtag.js z SGTM
      window.addEventListener('init-external-scripts', () => {
        const id = GA_ID || AW_ID;
        if (!id) return;
        const gtagScript = document.createElement('script');
        gtagScript.async = true;
        gtagScript.src = endpoint + '/gtag/js?id=' + id;
        document.head.insertBefore(gtagScript, document.head.children[0]);
      });

      window.dataLayer = window.dataLayer || [];
      window.gtag = function () { dataLayer.push(arguments); };

      gtag('js', new Date());
      gtag('set', 'developer_id.dYjhlMD', true);

      // --- Consent Mode default ---
      gtag('consent', 'default', {
        ad_storage: 'denied',
        analytics_storage: 'denied',
        personalization_storage: 'denied',
        functionality_storage: 'denied',
        security_storage: 'granted'
      });
    }

    // --- Consent update ---
    gtag('consent', 'update', cons);

    // --- GA4 config (always) ---
    if (GA_ID) {
      gtag('config', GA_ID, {
        anonymize_ip,
        server_container_url: endpoint,
        send_page_view: true,      // pierwszy page_view (cookieless)
        transport_type: 'beacon',
        settings_ga4id: cfg.ids?.ga4_measurement_id,
        settings_awid: cfg.ids?.ads_conversion_id,
        settings_awlabel: cfg.ids?.ads_conversion_label
      });
      console.debug('[CentGTM] GA4 config init:', GA_ID, '→', endpoint, 'consent:', cons.analytics_storage);
    }

    // --- Ads config (always) ---
    if (AW_ID) {
      gtag('config', AW_ID, {
        anonymize_ip,
        transport_type: 'beacon'
      });
      console.debug('[CentGTM] Ads config init:', AW_ID, 'consent:', cons.ad_storage);
    }

    window.__centgtm_gtag_loaded = true;
    document.dispatchEvent(new Event('centgtm:gtag_ready'));
  }

  function sendCentEvents() {
    const el = document.getElementById('centgtm-payload');
    if (!el) return;

    try {
      const payload = JSON.parse(el.textContent);
      if (!payload.events) return;

      payload.events.forEach(ev => {
        const eventName = ev.name || ev.event_name;
        const params = ev.params || {};

        if (!eventName) {
          console.warn('[CentGTM] Event bez nazwy:', ev);
          return;
        }

        gtag('event', eventName, {
          ...params,
          transport_type: 'beacon'
        });

        console.debug('[CentGTM] wysłano event:', eventName, params);
      });
    } catch (e) {
      console.error('[CentGTM] Błąd parsowania payloadu', e);
    }
  }

  // 🔑 listener consent
  document.addEventListener('v:consent', (ev) => {
    startGtag(ev.detail);
    sendCentEvents();
  });

  // 🔑 if klaro works
  if (window.CentGTM?.google_consent) {
    startGtag(window.CentGTM.google_consent);
    sendCentEvents();
  }
})();
