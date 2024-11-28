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
$Enderecoid = isset($_POST['idEndereco']) ? $_POST['idEndereco'] : null; // ou outra forma de obter o valor


$alterar = $ArmazenarUsuario->atualizarEndereco($_POST['CEP'],$_POST['Rua'], $_POST['Numero'], $_POST['Bairro'],  $_POST['Cidade'],  $_POST['Estado'], $ID);


$_SESSION['mensagem'] = "Informações alteradas com sucesso!";

header('Location: ../../../html/perfil.php?nocache=' . time());
exit();

?>

------------------------------------------------------------------------------------------------------------------------

perfil.php

<?php
session_start();

// Inclua o arquivo com a definição da classe
require_once '../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../backend/classes/servicos/ArmazenarServicos.php';


$ArmazenarServicos = new ArmazenarServicoMYSQL();
$Servico = $ArmazenarServicos -> listarTodosServicos();

$Nome_servicos = isset($_SESSION['nome_servicos']) ? $_SESSION['nome_servicos'] : '';



// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location:forms/login.php');
    exit();
} else {
    $logado = true;
    

    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        unset($_SESSION['mensagem']);
    } else {
        $mensagem = '';
    }


    $user_id = $_SESSION['ID'];
    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
    $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);

    
    $Foto = $_SESSION['foto'];
    $Nome = $_SESSION['nome'];
    $Sobrenome = $_SESSION['sobrenome'];
    $Telefone = $_SESSION['telefone'];
    $Email = $_SESSION['email'];
    $Senha = $_SESSION['senha'];

    $Tipo = $_SESSION['tipo'];
    
    if ($Tipo == 0) {
        $CEP = $usuario['cep'];
        $Rua = $usuario['rua'];
        $Numero = $usuario['numero'];
        $Bairro = $usuario['bairro'];
        $Cidade = $usuario['cidade'];
        $Estado = $usuario['estado'];
      $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);
      if ($Pontos_usuario !== null) {
          $Pontos = $Pontos_usuario['Pontos'];
        }else{
            $Pontos = 0;
          }
  }



  if (isset($_POST['alterar_foto'])) {
    $Foto = $_FILES['foto_perfil']['tmp_name'];
    if ($Foto) {
        $Foto = file_get_contents($Foto);
        $ArmazenarUsuario->AlterarFoto($user_id, $Foto);
        $_SESSION['foto'] = $Foto; // Atualiza a foto na sessão

       

    }
}




}
?>