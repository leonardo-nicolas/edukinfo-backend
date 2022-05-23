<?php

require_once __DIR__ . "/../inicializador.php";
use EdukInfo\Models\Curso;
header('content-type:application/json;charset=utf-8');
if(isset($_GET['id'])) {
    $curso = Curso::getCursoById(intval($_GET['id']));
    $cursosArrJson = $curso?->toJsonArray(true);
} else {
    $curso = Curso::getTodosCursos();
    $cursosArrJson = [];
    $contCursos = count($curso);
    for ($i = 0; $i < $contCursos; ++$i) {
        $cursosArrJson[] = $curso[$i]->toJsonArray(false);
    }
    unset($curso);
}
echo json_encode($cursosArrJson ?? ["erro"=>404,"mensagem"=>"O curso com este ID não existe!"]);