<?php

namespace EdukInfo\Models;

use EdukInfo\Functions\FuncoesDiversas;

enum Estado:string
{
    case desconhecido = "";
    case Rondonia = "RO";
    case Acre = "AC";
    case Amazonas = "AM";
    case Roraima = "RR";
    case Para = "PA";
    case Amapa = "AP";
    case Tocantins = "TO";
    case Maranhao = "MA";
    case Piaui = "PI";
    case Ceara = "CE";
    case RioGrandeDoNorte = "RN";
    case Paraiba = "PB";
    case Pernambuco = "PE";
    case Alagoas = "AL";
    case Sergipe = "SE";
    case Bahia = "BA";
    case MinasGerais = "MG";
    case EspiritoSanto = "ES";
    case RioDeJaneiro = "RJ";
    case SaoPaulo = "SP";
    case Parana = "PR";
    case SantaCatarina = "SC";
    case RioGrandeDoSul = "RS";
    case MatoGrossoDoSul = "MS";
    case MatoGrosso = "MT";
    case Goias = "GO";
    case DistritoFederal = "DF";
    public static function parse(string $estado): Estado {
        $estado = FuncoesDiversas::removerAcentos($estado);
        $estados = self::cases();
        $estado = self::some_case_to_normal_case($estado);
        $estado = str_replace(' ','',$estado);
        $estado = strtolower($estado);
        for($indice=0;$indice<=27;++$indice) {
            if(strtolower($estados[$indice]->name) === 'desconhecido') {
                continue;
            }
            if(
                strtolower($estados[$indice]->name) === $estado || //nome inteiro
                strtolower($estados[$indice]->value) === $estado //sigla
            ) {
                return $estados[$indice];
            }
        }
        return self::desconhecido;
    }
    private static function some_case_to_normal_case(string $str):string {
        $separacoes = preg_split('/(?=[A-Z])|([\\-_\\s])/', $str);
        unset($str);
        $str="";
        foreach ($separacoes as $juncaoEstado){
            if($juncaoEstado !== '') {
                $str .= strtoupper(substr($juncaoEstado, 0, 1));
                $str .= strtolower(substr($juncaoEstado, 1));
                $str .= " ";
            }
        }
        unset($juncaoEstado,$separacoes);
        return $str;
    }
}