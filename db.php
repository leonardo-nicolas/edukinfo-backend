<?php

namespace EdukInfo;

use mysqli;

$bancoDeDados = new MySQLi("localhost","leonardo","mysql","edukinfo",3306);
$bancoDeDados->set_charset("utf8");
return $bancoDeDados;