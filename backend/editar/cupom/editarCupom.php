<?php 

include_once '../../../backend/classes/Cupom/ArmazenarCupom.php';
session_start(); // Certifique-se de iniciar a sessão aqui


if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}


$ArmazenarCupom = new ArmazenarCupomMYSQL();

$CupomID = $_GET['Cupomid'];

$alterar = $ArmazenarCupom->atualizarCupom($CupomID, $_POST['codigo'],$_POST['Valor']);



$_SESSION['mensagem'] = "Informações alteradas com sucesso!";

header('Location: ../../../html/adm/editar_cupons.php');
exit();

?>