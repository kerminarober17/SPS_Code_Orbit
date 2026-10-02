<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode([
  'ok' => true,
  'service' => 'cody_ping',
  'time' => date('c'),
  'php' => PHP_VERSION,
]);
