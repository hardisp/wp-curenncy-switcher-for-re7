jQuery(document).ready(function($) {
    $('#re7-mc-dropdown').on('change', function() {
        document.cookie = "re7_mc_currency=" + $(this).val() + "; path=/";
        location.reload();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const currencyKey = 're7mc_currency';
    const expiryTime = 30 * 24 * 60 * 60 * 1000; // 30 days in ms

    function setLocalStorageWithExpiry(key, value, ttl) {
        const now = Date.now();
        const item = {
            value: value,
            expiry: now + ttl,
        };
        localStorage.setItem(key, JSON.stringify(item));
    }

    function getLocalStorageWithExpiry(key) {
        const itemStr = localStorage.getItem(key);
        if (!itemStr) return null;

        try {
            const item = JSON.parse(itemStr);
            if (Date.now() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        } catch {
            localStorage.removeItem(key);
            return null;
        }
    }

    function syncLocalStorageWithCookie() {
        const storedCurrency = getLocalStorageWithExpiry(currencyKey);
        const cookieCurrency = getCookie('re7mc_currency');

        if ((!storedCurrency || storedCurrency !== cookieCurrency) && cookieCurrency) {
            setLocalStorageWithExpiry(currencyKey, cookieCurrency, expiryTime);
        }
    }

    function getCookie(name) {
        const matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()[]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : null;
    }

    syncLocalStorageWithCookie();

    const currencySwitcher = document.querySelector('#currency-switcher-7 select[name="currency"]');
    if (currencySwitcher) {
        currencySwitcher.addEventListener('change', function () {
            setLocalStorageWithExpiry(currencyKey, this.value, expiryTime);
        });
    }
});