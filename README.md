# Hyva-s-GTM-Klaro
Lightweight Magento 2 module for Hyvä theme integrating Klaro! consent manager with self-hosted Google Tag Manager (GTM SS). Provides full eCommerce dataLayer, first-party cookies and defer-loaded gtag.js for high performance and GDPR compliance.

# Hyvä GTM + Klaro Consent Module

This Magento 2 module provides a **self-hosted Google Tag Manager (GTM) integration** and a **lightweight Klaro! consent manager** fully optimized for the **Hyvä theme**.  
It delivers a complete `dataLayer`, supports all eCommerce events, and allows custom payloads for multi-platform tracking.

---

## ✨ Features

- ✅ Full **eCommerce event tracking** for GTM  
  - `view_item`  
  - `view_item_list`  
  - `add_to_cart`  
  - `remove_from_cart` (detected via cart comparison)  
  - checkout and purchase events  
- ✅ **Ultra-light Klaro! CMP** integration for GDPR/consent management  
- ✅ **First-party cookies** storage:  
  - Improves attribution accuracy  
  - Reduces tracking loss caused by third-party cookie restrictions (ITP, Safari, Firefox)  
  - Increases data reliability for remarketing and analytics  
- ✅ **Defer-loaded gtag.js**:  
  - Does not block rendering  
  - No impact on **LCP** (Largest Contentful Paint)  
  - Keeps **Lighthouse performance score** high  
- ✅ Flexible payloads:  
  - Can trigger not only Google tags but also **Facebook Pixel, TikTok, LinkedIn** and any other GTM-integrated platforms  
- ✅ Compatible with **Hyvä Checkout**  
- ✅ Configurable through Magento admin  
- ✅ Extremely lightweight and performant

---

## ⚙️ Requirements

- Magento 2.x with Hyvä Theme  
- GTM Server-Side container (GTMss) properly installed and configured  

---

## 🔧 Installation

```bash
composer require centrum/module-hyva-gtm-klaro
bin/magento setup:upgrade
```

---

## 🚀 Configuration

1. Install and configure a **GTM Server-Side container** on your own domain.  
   - Required variables must be created inside GTMss (see documentation).  
2. Enable Klaro CMP in module settings.  
3. Configure consent purposes and services in Klaro config file (`klaroConfig.js`).  
4. Adjust GTM tags to read from the provided `dataLayer` events.  

---

## 💡 Why First-Party Cookies?

This module stores cookies as **1st-party** (set from your own domain, not from google.com).  

Benefits:  
- Survives modern browser restrictions (Safari ITP, Firefox ETP).  
- Much longer lifetime vs. 3rd-party cookies.  
- Significantly improves attribution for Google Ads, GA4, Meta Ads, TikTok Ads.  
- Increases match rate for remarketing and conversion tracking.  

In short: **better tracking, more accurate campaigns, less data loss**.

---

## 📦 Professional Support

- The module is **free.**  
- Need help with GTM Server-Side setup & domain integration?  
  👉 We provide **one-time setup support** for **1500 USD**.  
  This includes:  
  - GTMss installation on your own domain  
  - Variable & trigger configuration  
  - Verification and testing of event flow  

Contact: **piotr.firmowy@gmail.com**

