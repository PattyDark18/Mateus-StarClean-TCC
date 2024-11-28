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
include_once '../classes/Servicos/ArmazenarServicos.php';
include_once '../classes/Servicos/ClassServicos.php';

$ArmazenarServicos = new ArmazenarServicoMYSQL();

// ...

if (isset($_FILES['foto1']) && $_FILES['foto1']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoFoto1 = $_FILES['foto1']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem1 = file_get_contents($caminhoFoto1);

    // Define o nome do arquivo
    $nomeArquivo1 = basename($_FILES['foto1']['name']);

    // Define o caminho do diretório onde as fotos serão armazenadas
    $diretorioFotos = '../../src/uploads/fotos/';

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($diretorioFotos)) {
        mkdir($diretorioFotos, 0777, true);
    }

    // Move o arquivo para o diretório
    $extensaoFoto1 = pathinfo($nomeArquivo1, PATHINFO_EXTENSION);
    $nomeFoto1 = uniqid() . "." . $extensaoFoto1;
    move_uploaded_file($caminhoFoto1, $diretorioFotos . $nomeFoto1);

    // Armazena o nome do arquivo no banco de dados
    $foto1 = $nomeFoto1;
} else {
    $foto1 = null; // Sem imagem enviada
}

if (isset($_FILES['foto2']) && $_FILES['foto2']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoFoto2 = $_FILES['foto2']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem2 = file_get_contents($caminhoFoto2);

    // Define o nome do arquivo
    $nomeArquivo2 = basename($_FILES['foto2']['name']);

    // Define o caminho do diretório onde as fotos serão armazenadas
    $diretorioFotos = '../../src/uploads/fotos/';

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($diretorioFotos)) {
        mkdir($diretorioFotos, 0777, true);
    }

    // Move o arquivo para o diretório
    $extensaoFoto2 = pathinfo($nomeArquivo2, PATHINFO_EXTENSION);
    $nomeFoto2 = uniqid() . "." . $extensaoFoto2;
    move_uploaded_file($caminhoFoto2, $diretorioFotos . $nomeFoto2);

    // Armazena o nome do arquivo no banco de dados
    $foto2 = $nomeFoto2;
} else {
    $foto2 = null; // Sem imagem enviada
}

if (isset($_FILES['foto3']) && $_FILES['foto3']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoFoto3 = $_FILES['foto3']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem3 = file_get_contents($caminhoFoto3);

    // Define o nome do arquivo
    $nomeArquivo3 = basename($_FILES['foto3']['name']);

    // Define o caminho do diretório onde as fotos serão armazenadas
    $diretorioFotos = '../../src/uploads/fotos/';

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($diretorioFotos)) {
        mkdir($diretorioFotos, 0777, true);
    }

    // Move o arquivo para o diretório
    $extensaoFoto3 = pathinfo($nomeArquivo3, PATHINFO_EXTENSION);
    $nomeFoto3 = uniqid() . "." . $extensaoFoto3;
    move_uploaded_file($caminhoFoto3, $diretorioFotos . $nomeFoto3);

    // Armazena o nome do arquivo no banco de dados
    $foto3 = $nomeFoto3;
} else {
    $foto3 = null; // Sem imagem enviada
}

if (isset($_FILES['foto4']) && $_FILES['foto4']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoFoto4 = $_FILES['foto4']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem4 = file_get_contents($caminhoFoto4);

    // Define o nome do arquivo
    $nomeArquivo4 = basename($_FILES['foto4']['name']);

    // Define o caminho do diretório onde as fotos serão armazenadas
 $diretorioFotos = '../../src/uploads/fotos/';

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($diretorioFotos)) {
        mkdir($diretorioFotos, 0777, true);
    }

    // Move o arquivo para o diretório
    $extensaoFoto4 = pathinfo($nomeArquivo4, PATHINFO_EXTENSION);
    $nomeFoto4 = uniqid() . "." . $extensaoFoto4;
    move_uploaded_file($caminhoFoto4, $diretorioFotos . $nomeFoto4);

    // Armazena o nome do arquivo no banco de dados
    $foto4 = $nomeFoto4;
} else {
    $foto4 = null; // Sem imagem enviada
}

if (isset($_FILES['foto5']) && $_FILES['foto5']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo
    $caminhoFoto5 = $_FILES['foto5']['tmp_name'];

    // Lê o conteúdo binário do arquivo
    $conteudoImagem5 = file_get_contents($caminhoFoto5);

    // Define o nome do arquivo
    $nomeArquivo5 = basename($_FILES['foto5']['name']);

    // Define o caminho do diretório onde as fotos serão armazenadas
    $diretorioFotos = '../../src/uploads/fotos/';

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($diretorioFotos)) {
        mkdir($diretorioFotos, 0777, true);
    }

    // Move o arquivo para o diretório
    $extensaoFoto5 = pathinfo($nomeArquivo5, PATHINFO_EXTENSION);
    $nomeFoto5 = uniqid() . "." . $extensaoFoto5;
    move_uploaded_file($caminhoFoto5, $diretorioFotos . $nomeFoto5);

    // Armazena o nome do arquivo no banco de dados
    $foto5 = $nomeFoto5;
} else {
    $foto5 = null; // Sem imagem enviada
}



$ServicoNovo = new Servicos('', $_POST['Servico'], $_POST['preco'], $_POST['descricao'], $_POST['Vantagens'], 1, $_POST['duracao'], $foto1, $foto2, $foto3, $foto4, $foto5);

$ArmazenarServicos->cadastrarServico($ServicoNovo);
header('Location:../../html/adm/editar_servicos.php');
exit;
?>

