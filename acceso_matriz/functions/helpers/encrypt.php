<?php

const SECRETKEY = 'your-secret-key';

function encryptValue($value, $secretKey) {
    $iv = random_bytes(16);
    $ciphertext = openssl_encrypt($value, 'aes-256-cbc', $secretKey, 0, $iv);
    return base64_encode($ciphertext . '::' . base64_encode($iv));
}

function decryptValue($encryptedValue, $secretKey) {
    list($ciphertext, $iv) = explode('::', base64_decode($encryptedValue), 2);
    $iv = base64_decode($iv);
    return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
}

// function decryptId($encryptedId, $secretKey) {
//     [$ciphertext, $iv] = explode('::', base64_decode($encryptedId), 2);
//     $iv = base64_decode($iv);
//     return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
// }
