<?php
/**
 * Este arquivo é parte do programa EdukInfo, um trabalho acadêmico desenvolvido
 * por um grupo de alunos da Universidade Estácio de Sá.
 *
 * Este arquivo é apenas para distribuir as configurações básicas, já definidas
 * como objetos fortemente tipados e aptos a serem lidos pelo Intellisense das IDE's
 * JetBrains PhpStorm, eclipse, Netbeans, VS Code ou qualquer outro editor inteligente, ou IDE.
 *
 * Existe um arquivo JSON no diretório deste "config.php" que é o arquivo de configuração no qual pode ser exposto,
 * sem preocupações com credenciais. Na minha máquina tem o arquivo JSON, com o mesmo conteúdo, mas está com nome
 * diferente (config-local.json) e está listado no ".gitignore" (ou seja, não está sendo rastreado). Assim, evita-se
 * exposições de credenciais e outros dados sensíveis.
 */
namespace EdukInfo;
const ARQUIVO_JSON_CONFIG = __DIR__ . '/config-local.json';
class ConfigEmail{
	public readonly string $host;
	public readonly int $port;
	public readonly bool $secure;
	public readonly string $senha;
	public readonly string $usuario;
	public function __construct(){
		$jsonFile = file_get_contents(ARQUIVO_JSON_CONFIG);
		$json = json_decode($jsonFile)->mail;
		$this->host = (string)$json->host;
		$this->port = (int)$json->port;
		$this->secure = (bool)$json->secure;
		$this->senha = (string)$json->password;
		$this->usuario = (string)$json->user;
		unset($jsonFile,$json);
	}
}

class ConfigBancoDeDados{
	public readonly string $sgbd;
	public readonly string $host;
	public readonly int $port;
	public readonly string $db;
	public readonly string $user;
	public readonly string $password;
	public function __construct(){
		$jsonFile = file_get_contents(ARQUIVO_JSON_CONFIG);
		$json = json_decode($jsonFile)->db;
		$this->sgbd = (string)$json->sgdb;
		$this->host = (string)$json->host;
		$this->port = (int)$json->port;
		$this->db = (string)$json->db;
		$this->user = (string)$json->user;
		$this->password = (string)$json->password;
		unset($jsonFile,$json);
	}
}

class JWT {
	public readonly string $chave;
	public readonly string $algoritmo;
	public function __construct() {
		$jsonFile = file_get_contents(ARQUIVO_JSON_CONFIG);
		$json = json_decode($jsonFile)->jwt;
		$this->chave = $json->chave;
		$this->algoritmo = $json->criptografia;
	}
}

class Config {
	public readonly ConfigBancoDeDados $bancoDeDados;
	public readonly ConfigEmail $email;
	public readonly JWT $jwt;
	public function __construct() {
		$this->bancoDeDados = new ConfigBancoDeDados();
		$this->email = new ConfigEmail();
		$this->jwt = new JWT();
	}
}