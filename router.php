<?php
// Vercel entry point: dispatches requests to the correct PHP page.
// Static assets (assets/, robots.txt, sitemap.xml) are handled before
// this script by Vercel's CDN via the "handle: filesystem" route.
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';

if (str_starts_with($path, '/api/appointments')) {
    require __DIR__ . '/api/appointments.php';
} elseif ($path === '/schedule' || $path === '/schedule.php') {
    require __DIR__ . '/schedule.php';
} else {
    require __DIR__ . '/index.php';
}
