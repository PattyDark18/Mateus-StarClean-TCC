<?php
session_start();

// Gerencia a mensagem de sessão
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}

// Inclui a classe para armazenar o usuário
include_once '../classes/usuarios/ArmazenarUsuario.php';
include_once '../classes/usuarios/ClassUsuario.php';

$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();


// Verifica se o arquivo foi enviado corretamente
if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoTemp = $_FILES['Foto']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem = file_get_contents($caminhoTemp);

    // Escapa o conteúdo da imagem para ser armazenado no banco de dados
    $conteudoImagem = base64_encode($conteudoImagem);

} else {
    $conteudoImagem = null; // Sem imagem enviada
}


// Crie o novo usuário sem o endereço
$usuarioNovo = new usuario('', $_POST['Nome'], $_POST['Sobrenome'], $_POST['Telefone'], $_POST['Email'], $_POST['Senha'], $conteudoImagem, 0, 0);

$found = $ArmazenarUsuario->verificarEmail($_POST['Email']);
$linhas = $found->num_rows;

if ($linhas > 0) {
    $_SESSION['mensagem'] = "Erro: email já cadastrado anteriormente. Tente logar em vez disso.";
} else {
    $ArmazenarUsuario->cadastrarUsuario($usuarioNovo);
    $_SESSION['mensagem'] = "Cadastrado com sucesso!";
}

header('Location:../../html/forms/login.php');
exit;
?>
