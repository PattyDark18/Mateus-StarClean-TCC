
<?php

include_once '../../backend/classes/agendamento/ArmazenarAgendamento.php';


$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL(); // Adicione esta linha

$AgendamentoID = $_GET['id'];
$Dia = $_GET['data'];
$Horario = $_GET['horario'];

$alterar = $ArmazenarAgendamento->alterarRemarcar($AgendamentoID, $Dia, $Horario); // Certifique-se de que alterarstatus existe e está correto



    $_SESSION['mensagem'] = "Agendamento remarcado com sucesso!";

header('Location: ../../html/meus_agendamentos.php');
exit();

?> 
