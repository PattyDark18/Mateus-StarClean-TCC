<?php
session_start();
include_once '../classes/usuarios/ArmazenarUsuario.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location:../forms/login.php');
    exit();
}


if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}


$user_id = $_SESSION['ID'];
$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();

// Verifica se o arquivo foi enviado corretamente
// Verifica se o arquivo foi enviado corretamente
if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
    $caminhoTemp = $_FILES['Foto']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem = file_get_contents($caminhoTemp);

    // Escapa o conteúdo da imagem para ser armazenado no banco de dados
    $conteudoImagem = base64_encode($conteudoImagem);

    // Atualiza a foto do usuário no banco de dados
    $alterar = $ArmazenarUsuario->AlterarFoto($user_id, $conteudoImagem);

    // Armazena a foto na variável de sessão
    $_SESSION['foto'] = $conteudoImagem;

    // Redireciona para a página de perfil

}

$_SESSION['mensagem'] = "Foto atualizada com sucesso!";


// Redireciona para a página de perfil
header('Location: ../../html/perfil.php');
exit();
?>
