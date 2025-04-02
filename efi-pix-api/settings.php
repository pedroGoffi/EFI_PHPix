<?php
/**
 * Register plugin settings
 *
 * @return void
 */

  

function efi_pix_register_settings(): void {
    // Register API keys and webhook URL    
    register_setting('efi_pix_options_group', 'efi_pix_client_id');
    register_setting('efi_pix_options_group', 'efi_pix_client_secret');
    register_setting('efi_pix_options_group', 'efi_pix_webhook_url');
}

/**
 * Display settings page
 *
 * @return void
 */
function efi_pix_settings_page(): void {
    ?>
    <div class="wrap">
        <h1>EFI Pix Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('efi_pix_options_group');
            do_settings_sections('efi_pix_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Client ID</th>
                    <td><input type="text" name="efi_pix_client_id" value="<?php echo esc_attr(get_option('efi_pix_client_id')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Client Secret</th>
                    <td><input type="text" name="efi_pix_client_secret" value="<?php echo esc_attr(get_option('efi_pix_client_secret')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Webhook URL</th>
                    <td><input type="text" name="efi_pix_webhook_url" value="<?php echo esc_attr(get_option('efi_pix_webhook_url')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
