<?php

const SECRETKEY = 'fG$92h@1LhNpE5qZmYxXoKdC8vW3tRs!';

function encryptValue($value, $secretKey) {
    $iv = random_bytes(16);
    $ciphertext = openssl_encrypt($value, 'aes-256-cbc', $secretKey, 0, $iv);

    return base64_encode(base64_encode($ciphertext) . '::' . base64_encode($iv));
}


function decryptValue($encryptedValue, $secretKey) {
    $decoded = base64_decode($encryptedValue);

    if (!str_contains($decoded, '::')) return false;

    [$ciphertext_b64, $iv_b64] = explode('::', $decoded, 2);

    $ciphertext = base64_decode($ciphertext_b64);
    $iv = base64_decode($iv_b64);

    return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
}
