<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function re7mc_register_settings() {
    register_setting( 're7mc_settings', 're7mc_enable_dropdown' );
    register_setting( 're7mc_settings', 're7mc_default_currency' );
    register_setting( 're7mc_settings', 're7mc_currencies' );
}
add_action( 'admin_init', 're7mc_register_settings' );

function re7mc_settings_page() {
    ?>
    <div class="wrap">
        <h1>RE7 Multi-Currency Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 're7mc_settings' ); ?>
            <table class="form-table">
                <tr>
                    <th>Enable Currency Dropdown</th>
                    <td>
                        <input type="checkbox" name="re7mc_enable_dropdown" value="1" <?php checked( get_option('re7mc_enable_dropdown'), 1 ); ?> />
                        Show currency switcher dropdown
                    </td>
                </tr>
                <tr>
                    <th>Default Currency</th>
                    <td>
                        <input type="text" name="re7mc_default_currency" value="<?php echo esc_attr( get_option('re7mc_default_currency', 'USD') ); ?>" />
                        <p class="description">3-letter code (USD, GBP, IDR)</p>
                    </td>
                </tr>
                <tr>
                    <th>Available Currencies</th>
                    <td>
                        <?php
                        $currencies = get_option( 're7mc_currencies', [
                            'USD' => ['symbol' => '$',  'position' => 'before', 'enabled' => 1, 'rate' => 1],
                            'EUR' => ['symbol' => '€',  'position' => 'before', 'enabled' => 1, 'rate' => 0.91],
                            'IDR' => ['symbol' => 'Rp', 'position' => 'before', 'enabled' => 1, 'rate' => 16500],
                            'GBP' => ['symbol' => '£',  'position' => 'before', 'enabled' => 1, 'rate' => 0.79],
                            'JPY' => ['symbol' => '¥',  'position' => 'before', 'enabled' => 1, 'rate' => 144],
                        ]);
                        foreach ( $currencies as $code => $data ) { ?>
                            <p>
                                <input type="hidden" name="re7mc_currencies[<?php echo esc_attr($code); ?>][enabled]" value="0" />
                                <label>
                                    <input type="checkbox" name="re7mc_currencies[<?php echo esc_attr($code); ?>][enabled]" value="1" <?php checked( ! empty($data['enabled']) ); ?> /> Enable
                                </label>
                                <input type="text" name="re7mc_currencies[<?php echo esc_attr($code); ?>][symbol]" value="<?php echo esc_attr($data['symbol']); ?>" placeholder="Symbol" />
                                <select name="re7mc_currencies[<?php echo esc_attr($code); ?>][position]">
                                    <option value="before" <?php selected($data['position'], 'before'); ?>>Before</option>
                                    <option value="after" <?php selected($data['position'], 'after'); ?>>After</option>
                                </select>
                                <input type="number" step="0.0001" name="re7mc_currencies[<?php echo esc_attr($code); ?>][rate]" value="<?php echo esc_attr($data['rate']); ?>" placeholder="Rate" />
                                (<?php echo esc_html($code); ?>)
                            </p>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function re7mc_add_admin_menu() {
    add_options_page( 'RE7 Multi-Currency', 'RE7 Multi-Currency', 'manage_options', 're7mc-settings', 're7mc_settings_page' );
}
add_action( 'admin_menu', 're7mc_add_admin_menu' );
