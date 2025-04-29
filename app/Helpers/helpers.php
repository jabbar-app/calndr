<?php

if (!function_exists('autolink')) {
    function autolink($text)
    {
        return preg_replace(
            '~(https?://[^\s<]+)~i',
            '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">$1</a>',
            $text
        );
    }
}

if (!function_exists('blur_phone')) {
    function blur_phone($phone)
    {
        return substr($phone, 0, 4) . str_repeat('*', max(0, strlen($phone) - 7)) . substr($phone, -3);
    }
}

if (!function_exists('blur_email')) {
    function blur_email($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1] ?? '';
        $blurred = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 4)) . substr($name, -1);
        return $blurred . '@' . $domain;
    }
}
