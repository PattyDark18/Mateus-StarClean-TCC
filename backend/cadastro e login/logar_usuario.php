<?php
session_start();

// Verifica e limpa a mensagem de sessão (mensagens de sucesso ou erro)
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}

// Inclui o arquivo de processamento de usuários
include_once '../classes/usuarios/ArmazenarUsuario.php';

// Obtém as credenciais do POST
$email = $_POST['Email'];
$senha = $_POST['Senha'];
$senha_cripto = sha1($senha).sha1('');

// Cria uma instância de ArmazenarUsuario
$ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
$usuario = $ArmazenarUsuario->verificarLogin($email, $senha_cripto);

if ($usuario) {
    // Login realizado com sucesso
    $_SESSION['ID'] = $usuario['ID'];


    $_SESSION['logado'] = true;
    $_SESSION['nome'] = $usuario['Nome'];
    $_SESSION['sobrenome'] = $usuario['Sobrenome'];
    $_SESSION['telefone'] = $usuario['Telefone'];
    $_SESSION['email'] = $usuario['Email'];
    $_SESSION['senha'] = $usuario['Senha'];
    $_SESSION['tipo'] = $usuario['Tipo']; // Novo campo Tipo
    $_SESSION['foto'] = $usuario['Foto'];
    $_SESSION['pontos'] = $usuario['Pontos']; 


    $_SESSION['cep'] = $usuario['cep'];
    $_SESSION['rua'] = $usuario['rua'];
    $_SESSION['numero'] = $usuario['numero'];
    $_SESSION['bairro'] = $usuario['bairro'];
    $_SESSION['cidade'] = $usuario['cidade'];
    $_SESSION['estado'] = $usuario['estado'];







    // Define a mensagem de sucesso e redireciona
    $_SESSION['mensagem'] = 'Login realizado com sucesso!';
    header('Location: ../../html/home.php');
    exit();
} else {
    // Login falhou
    $_SESSION['logado'] = false;
    $_SESSION['mensagem'] = 'Email ou senha incorretos.';
    header('Location: ../../html/forms/login.php');
    exit();
}
?>
