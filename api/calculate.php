<?php
declare(strict_types=1);

require __DIR__ . '/../src/BmiCalculator.php';

use Bmi\BmiCalculator;

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['error' => 'Use POST.']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '', true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Request body must be valid JSON.']);
    exit;
}

$weight = $input['weight'] ?? null;
$height = $input['height'] ?? null;
$units = $input['units'] ?? 'metric';

if (!is_numeric($weight) || !is_numeric($height) || !is_string($units)) {
    http_response_code(422);
    echo json_encode(['error' => 'Weight and height must be numbers.']);
    exit;
}

try {
    echo json_encode(BmiCalculator::calculate((float) $weight, (float) $height, $units));
} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['error' => $e->getMessage()]);
}
