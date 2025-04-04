<?php
/** @NOTE: Esse arquivo usa funções do wordpress */
/**
 * Register plugin settings
 *
 * @return void
*/

/**
 * @var array<string, string> $opts Mapeia configurações do EFI Pix para seus tipos de entrada.
 */
$opts = [    
    "efi_pix_client_id"     => "text",
    "efi_pix_client_secret" => "text",
    "efi_pix_key"           => "text",
    "efi_pix_webhook_url"   => "text",
    "efi_cert_path"         => "text",
    "efi_pix_sandbox"       => "checked",
];

function efi_pix_register_settings(): void {
    global $opts;
    foreach ($opts as $key => $type) {
        register_setting('efi_pix_options_group', $key);
    }
}
add_action('admin_init', 'efi_pix_register_settings');

/**
 * Display settings page
 *
 * @return void
 */
function efi_pix_settings_page(): void { 
    global $opts;

    ?>
    <div class="wrap">
        <h1>Configurações EFI Pix</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('efi_pix_options_group');
                do_settings_sections('efi_pix_options_group');
            ?>
            <table class="form-table">
                <?php foreach ($opts as $key => $type): ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr($key); ?>"><?php echo ucfirst(str_replace("_", " ", $key)); ?></label>
                        </th>
                        <td>
                            <?php if ($type === "text"): ?>
                                <input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(get_option($key)); ?>" class="regular-text" />
                            <?php elseif ($type === "checked"): ?>
                                <input type="checkbox" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(get_option($key), '1'); ?> />
                                <label for="<?php echo esc_attr($key); ?>">Ativar</label>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
