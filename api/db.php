<?php

namespace EdukInfo;

use mysqli;

require_once(__DIR__."config.php");
$config = new Config();

$bancoDeDados = new MySQLi(
	$config->bancoDeDados->host,
	$config->bancoDeDados->user,
	$config->bancoDeDados->password,
	$config->bancoDeDados->db,
	$config->bancoDeDados->port
);
$bancoDeDados->set_charset("utf8");
return $bancoDeDados;