<?php
session_start();
include_once '../../backend/classes/agendamento/ArmazenarAgendamento.php';


$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL(); // Adicione esta linha

$AgendamentoID = $_GET['id'];
$status = $_GET['status'];

$alterar = $ArmazenarAgendamento->alterarStatus($AgendamentoID, $status); // Certifique-se de que alterarstatus existe e está correto


if ($status == 0) {
    $_SESSION['mensagem'] = "Agendamento Concluído!";
}else{
    $_SESSION['mensagem'] = "Agendamento pendente.";
}
header('Location: ../../html/adm/editar_agendamentos.php');
exit();

?>