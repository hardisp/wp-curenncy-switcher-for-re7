<?php
if (!defined('ABSPATH'))
    exit;

function re7mc_currency_switcher_shortcode()
{
    $enabled = get_option('re7mc_enable_dropdown', 1);
    if (!$enabled) {
        return '';
    }

    $currencies = re7mc_get_normalized_currencies();
    $active_currencies = [];

    foreach ($currencies as $code => $data) {
        if (!empty($data['enabled'])) {
            $active_currencies[$code] = $data;
        }
    }

    if (empty($active_currencies)) {
        // Maybe add a default currency, like USD
        $active_currencies['USD'] = [
            'enabled' => 1,
            'name' => 'US Dollar',
        ];
    }

    ob_start(); ?>
    <form method="get" class="re7mc-currency-switcher" id="currency-switcher-7">
        <div class="currency-switcher-row">
            <span class="span-label"></span>
            <select name="currency" onchange="this.form.submit()">
            <?php foreach ($active_currencies as $code => $data): ?>
                <option value="<?php echo esc_attr($code); ?>" <?php selected(re7mc_get_current_currency(), $code); ?>>
                    <?php echo esc_html($code); ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('re7mc_switcher', 're7mc_currency_switcher_shortcode');
