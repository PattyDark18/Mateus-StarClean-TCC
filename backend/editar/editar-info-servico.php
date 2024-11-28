<?php 


include_once '../../backend/classes/Servicos/ArmazenarServicos.php';
session_start(); // Certifique-se de iniciar a sessão aqui
// Obtém o serviço ID

$armazenarServico = new ArmazenarServicoMYSQL();
$ServicoID = $_GET['ServicoID'];

// Foto 1
if (isset($_FILES['Foto1']) && $_FILES['Foto1']['error'] === UPLOAD_ERR_OK) {
    // Se a foto foi selecionada, atualize
    $caminhoFoto1 = $_FILES['Foto1']['name'];
    $extensaoFoto1 = pathinfo($caminhoFoto1, PATHINFO_EXTENSION);
    $nomeFoto1 = uniqid() . "." . $extensaoFoto1;
    $caminhoCompletoFoto1 = "../../src/uploads/fotos/" . $nomeFoto1;
    move_uploaded_file($_FILES['Foto1']['tmp_name'], $caminhoCompletoFoto1);
    $conteudoImagem1 = $nomeFoto1;
} else {
    // Se não, mantenha a existente
    $conteudoImagem1 = $armazenarServico->buscarFoto1($ServicoID);
}

// Foto 2
if (isset($_FILES['Foto2']) && $_FILES['Foto2']['error'] === UPLOAD_ERR_OK) {
    $caminhoFoto2 = $_FILES['Foto2']['name'];
    $extensaoFoto2 = pathinfo($caminhoFoto2, PATHINFO_EXTENSION);
    $nomeFoto2 = uniqid() . "." . $extensaoFoto2;
    $caminhoCompletoFoto2 = "../../src/uploads/fotos/" . $nomeFoto2;
    move_uploaded_file($_FILES['Foto2']['tmp_name'], $caminhoCompletoFoto2);
    $conteudoImagem2 = $nomeFoto2;
} else {
    $conteudoImagem2 = $armazenarServico->buscarFoto2($ServicoID);
}

// Foto 3
if (isset($_FILES['Foto3']) && $_FILES['Foto3']['error'] === UPLOAD_ERR_OK) {
    $caminhoFoto3 = $_FILES['Foto3']['name'];
    $extensaoFoto3 = pathinfo($caminhoFoto3, PATHINFO_EXTENSION);
    $nomeFoto3 = uniqid() . "." . $extensaoFoto3;
    $caminhoCompletoFoto3 = "../../src/uploads/fotos/" . $nomeFoto3;
    move_uploaded_file($_FILES['Foto3']['tmp_name'], $caminhoCompletoFoto3);
    $conteudoImagem3 = $nomeFoto3;
} else {
    $conteudoImagem3 = $armazenarServico->buscarFoto3($ServicoID);
}

// Foto 4
if (isset($_FILES['Foto4']) && $_FILES['Foto4']['error'] === UPLOAD_ERR_OK) {
    $caminhoFoto4 = $_FILES['Foto4']['name'];
    $extensaoFoto4 = pathinfo($caminhoFoto4, PATHINFO_EXTENSION);
    $nomeFoto4 = uniqid() . "." . $extensaoFoto4;
    $caminhoCompletoFoto4 = "../../src/uploads/fotos/" . $nomeFoto4;
    move_uploaded_file($_FILES['Foto4']['tmp_name'], $caminhoCompletoFoto4);
    $conteudoImagem4 = $nomeFoto4;
} else {
    $conteudoImagem4 = $armazenarServico->buscarFoto4($ServicoID);
}

// Foto 5
if (isset($_FILES['Foto5']) && $_FILES['Foto5']['error'] === UPLOAD_ERR_OK) {
    $caminhoFoto5 = $_FILES['Foto5']['name'];
    $extensaoFoto5 = pathinfo($caminhoFoto5, PATHINFO_EXTENSION);
    $nomeFoto5 = uniqid() . "." . $extensaoFoto5;
    $caminhoCompletoFoto5 = "../../src/uploads/fotos/" . $nomeFoto5;
    move_uploaded_file($_FILES['Foto5']['tmp_name'], $caminhoCompletoFoto5);
    $conteudoImagem5 = $nomeFoto5;
} else {
    $conteudoImagem5 = $armazenarServico->buscarFoto5($ServicoID);
}

// Atualiza as informações do serviço
$armazenarServico->atualizarServico($_POST['servico'], $_POST['preco'], $_POST['descricao'], $_POST['vantagens'], $_POST['duracao'], $conteudoImagem1, $conteudoImagem2, $conteudoImagem3, $conteudoImagem4, $conteudoImagem5, $ServicoID);
$_SESSION['mensagem'] = "Informações alteradas com sucesso!";
header('Location: ../../html/adm/editar_servicos.php');
exit();

?>

