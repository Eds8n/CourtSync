<?php
declare(strict_types=1);

function genererJetonCSRF(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifierJetonCSRF(?string $jeton): bool {
    if (empty($_SESSION['csrf_token']) || empty($jeton)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $jeton);
}