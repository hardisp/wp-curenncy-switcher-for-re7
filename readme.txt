=== RE7MC Currency Switcher ===
Contributors: Jiksdi
Tags: currency, currency switcher, multi-currency, ecommerce, money
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight WordPress currency switcher with cookie + localStorage support. Lets users select and remember their preferred currency across sessions.

== Description ==

RE7MC Currency Switcher is a simple yet powerful WordPress plugin that allows visitors to switch between multiple currencies on your site.

**Features:**

* Frontend currency dropdown via shortcode `[re7mc_switcher]`
* Default currencies: USD, GBP, IDR, JPY, EUR
* Saves selected currency to both localStorage (fast frontend access) and cookies (server-side access)
* Automatically loads saved currency on page load
* Easy to add or remove currencies
* Cleans up settings when the plugin is deleted

This plugin is lightweight, fast, and ideal for websites that display prices in multiple currencies.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/re7mc-currency-switcher` directory, or install the plugin through the WordPress Plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. (Optional) Configure currencies in **Settings > Currency Switcher**.
4. Add the shortcode to any page, post, or widget:

    [re7mc_switcher]

== Frequently Asked Questions ==

= How do I change the list of currencies? =
You can edit the currency list in the plugin settings or programmatically by updating the `re7mc_currencies` option.

= Where is the selected currency stored? =
The plugin stores it in both localStorage (for quick frontend usage) and a cookie (for PHP backend usage).

= Does uninstalling the plugin remove the saved settings? =
Yes, when deleted from the admin, the plugin removes the `re7mc_currencies` and `re7mc_enable_dropdown` options.

== Screenshots ==

1. Example frontend currency switcher dropdown.

== Changelog ==

= 1.0.0 =
* Initial release
* Default currencies: USD, GBP, IDR, JPY, EUR
* Frontend + backend sync via cookies and localStorage
* Added `[re7mc_switcher]` shortcode
* Uninstall cleanup included

== Upgrade Notice ==

= 1.0.0 =
Initial release — adds currency dropdown with frontend and backend sync.
