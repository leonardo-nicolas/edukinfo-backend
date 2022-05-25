<?php

namespace EdukInfo;
require_once __DIR__ . '/../inicializador.php';
use EdukInfo\Models\Unidades;

header('Content-Type: application/json;charset=utf-8');
echo json_encode(Unidades::getAllUnidades()->toJsonArray());