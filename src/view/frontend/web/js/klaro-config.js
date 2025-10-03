var klaroConfig = {
  version: 1,
  elementID: 'klaro',
  storageMethod: 'cookie',
  storageName: 'klaro-consent',
  cookieExpiresAfterDays: 180,
  htmlTexts: true,
  mustConsent: false,
  acceptAll: true,
  hideDeclineAll: true,
  default: false,
  lang: 'pl',
  showNoticeTitle: true,
 
  // KATEGORIE ZGÓD
  purposes: [
    'essential',
    'statistic',
    'marketing',
    'performance'
  ],

  cookieIcon: {
    svg: `<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 122.88 122.25" viewBox="0 0 122.88 122.25"><path d="M101.77 49.38c2.09 3.1 4.37 5.11 6.86 5.78 2.45.66 5.32.06 8.7-2.01 1.36-.84 3.14-.41 3.97.95.28.46.42.96.43 1.47.13 1.4.21 2.82.24 4.26.03 1.46.02 2.91-.05 4.35 0 .13-.01.26-.03.38-.91 16.72-8.47 31.51-20 41.93-11.55 10.44-27.06 16.49-43.82 15.69v.01c-.13 0-.26-.01-.38-.03-16.72-.91-31.51-8.47-41.93-20C5.31 90.61-.73 75.1.07 58.34c0-.13.01-.26.03-.38.9-16.74 8.71-31.61 20.47-42.09C32.34 5.37 48.09-.73 64.85.07a2.885 2.885 0 0 1 2.66 4.01c-1.17 3.81-1.25 7.34-.27 10.14.89 2.54 2.7 4.51 5.41 5.52 1.44.54 2.2 2.1 1.74 3.55h.01c-1.83 5.89-1.87 11.08-.52 15.26.82 2.53 2.14 4.69 3.88 6.4 1.74 1.72 3.9 3 6.39 3.78 4.04 1.26 8.94 1.18 14.31-.55 1.27-.4 2.62.12 3.31 1.2zm-42.49 8.48c2.77 0 5.01 2.24 5.01 5.01 0 2.77-2.24 5.01-5.01 5.01-2.77 0-5.01-2.24-5.01-5.01 0-2.77 2.25-5.01 5.01-5.01zM37.56 78.49c3.37 0 6.11 2.73 6.11 6.11s-2.73 6.11-6.11 6.11-6.11-2.73-6.11-6.11 2.73-6.11 6.11-6.11zm13.16-46.74c2.65 0 4.79 2.14 4.79 4.79s-2.14 4.79-4.79 4.79-4.79-2.14-4.79-4.79a4.79 4.79 0 0 1 4.79-4.79zm68.58.65c1.98 0 3.58 1.6 3.58 3.58s-1.6 3.58-3.58 3.58-3.58-1.6-3.58-3.58c-.01-1.97 1.6-3.58 3.58-3.58zm-25.68-9.49c2.98 0 5.39 2.41 5.39 5.39 0 2.98-2.41 5.39-5.39 5.39-2.98 0-5.39-2.41-5.39-5.39 0-2.97 2.41-5.39 5.39-5.39zM97.79.59c3.19 0 5.78 2.59 5.78 5.78 0 3.19-2.59 5.78-5.78 5.78-3.19 0-5.78-2.59-5.78-5.78.01-3.2 2.59-5.78 5.78-5.78zM76.73 80.63a8.03 8.03 0 1 1 0 16.06c-4.44 0-8.03-3.59-8.03-8.03 0-4.44 3.59-8.03 8.03-8.03zM31.91 46.78c4.8 0 8.69 3.89 8.69 8.69 0 4.8-3.89 8.69-8.69 8.69a8.69 8.69 0 1 1 0-17.38zm75.22 13.96c-3.39-.91-6.35-3.14-8.95-6.48-5.78 1.52-11.16 1.41-15.76-.02-3.37-1.05-6.32-2.81-8.71-5.18-2.39-2.37-4.21-5.32-5.32-8.75-1.51-4.66-1.69-10.2-.18-16.32-3.1-1.8-5.25-4.53-6.42-7.88-1.06-3.05-1.28-6.59-.61-10.35-13.91.19-26.88 5.6-36.77 14.42C13.74 29.69 6.66 43.15 5.84 58.29v.05l-.01.13c-.76 15.25 4.72 29.35 14.19 39.83 9.44 10.44 22.84 17.29 38 18.1h.05l.13.01c15.24.77 29.35-4.71 39.83-14.19 10.44-9.44 17.29-22.84 18.1-38v-.05l.01-.13c.07-1.34.09-2.64.06-3.91-3.22 1.21-6.24 1.38-9.07.61zm9.02 3.3zm-57.94 52.38z"/></svg>`,
        className: 'w-10 h-10 text-yellow-500',
        wrapperClass: 'flex justify-center mb-4 mt-4',
        alt: 'Cookies'
    },

  privacyPolicy: {
    pl: 'https://twoja-strona.pl/polityka-prywatnosci',
    en: 'https://twoja-strona.pl/en/privacy',
    default: 'https://twoja-strona.pl/polityka'
  },

  // TŁUMACZENIA PL
  translations: {
    pl: {
      consentModal: {
        title: 'Twoja prywatność',
        description: 
          'Na tej stronie korzystamy z plików cookies, aby nie działać na ślepo – pomagają \
          nam analizować, jak użytkownicy poruszają się po serwisie, co pozwala go stale ulepszać. \
          Dane wykorzystujemy wyłącznie do poprawy działania strony i prowadzenia działań \
          marketingowych. Nie przekazujemy ich podmiotom trzecim.'
      },
      consentNotice: {
        description: 
        'Używamy plików cookies, bo nie chcemy błądzić po omacku – pomagają nam lepiej zrozumieć, \
          co działa, a co wymaga poprawy. Twoje dane są wykorzystywane wyłącznie w celu usprawnienia \
          działania naszego serwisu i prowadzenia działań marketingowych i analitycznych – nie przekazujemy ich \
          podmiotom trzecim. Możesz zapoznać się z naszą {privacyPolicy}, aby dowiedzieć się więcej.',
        learnMore: 'Dostosuj ustawienia',
        title: 'Używamy plików cookies',
        changeDescription: 'Od Twojej ostatniej wizyty nastąpiły zmiany, prosimy o odnowienie zgody.',
        imprint: {
          name: 'Impressum'
        },
        privacyPolicy: {
          name: 'Polityka prywatności'
        },
        testing: 'Tryb testowy!'
      },
      contextualConsent: {
        acceptAlways: 'Zawsze',
        acceptOnce: 'Tak',
        description: 'Czy chcą Państwo załadować treści zewnętrzne dostarczane przez {title}?'
      },
      ok: 'Akceptuj wszystkie',
      acceptAll: 'Akceptuj wszystkie',
      acceptSelected: 'Zapisz wybór',
      decline: 'Odrzuć',
      close: 'Zamknij',
      save: 'Zapisz',
      poweredBy: 'Technologia dostarczona przez Klaro',
      privacyPolicy: {
        name: 'Polityka prywatności',
        text: 'Aby dowiedzieć się więcej, prosimy o zapoznanie się z naszą {privacyPolicy}.'
      },
      service: {
        disableAll: {
          title: 'Włącz lub wyłącz wszystkie usługi',
          description: 'Za pomocą tego przełącznika można włączać lub wyłączać wszystkie usługi.'
        },
        optOut: {
          title: '(opt-out)',
          description: 'Ta usługa jest domyślnie załadowana (ale mogą Państwo z niej zrezygnować)'
        },
        required: {
          title: '(zawsze wymagane)',
          description: 'Usługi te są zawsze wymagane'
        },
        purposes: 'Cele',
        purpose: 'Cel'
      },
      purposeItem: {
        service: 'usługa',
        services: 'usługi'
      },
      purposes: {
        essential: 'Technicznie wymagane',
        statistic: 'Analityka',
        marketing: 'Marketing',
        performance: 'Personalizacja i optymalizacja'
      }
    }
  },

  // USŁUGI POWIĄZANE ZE ZGODAMI
  services: [

    // 🛡️ Ciasteczka techniczne (Magento, Klaro, sesja)
    {
    name: 'essential',
    title: 'Technicznie wymagane cookies',
    purposes: ['essential'],
    required: true,
    default: true,
    cookies: [], // nic nie wpisujemy — nie blokujemy technicznych cookies
    description: "Te pliki cookies są niezbędne do prawidłowego funkcjonowania strony internetowej. Obejmują one na przykład pliki cookies umożliwiające logowanie, zarządzanie koszykiem zakupów lub inne funkcje, bez których strona nie może działać poprawnie."
    },

    // 📊 Analityka (Google Analytics 4 przez GTM SS)
    {
      name: 'google-analytics',
      title: 'Google Analytics',
      purposes: ['statistic'],
      required: false,
      default: false,
      cookies: [], // nie generujemy client-side cookies
      description: "Google Analytics to narzędzie do analizy ruchu na stronie internetowej. Używamy go, aby lepiej zrozumieć, jak użytkownicy korzystają z naszej strony, co pozwala nam ją ulepszać i dostosowywać do potrzeb odwiedzających. Więcej informacji o tym, w jaki sposób Google wykorzystuje dane osobowe, znajdziesz tutaj: <a href='https://business.safety.google/privacy/' target='_blank' rel='noopener noreferrer'>https://business.safety.google/privacy/</a>."
    },

    // 📊 Analityka (Elastic smile)
    {
      name: 'elastic-smile',
      title: 'Elastic Smile Analytics',
      purposes: ['statistic'],
      required: false,
      default: false,
      cookies: ['STUID', 'STVID'],
      description: 'Elastic Smile Analytics to nasze wewnętrzne narzędzie do analizy ruchu na stronie. Zbierane dane są przechowywane wyłącznie na naszych serwerach i nie są przekazywane do dostawcy zewnętrznego (Elastic).'
    },

    // 🎯 Reklama, remarketing (np. Google Ads przez GTM SS)
    {
      name: 'google-ads',
      title: 'Google Ads / Remarketing',
      purposes: ['marketing'],
      required: false,
      default: false,
      cookies: [],
      description: "Google Ads to platforma reklamowa, która umożliwia nam wyświetlanie spersonalizowanych reklam na podstawie Twojej aktywności w Internecie. Używamy jej, aby docierać do osób, które mogą być zainteresowane naszymi produktami lub usługami. Więcej informacji o tym, w jaki sposób Google wykorzystuje dane osobowe, znajdziesz tutaj: <a href='https://business.safety.google/privacy/' target='_blank' rel='noopener noreferrer'>https://business.safety.google/privacy/</a>."
    },
    

    // ⚙️ Personalizacja, np. feedy, dynamiczne bloki
    {
      name: 'personalization',
      title: 'Personalizacja i A/B testy',
      purposes: ['performance'],
      required: false,
      default: false,
      cookies: [],
      description: 'Używamy narzędzi do personalizacji i testów A/B, aby dostosować zawartość strony do Twoich preferencji i potrzeb. Dzięki temu możemy oferować bardziej relewantne treści i ulepszać doświadczenia użytkowników na naszej stronie.'
    }
  ]
};
