(function () {
  const mapping = window.CentGTM?.cfg?.klaro_mapping || {};

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
  }

  function deleteCookie(name) {
    const hostname = location.hostname.replace(/^www\./, ''); 
    const paths = ['/', '/']; 
    paths.forEach(path => {
      document.cookie = `${name}=; Max-Age=0; path=${path}; domain=${hostname}`;
      document.cookie = `${name}=; Max-Age=0; path=${path}`;
    });
    if (window.CentGTM?.cfg?.debug_mode) {
      console.debug(`[CentGTM] Cookie ${name} deleted`);
    }
  }

  function deleteGaCookies() {
    const cookies = document.cookie.split(';').map(c => c.trim());
    cookies.forEach(c => {
      const name = c.split('=')[0];
      if (name === '_ga' || name.startsWith('_ga_')) {
        deleteCookie(name);
      }
    });
  }

  //  Klaro → Google Consent Mode
  function mapToGoogleConsent(consents) {
    return {
      analytics_storage: consents[mapping.analytics_storage] ? 'granted' : 'denied',
      ad_storage: consents[mapping.ad_storage] ? 'granted' : 'denied',
      ad_user_data: consents[mapping.ad_user_data || mapping.ad_storage] ? 'granted' : 'denied',
      ad_personalization: consents[mapping.ad_personalization || mapping.ad_storage] ? 'granted' : 'denied'
    };
  }

  // 👉 consents
  function updateConsents() {
    let consentCookie = getCookie('klaro-consent');
    let consents = {};

    if (consentCookie) {
      try {
        const parsed = JSON.parse(decodeURIComponent(consentCookie));
        Object.entries(parsed).forEach(([service, granted]) => {
          consents[service] = !!granted;
        });
      } catch (e) {
        console.warn("CentGTM: błąd parsowania cookie klaro-consent:", e);
      }
    } else {
      consents['essential'] = true;
    }

    // 🔑 save in global API
    window.CentGTM = window.CentGTM || {};
    window.CentGTM.consent = consents;

    // 🔑 Google Consent Mode v2
    const googleConsent = mapToGoogleConsent(consents);
    window.CentGTM.google_consent = googleConsent;

    // 🔥 auto-clean cookies if no consent
    if (!consents[mapping.analytics_storage]) {
        deleteGaCookies();
        deleteCookie('_gid');
        deleteCookie('_fp');
        deleteCookie('FPID');
    }
    if (!consents[mapping.ad_storage]) {
        deleteCookie('_gcl_au');
        deleteCookie('_gcl_aw');
        deleteCookie('_gcl_dc');
        deleteCookie('FPAU');
        deleteCookie('FPLC');
    }

    // Emit event for loadera gtag
  document.dispatchEvent(new CustomEvent('v:consent', { detail: window.CentGTM.google_consent }));

    if (window.CentGTM?.cfg?.debug_mode) {
      console.debug("CentGTM: consents", consents);
      console.debug("CentGTM: google_consent", googleConsent);
    }
  }

  // 👉 first run
  updateConsents();

  // 👉 watcher for klaro-consent
  let lastConsent = getCookie('klaro-consent');
  setInterval(() => {
    const currentConsent = getCookie('klaro-consent');
    if (currentConsent !== lastConsent) {
      if (window.CentGTM?.cfg?.debug_mode) {
        console.log("CentGTM: klaro-consent cookie changed ✅");
      }
      lastConsent = currentConsent;
      updateConsents();
    }
  }, 500);
})();
