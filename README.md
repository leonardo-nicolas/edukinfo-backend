# Backend do projeto [EdukInfo](https://github.com/leonardon397/edukinfo) (Comércio eletrônico fictício)

## Seja bem-vindo!

## Este projeto ainda está em desenvolvimento. 
* Nele esta sendo utilizado a linguagem **PHP**, na versão **8.1**
* Foi utilizado orientação a objetos;
* Sem nenhum uso de frameworks NO MOMENTO
* Banco de dados MySQL
#### As bibliotecas adicionais serão (Todas adicionadas via `composer`):
* PHPMailer para envio de e-mail (diferente da função `mail` nativo do próprio PHP), devido a fornecimento de suporte a SMTP, anexos (dependendo da ocasião, etc.).
* Criptografia de senhas com BCrypt
* Será utilizado o JWT para autenticação, etc.

##### Este projeto é apenas um trabalho acadêmico.

Para visualizar todo código fonte deste projeto, alterne para a branch [***dev***](https://github.com/leonardon397/prova-ecommerce-faculdade-av2-backend/tree/dev).


##### Como fazer este projeto funcionar?

Passo 1: Configure o Apache/NGINX para **OCULTAR** as extensões do php.

Passo 2: No Front-end, procure pelo arquivo *environment.ts* e altere o valor de *backendUrl* para o seu localhost, da sua máquina.

Passo 3: Teste direto pelo Front-End ou utilize o Postman.

### Endpoints e dados a enviar:

api/usuarios/login: **SOMENTE POST com MULTIPART/FORM-DATA**
  * Campos:
    * `usuario` e `senha`: Tipo string, OBRIGATÓRIO
    * `validade`: tipo Iso8601DateTime, opcional
  * Retorno: JSON com a seguinte estrutura:
    * { "codErro": int, "mensagem": string }
    * Somente para caso de login mal sucedido, onde, desses dados:
      * `codErro`: Código de erro:
        * 401 para senha inválida.
        * 404 para usuário não encontrado.
      * `mensagem`: Mensagem de erro, caso haja algum erro.
    * { "jwt": string, "validade": DateTime, "usuario": "{...} (JSON com dados do usuário, exceto senha, óbvio)" }
    * Somente para caso de login bem sucedido, onde, desses dados:
      * `jwt`: Token de autenticação. 
      * `validade`: Data de expiração do token.
      * `usuario`: dados do usuário (exceto senha)

api/usuarios/recuperar-senha: **SOMENTE POST com MULTIPART/FORM-DATA**
* Um das seguintes opções de campo(s) é obrigatório:
  * `email`: Quando é informado este campo, automaticamente será enviado um e-mail para o usuário com um link para recuperar a senha.
    * Retorno: { "codigo":int, "mensagem":string }
      * 200: E-mail enviado com sucesso.
      * 404: E-mail não encontrado.
      * 400: algum problema desconhecido, ao enviar o e-mail.
  * (`senha` + `token`) OU (`senha` + `id`): Quando é informado este campo, automaticamente será alterada a senha do usuário.
    * Retorno: { "codigo":int, "mensagem":string }
    * Código 200: Senha alterada com sucesso.
    * Código 400: algum problema desconhecido, ao alterar a senha.
    * Código 403: Token vencido ou já utilizado.
    * Código 404: Token ou ID não encontrado.
  * Enquanto a `mensagem`, é retornado um status para ser exibido ao usuário, no front-end.

 



**OBS.:** Este repositório está sendo diáriamente atualizado.
