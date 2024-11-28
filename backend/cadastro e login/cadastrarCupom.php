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
include_once '../classes/Cupom/ArmazenarCupom.php';
include_once '../classes/Cupom/ClassCupom.php';

$ArmazenarCupom = new ArmazenarCupomMYSQL();


// Crie o novo usuário sem o endereço
$NovoCupom = new Cupom('', $_POST['Cupom'], $_POST['valor'], 1);

$ArmazenarCupom->cadastrarCupom($NovoCupom);
header('Location:../../html/adm/editar_cupons.php');
exit;
?>


