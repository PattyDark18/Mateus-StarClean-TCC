<?php 

include_once '../../classes/usuarios/ArmazenarUsuario.php';
session_start(); // Certifique-se de iniciar a sessão aqui


if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}


$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();

$ID = $_GET['id'];

// Criptografa a senha nova antes de chamar o método, se ela for fornecida
$senhaNova = $_POST['SenhaNova'];
// $senhaCripto = '';
// if (!empty($senhaNova)) {
//     $senhaCripto = sha1($senhaNova).sha1('');
// }

// Passa a senha criptografada e o ID corretamente
$alterar = $ArmazenarUsuario->atualizarUsuario($_POST['Nome'], $_POST['Sobrenome'], $_POST['Telefone'], $senhaNova, $ID);
if ($alterar) {
    // Atualiza os dados na sessão com letras minúsculas
    $_SESSION['nome'] = $_POST['Nome'];
    $_SESSION['sobrenome'] = $_POST['Sobrenome'];
    $_SESSION['telefone'] = $_POST['Telefone'];
    
    // Define uma mensagem de sucesso para feedback do usuário
    $_SESSION['mensagem'] = "Informações alteradas com sucesso!";
    
    // Redireciona para a página de perfil e previne cache
    header('Location: ../../../html/perfil.php?nocache=' . time());
    exit();
} else {
    // Caso ocorra algum erro na atualização
    $_SESSION['mensagem'] = "Erro ao atualizar as informações!";
    header('Location: ../../../html/perfil.php?nocache=' . time());
    exit();
}


?>