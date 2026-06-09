<?php
// Simples endpoint para retornar agendamentos cadastrados (apenas leitura para agora)
header('Content-Type: application/json; charset=utf-8');
$dataFile = __DIR__ . '/../data/appointments.json';
if(!file_exists($dataFile)){
    @mkdir(dirname($dataFile), 0755, true);
    file_put_contents($dataFile, json_encode([]));
}
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET'){
    $raw = file_get_contents($dataFile);
    $arr = json_decode($raw, true) ?: [];
    echo json_encode($arr);
    exit;
}

// Para segurança, não aceitamos POST via este endpoint por enquanto.
http_response_code(405);
echo json_encode(['error'=>'Method not allowed']);
exit;
