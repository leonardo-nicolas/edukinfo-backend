<?php
namespace EdukInfo;
use PHPMailer\PHPMailer\PHPMailer;
if(!class_exists(PHPMailer::class)){
    require_once(__DIR__."/vendor/autoload.php");
}

$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = 'ed1cd457f434ef';
$phpmailer->Password = '8625dae010c11c';
$phpmailer->setFrom('nao-responda@edukinfo.com.br',"EdukInfo escola de tecnologia");
$phpmailer->CharSet = PHPMailer::CHARSET_UTF8;
$phpmailer->setLanguage('br');
return $phpmailer;