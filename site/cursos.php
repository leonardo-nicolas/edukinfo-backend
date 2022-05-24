<?php

namespace EdukInfo;
require_once __DIR__ . "/../inicializador.php";

use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Models\Curso;


header('content-type:application/json;charset=utf-8');
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $curso = Curso::getCursoById(intval($_GET['id']));
    $cursosArrJson = $curso?->toJsonArray(true);
} else {
    $matchStrAleatorio = ["aleatorio","random","randomico","qualquer","rnd","rand","aleat","qq"];
    if(
        isset($_GET['id']) &&
        in_array(FuncoesDiversas::removerAcentos(strtolower($_GET['id'])),$matchStrAleatorio,true)
    ){
        $curso = Curso::getCursosAleatorios(isset($_GET['limite']) && is_numeric($_GET['limite']) ? $_GET['limite'] : null);
    } elseif(isset($_GET['q'])){
        $curso = Curso::buscarCursosDisponiveis(strval($_GET['q']));
    } else {
        $curso = Curso::getTodosCursos();
    }
    $cursosArrJson = [];
    $contCursos = count($curso);
    for ($i = 0; $i < $contCursos; ++$i) {
        $cursosArrJson[] = (is_array($curso) ? $curso[$i] : $curso)?->toJsonArray(false);
    }
    unset($curso);
}
echo json_encode($cursosArrJson ?? ["erro"=>404,"mensagem"=>"O curso com este ID não existe!"]);