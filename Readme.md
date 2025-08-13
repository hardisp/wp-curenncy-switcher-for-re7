# RE7MC Currency Switcher

A lightweight WordPress plugin that adds a frontend currency switcher with cookie + localStorage support.  
Allows users to select their preferred currency, which is remembered across sessions, with optional expiry.

## Features

- Frontend currency dropdown (shortcode: `[re7mc_switcher]`)
- Default currencies: USD, GBP, IDR, JPY, EUR
- Saves selected currency to both `localStorage` (for quick frontend access) and cookies (for server-side access)
- Automatically loads saved currency on page load
- Easy to extend with new currencies
- Cleans up settings on plugin uninstall

---

## Installation

1. Upload the plugin folder to `/wp-content/plugins/` or install via the WordPress Plugin Installer.
2. Activate the plugin from the **Plugins** menu in WordPress.
3. (Optional) Configure currencies in **Settings > Currency Switcher** if available.
4. Add the shortcode `[re7mc_switcher]` to any page, post, or widget where you want the dropdown to appear.

---

## Shortcode Usage

```plaintext
[re7mc_switcher]
```

---

## Shortcode Output

The shortcode will render a currency dropdown like this:

```html
<form method="get" class="re7mc-currency-switcher" id="currency-switcher-7">
    <div class="currency-switcher-row">
        <span class="span-label"></span>
        <select name="currency" onchange="this.form.submit()">
            <option value="USD">$ USD</option>
            <option value="EUR">€ EUR</option>
            <option value="GBP">£ GBP</option>
            <option value="IDR">Rp IDR</option>
            <option value="JPY">¥ JPY</option>
        </select>
    </div>
</form>
```

## Adding New Currencies

To add new currencies programmatically:

```php
function myplugin_add_currency() {
    $currencies = get_option('re7mc_currencies', []);
    $currencies['AUD'] = [
        'symbol'   => '$',
        'position' => 'before',
        'enabled'  => 1,
        'rate'     => 1.5,
    ];
    update_option('re7mc_currencies', $currencies);
}
add_action('admin_init', 'myplugin_add_currency');
```

## JavaScript Sync Logic

The plugin includes a small JavaScript file that:

- Stores the selected currency in localStorage with a 30-day expiry
- Syncs localStorage with the re7mc_currency cookie
- Ensures both frontend and backend are aware of the user’s selected currency

## Uninstallation

When deleted from the WordPress admin, the plugin will remove the following options:

- re7mc_currencies
- re7mc_enable_dropdown

## Developer Notes

- re7mc_get_current_currency() returns the currently selected currency code.
- Default currency list is set on plugin activation.
- Currency settings are stored in the re7mc_currencies option as an associative array.

## License

GPLv2 or later

Changelog
1.0.0

- Initial release
- Default currencies: USD, GBP, IDR, JPY, EUR
- Frontend + backend currency sync via cookies and localStorage
- Shortcode [re7mc_switcher] added
- Uninstall cleanup included