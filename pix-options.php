<?php 
/** @NOTE: dev testing */
require_once __DIR__ . "/vendor/autoload.php";

$certsPath = get_option("efi_cert_path") ? __DIR__ . "/certs/" . get_option("efi_cert_path") : "";

return [
    "efiSettings" => [
        "clientId"        => get_option("efi_pix_client_id") ?: "", // Garantindo um valor padrão
        "clientSecret"    => get_option("efi_pix_client_secret") ?: "", 
        "certificate"     => $certsPath ?: "", // Certificado em base64
        "pwdCertificate"  => "",   
        "sandbox"         => filter_var(get_option("efi_pix_sandbox"), FILTER_VALIDATE_BOOLEAN), 
        "debug"           => false,   
        "timeout"         => 30,      
        "responseHeaders" => true,   
        "webhookUrl"      => get_option("efi_pix_webhook_url") ?: "",
    ],
    "pixSettings" => [
        "chave" => get_option("efi_pix_key") ?: "",
    ]
];
