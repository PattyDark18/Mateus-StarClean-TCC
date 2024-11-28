<?php
require_once 'ArmazenarCupom.php'; 
require_once '../usuarios/ArmazenarUsuario.php';
require_once '../premios/ArmazenarPremios.php';

session_start();
$codigoDigitado = $_POST['codigoCupom'];

$armazenarCupom = new ArmazenarCupomMYSQL();
$armazenarUsuario = new ArmazenarUsuarioMYSQL();
$armazenarPremios = new ArmazenarPremiosMYSQL();



$valorCupom = $armazenarCupom->verificarCupom($codigoDigitado);

if ($valorCupom !== false) {

    $user_id = $_SESSION['ID'];
    $armazenarUsuario->adicionarPontos($user_id, $valorCupom);
    $armazenarCupom->atualizarStatusCupom($codigoDigitado);
    
    // Buscar a pontuação atual do usuário
    $Pontos_usuario = $armazenarUsuario->buscarPontosUsuario($user_id);
    $Pontos = $Pontos_usuario['Pontos'];
    $_SESSION['Pontos'] = $Pontos_usuario['Pontos'];
    


    
    // Verificar o nível de pontos atingido antes e depois de adicionar o cupom
    $pontosAntes = $Pontos - $valorCupom;  // Pontuação antes de adicionar o cupom

    $premiosAtivos = $armazenarPremios->listarPremiosAtivos();

    $mensagem = "";
    $desbloqueouMeta = false;

    $premio100 = null;
    $premio250 = null;
    $premio500 = null;

    foreach ($premiosAtivos as $premio) {
        if ($premio['Valor_Pontos'] == 100) {
            $premio100 = $premio;
        }
        if ($premio['Valor_Pontos'] == 250) {
            $premio250 = $premio;
        }
        if ($premio['Valor_Pontos'] == 500) {
            $premio500 = $premio;
        }
    }

    // Verificar prêmios desbloqueados
    if ($pontosAntes < 100 && $Pontos >= 100) {
         $mensagem = "Parabéns! Você desbloqueou uma passagem da trilha: 100 Estrelas! Prêmio:" .$premio100['premio'];
        $desbloqueouMeta = true;
        
    }
    
    if ($pontosAntes < 250 && $Pontos >= 250) {
        $mensagem = "Parabéns! Você desbloqueou uma passagem da trilha: 250 Estrelas! Prêmio:" .$premio250['premio'];
        $desbloqueouMeta = true;
        
    }
    
    if ($pontosAntes < 500 && $Pontos >= 500) {
        $mensagem = "Parabéns! Você desbloqueou um prêmio de 500 pontos: " . $premio500['premio'];
        $desbloqueouMeta = true;
        
    } 

    // Se não desbloqueou um nível, exibir a mensagem normal
    if (!$desbloqueouMeta) {
        $mensagem = "Cupom resgatado com sucesso! Você ganhou $valorCupom Estrelas";
    }
    
    // Exibir a pontuação atual do usuário

} else {
    $mensagem = "Código do cupom inválido. Por favor, tente novamente.";
}


$_SESSION['mensagem'] = $mensagem;





header("Location: ../../../html/pontos.php");
 exit();
?>