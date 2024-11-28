<?php
session_start();
include_once '../../backend/classes/agendamento/ArmazenarAgendamento.php';


$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL(); // Adicione esta linha

$AgendamentoID = $_GET['id'];


$excluir = $ArmazenarAgendamento->removerAgendamento($AgendamentoID); // Certifique-se de que alterarstatus existe e está correto

$_SESSION['mensagem'] = "Agendamento excluido.";
header('Location: ../../html/meus_agendamentos.php');
exit();

?>
