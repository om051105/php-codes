<?php
// Simple dev-only endpoint for auto-reload.
// Returns JSON: {"mtime": 123456789}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$requested = $_GET['file'] ?? '/index.php';
if (!is_string($requested) || $requested === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file'], JSON_UNESCAPED_SLASHES);
    exit;
}

// Only allow paths under the web root.
$docRoot = $_SERVER['DOCUMENT_ROOT'] ?? getcwd();
$docRootReal = realpath($docRoot);
if ($docRootReal === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Server misconfigured'], JSON_UNESCAPED_SLASHES);
    exit;
}

$requested = '/' . ltrim($requested, '/');
$target = realpath($docRootReal . $requested);

if ($target === false || strncmp($target, $docRootReal, strlen($docRootReal)) !== 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found'], JSON_UNESCAPED_SLASHES);
    exit;
}

$mtime = @filemtime($target);
if ($mtime === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot stat file'], JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode(['mtime' => $mtime], JSON_UNESCAPED_SLASHES);
