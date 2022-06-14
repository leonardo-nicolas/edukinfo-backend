<?php
namespace EdukInfo;
use PHPMailer\PHPMailer\PHPMailer;
use EdukInfo;
if(!class_exists(PHPMailer::class)){
    require_once(__DIR__ . "/../vendor/autoload.php");
}

require_once(__DIR__."/config.php");
$config = new Config();

$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = $config->email->host;
$phpmailer->SMTPAuth = $config->email->secure;
$phpmailer->Port = $config->email->port;
$phpmailer->Username = $config->email->usuario;
$phpmailer->Password = $config->email->senha;
$phpmailer->setFrom('nao-responda@edukinfo.com.br',"EdukInfo escola de tecnologia");
$phpmailer->CharSet = PHPMailer::CHARSET_UTF8;
$phpmailer->setLanguage('br');

return $phpmailer;