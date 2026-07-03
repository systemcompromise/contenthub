<?php

function getAllowedOrigins(): array {
    $configured = getenv('ALLOWED_ORIGINS') ?: FRONTEND_URL;
    $origins = array_map('trim', explode(',', $configured));
    return array_filter($origins);
}

function applyCorsHeaders(): void {
    $allowedOrigins = getAllowedOrigins();
    $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if (in_array($requestOrigin, $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: ' . $requestOrigin);
        header('Vary: Origin');
    }

    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    header('Access-Control-Max-Age: 86400');
}
