<?php

include_once '../../backend/classes/agendamento/ArmazenarAgendamento.php';


$ArmazenarAgendamento = new ArmazenarAgendamentoMYSQL(); // Adicione esta linha

$AgendamentoID = $_GET['id'];
$observacoes = $_GET['observacoes'];

$alterar = $ArmazenarAgendamento->alterarObsAdm($AgendamentoID, $observacoes); // Certifique-se de que alterarstatus existe e está correto


header('Location: ../../html/adm/editar_agendamentos.php');
exit();

?>