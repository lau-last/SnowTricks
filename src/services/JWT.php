<?php

namespace App\services;

class JWT
{

    private array $header = [
        'typ' => 'JWT',
        'alg' => 'HS256',
    ];


    public function generate(array $payload, string $secret, int $validity = 1): string
    {
        if ($validity > 0) {
            $timeStampNow = (new \DateTimeImmutable())->getTimestamp();
            $payload['token_creation'] = $timeStampNow;
            $payload['token_expiration'] = $timeStampNow + (3600 * $validity);
        }

        $base64Header = base64_encode(json_encode($this->header));
        $base64Payload = base64_encode(json_encode($payload));

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);
        $base64Signature = base64_encode($signature);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        return $base64Header . '.' . $base64Payload . '.' . $signature;
    }


    public function check(string $token, string $secret): bool
    {
        $payload = $this->getPayload($token);

        $verifyToken = $this->generate($payload, $secret, 0);
        return $token === $verifyToken;
    }


    public function getHeader(string $token): array
    {
        $array = explode('.', $token);
        return json_decode(base64_decode($array[0], true), true);
    }


    public function getPayload(string $token): array
    {
        $array = explode('.', $token);
        return (json_decode(base64_decode($array[1], true), true));
    }


    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new \DateTimeImmutable();
        return $payload['token_expiration'] < $now->getTimestamp();
    }


    public function isValid(string $token): bool
    {
        return preg_match('/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/', $token) === 1;
    }


}