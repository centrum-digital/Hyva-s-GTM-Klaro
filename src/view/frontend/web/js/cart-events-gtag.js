(function () {
    var SECTION = 'cartevents';

    function toGtagEvent(ev) {
        var out = Object.assign({}, ev);
        var name = out.event_name || out.event || 'event';
        delete out.event_name;
        delete out.settings;

        if (!out.event_id && window.crypto && crypto.randomUUID) {
            out.event_id = crypto.randomUUID();
        }

        const ge = { name, params: out };
        console.warn('[CentGTM] Cart event payload →', JSON.stringify(ge, null, 2));

        return ge;
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.addEventListener('private-content-loaded', (event) => {
            const section = event.detail?.data?.[SECTION];
            if (!section) {
                if (window.CentGTM?.cfg?.debug_mode) {
                    console.log('[CentGTM] brak sekcji', SECTION, event.detail?.data);
                }
                return;
            }

            const events = section.events || [];
            if (!events.length) {
                if (window.CentGTM?.cfg?.debug_mode) {
                    console.log('[CentGTM] brak eventów w', SECTION);
                }
                return;
            }

            function trySend() {
                if (!window.__centgtm_gtag_loaded) {
                    setTimeout(trySend, 120);
                    return;
                }

                events.forEach((e) => {
                    var ge = toGtagEvent(e);
                    try {
                        if (typeof window.gtag === 'function') {
                            window.gtag('event', ge.name, ge.params);
                            if (window.CentGTM?.cfg?.debug_mode) {
                                console.log('[CentGTM] cart gtag →', ge.name, ge.params);
                            }
                        } else {
                            console.warn('[CentGTM] gtag not ready, skipped', ge);
                        }
                    } catch (err) {
                        console.error('[CentGTM] gtag send failed', err, ge);
                    }
                });
            }

            trySend();
        });
    });
})();
