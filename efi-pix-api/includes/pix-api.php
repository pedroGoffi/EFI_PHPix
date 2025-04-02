<?php
/**
 * Call the EFI Pix API to generate payment information
 *
 * @param float $amount - The payment amount.
 * @param string $order_id - The order identifier.
 * 
 * @return array|false - Returns an array with Pix payment data or false on failure.
 */
function efi_pix_generate_payment(float $amount, string $order_id): array|false {
    // Retrieve API keys and webhook URL from WordPress options
    $client_id      = get_option('efi_pix_client_id');
    $client_secret  = get_option('efi_pix_client_secret');
    $webhook_url    = get_option('efi_pix_webhook_url');
    $base_url       = 'https://efi-bank-api-url.com/';
    
    // Prepare the data to send to the EFI Pix API
    $url = $base_url . 'pix/create';
    $data = [
        'value'             => $amount,
        'transaction_id'    => $order_id,
        'webhook'           => $webhook_url,
    ];

    // Initialize cURL session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_POST, true); // Send as a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Send data in JSON format
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Set the content type to JSON
        'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret) // Add authorization header
    ]);
    
    // Execute the cURL request
    $response = curl_exec($ch);
    curl_close($ch); // Close the cURL session
    
    // Check if the request was successful
    if ($response === false) {
        return false; // Failed to contact the API
    }

    // Return the decoded response (Pix payment data)
    return json_decode($response, true);
}