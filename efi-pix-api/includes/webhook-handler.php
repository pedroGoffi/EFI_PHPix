<?php
/**
 * Handles incoming webhook requests from EFI Bank to confirm Pix payment status.
 * 
 * @return void
 */
function efi_pix_webhook_handler(): void {
    // Check if a user-defined callback is registered via the filter
    $callback = apply_filters('efi_pix_webhook_callback', null);

    if ($callback && is_callable($callback)) {
        // If the user has defined a custom handler, call it
        call_user_func($callback);
    }
}

/**
 * Register the custom webhook endpoint.
 * This function will create a URL rule for WordPress to handle the incoming webhook.
 * 
 * @return void
 */
function register_webhook_endpoint(): void {
    // Register a new rewrite rule for the webhook URL
    add_rewrite_rule('^efi-pix-webhook/?$', 'index.php?efi_pix_webhook=1', 'top');
}
add_action('init', 'register_webhook_endpoint');

/**
 * Process the incoming webhook request.
 * This function will be called to handle the request based on the query var.
 * 
 * @param array $query_vars - Query variables from WordPress
 * 
 * @return void
 */
function process_webhook_request(array $query_vars): void {
    // Check if the request is for the webhook
    if (isset($query_vars['efi_pix_webhook']) && $query_vars['efi_pix_webhook'] === '1') {
        // Handle the webhook using the registered handler
        efi_pix_webhook_handler();
    }
}
add_action('template_redirect', 'process_webhook_request');

/**
 * Add the custom query var to the list of recognized query variables.
 * 
 * @param array $vars - The array of registered query variables
 * 
 * @return array - Updated array of query variables
 */
function add_webhook_query_var(array $vars): array {
    // Add our custom query var to the list of recognized vars
    $vars[] = 'efi_pix_webhook';
    return $vars;
}
add_filter('query_vars', 'add_webhook_query_var');
