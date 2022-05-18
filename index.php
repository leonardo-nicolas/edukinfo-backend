<?php
namespace EdukInfo;

use DateTime;
use EdukInfo\Models\EnderecoUsuario;
use EdukInfo\Models\Estado;
use EdukInfo\Models\Genero;
use EdukInfo\Models\TelefoneUsuario;
use EdukInfo\Models\Usuario;

require_once __DIR__ . "/inicializador.php";

$dados = new Usuario();

$dados
    ->setNome('Leonardo')
    ->setSobrenome('Nicolas Sales Dias')
    ->setEmail('leonardon397@hotmail.com')
    ->setDocumento('PF148.038.897-16')
    ->setGenero(Genero::masculino)
    ->setAniversario(new DateTime('1994-11-16'))
    ->setTelefonesUsuario(
        ((new TelefoneUsuario(58))
            ->setDescricao('Meu Celular secundário')
            ->setDDD(22)
            ->setTelefone('98155-1621')
            ->setChamadas(true)
            ->setSMS(true)
            ->setWhatsApp(false)
            ->setTelegram(false)
            ->setWeChat(false)),
        ((new TelefoneUsuario(54))
            ->setDescricao('Meu Celular principal')
            ->setDDD(21)
            ->setTelefone('99509-5174')
            ->setChamadas(true)
            ->setSMS(true)
            ->setWhatsApp(true)
            ->setTelegram(true)
            ->setWeChat(false))

    )
    ->setEnderecosUsuario(
        ((new EnderecoUsuario())
            ->setDescricao('Endereço de Casa')
            ->setFinalidade('cobrança')
            ->setCep('28943-518')
            ->setEndereco('Rua B')
            ->setNumero(12)
            ->setComplemento('Casa 2, Fundos')
            ->setBairro('Vinhateiro')
            ->setCidade('São Pedro da Aldeia')
            ->setEstado(Estado::RioDeJaneiro)
        ),
        ((new EnderecoUsuario())
            ->setDescricao('Endereço do João')
            ->setFinalidade('entrega')
            ->setCep('28943518')
            ->setEndereco('Rua Imbitiba')
            ->setNumero(572)
            ->setBairro('Laranjal')
            ->setCidade('São Gonçalo')
            ->setEstado(Estado::RioDeJaneiro)
        )
    );

echo json_encode($dados->toJsonArray());