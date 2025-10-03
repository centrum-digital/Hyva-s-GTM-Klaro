# Hyvä GTM + Klaro Consent Module

This Magento 2 module provides a **self-hosted Google Tag Manager (GTM) integration** and a **lightweight Klaro! consent manager** fully optimized for the **Hyvä theme**.  
It delivers a complete `dataLayer`, supports all eCommerce events, and allows custom payloads for multi-platform tracking.

The module supports multistore. This means that with this module and a single GTM server-side container you can handle any number of stores within one Magento installation. The data is separated based on the GA4 ID variable, which is passed into the payload from the module’s configuration.

The module can be quickly and easily refactored programmatically to serve solely as a dataLayer provider and to work with a cookie notice module other than Klaro.

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

## ⚙️ Configuration

### 0. Klaro CMP
- Start with the Klaro config file:  
  `src/view/frontend/web/js/klaro-config.js`  
- Define **purposes (goals)** and **services** according to your tracking needs.  
- To remain compliant with **Google Consent Mode v2 (GCM v2)**, you must **map Klaro services to Google signals**.  
  This is **mandatory** for GA4 / Google Ads to work properly.  

### 1. Magento Admin Configuration
The module settings are available in:  
**Stores → Configuration → General → Centrum GTM**

Required fields:  
- **GA4 Measurement ID** (format: `G-XXXXXX`)  
- **GTM Server-Side endpoint URL** – the endpoint where payloads will be sent. Example:  
  ```
  https://www.example.com/data
  ```

Optional fields:  
- **Conversion Label**  
- **Conversion ID**  
  (used for Google Ads remarketing and conversions)

### 2. GTM Server-Side Container
- In Google Tag Manager UI, create a **Server container**.  
- Deploy the GTM SS container from the official Docker image.  
- To support **first-party cookies**, the container must run on **your own domain** (e.g. `https://www.example.com/data`).  
- Update your Nginx / Apache configuration to proxy requests to the GTM SS container on `/data`.  

### 3. How the Module Works
- The module sends all **event payloads** (e.g. `view_item`, `add_to_cart`, `purchase`) to the GTM SS endpoint.  
- The GTM SS container receives them via the **Client** component.  
- Based on those events, GTM SS fires the configured **tags** (GA4, Ads, Meta, TikTok, custom tags, etc.).  

### 4. GTM SS Setup
To unlock full potential:  
- Configure GTM SS with **variables, triggers, and tags** to handle the payload.  
- Map Magento eCommerce events to GA4 / Ads / other platforms according to your business needs.  
- Ensure Klaro consent signals are respected in GTM SS (via Consent Mode v2 mapping).  

---

## ⚙️ Requirements

- Magento 2.4.x  
- Hyvä Theme ^1.3  
- GTM Server-Side container (GTMss) properly installed and configured  

---

## 🔧 Installation

```bash
composer require centrum/module-gtm
bin/magento setup:upgrade
```

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

- The module is **free and open-source**.  
- Need help with GTM Server-Side setup & domain integration?  
  👉 We provide **one-time setup support** for **1500 USD**.  
  This includes:  
  - GTMss installation on your own domain  
  - Variable & trigger configuration  
  - Verification and testing of event flow  

Contact: **biuro@centrumswiatla.com.pl**

---

## License

MIT
