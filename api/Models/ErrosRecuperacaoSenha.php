<?php

namespace EdukInfo\Models;

enum ErrosRecuperacaoSenha: int
{
	case ErroInterno = -1;
	case TokenNaoEncontrado = -2;
	case TokenVencido = -3;
}