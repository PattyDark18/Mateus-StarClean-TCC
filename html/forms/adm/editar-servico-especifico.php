<?php
session_start();

require_once '../../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../../backend/classes/Servicos/ArmazenarServicos.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
} else {
    $logado = true;
    $Tipo = $_SESSION['tipo'];

    if ($Tipo == 0) {
        header('Location: ../../home.php');
        exit();
    }
}

$ServicoID = $_GET['id']; // Corrigido
$ArmazenarServico = new ArmazenarServicoMYSQL();
$buscarServico = $ArmazenarServico->buscarServicoParaEditar($ServicoID); // Corrigido

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../css/preset/reset.css">
    <link rel="stylesheet" href="../../../css/fonts.css">
    <link rel="stylesheet" href="../../../css/preset/vars.css">
    <link rel="stylesheet" href="../../../css/preset/modal.css">
    <link rel="stylesheet" href="../../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../../css/form-style/update-servico.css">
    <title>Editar serviço</title>
</head>
<body>
<div class="container">
    <div class="left-section">
        <button class="return"><a href="../../adm/editar_servicos.php"><i class="fas fa-arrow-left"></i></a></button>
        <form id="main-form" action="../../../backend/editar/editar-info-servico.php?ServicoID=<?php echo $ServicoID; ?>" method="post" enctype="multipart/form-data" class="form">
            <div id="form1" class="form-container ativo">
                <div class="form">
                    <h3>Editar Informações do serviço:</h3>
                    <label>Serviço</label>
                    <input type="text" name="servico" value="<?php echo htmlspecialchars($buscarServico['nome_servicos']); ?>" placeholder="Edite o nome do Serviço">
                    <label>Média do Preço</label>
                    <input type="number" name="preco" value="<?php echo htmlspecialchars($buscarServico['preco']); ?>" placeholder="edite o valor">
                    <label>Qual é a média de duração (em horas) desse serviço?</label>
                    <input type="number" name="duracao" value="<?php echo htmlspecialchars($buscarServico['duracao']); ?>" placeholder="digite um número inteiro...">
                    
                    <div class="button-container">
                        <button class="NextFormButton" type="button" onclick="showNextForm('form1', 'form2')">Avançar</button>
                    </div>
                </div>
            </div>

            <div id="form2" class="form-container">
                <div class="form">
                    <h3>Informações do serviço:</h3>
                    <label>Descrição</label>
                    <textarea name="descricao" placeholder="Edite a descrição do serviço..."><?php echo htmlspecialchars($buscarServico['descricao']); ?></textarea>
                    <label>Vantagens</label>
                    <textarea name="vantagens" placeholder="edite as vantagens de fazer esse serviço..."><?php echo htmlspecialchars($buscarServico['vantagens']); ?></textarea>

                    <div class="button-container">
                        <button type="button" class="returnFormButton" onclick="showNextForm('form2', 'form1')">Voltar</button>
                        <button class="NextFormButton" type="button" onclick="showNextForm('form2', 'form3')">Avançar</button>
                    </div>
                </div>
            </div>

            <div id="form3" class="form-container">
                <div class="form">
                    <h3>Escolha as fotos do serviço:</h3>

                    <label for="file-upload-1" class="file-label">Escolher Foto 1 <span class="ok-icon" id="ok-icon-1"><i class="fas fa-check"></i></span></label>
                    <input id="file-upload-1" type="file" onchange="showImagemServico(1)" name="Foto1">

                    <label for="file-upload-2" class="file-label">Escolher foto 2 <span class="ok-icon" id="ok-icon-2"><i class="fas fa-check"></i></span></label>
                    <input id="file-upload-2" type="file" onchange="showImagemServico(2)" name="Foto2">

                    <label for="file-upload-3" class="file-label">Escolher foto 3 <span class="ok-icon" id="ok-icon-3"><i class="fas fa-check"></i></span></label>
                    <input id="file-upload-3" type="file" onchange="showImagemServico(3)" name="Foto3">

                    <label for="file-upload-4" class="file-label">Escolher foto 4 <span class="ok-icon" id="ok-icon-4"><i class="fas fa-check"></i></span></label>
                    <input id="file-upload-4" type="file" onchange="showImagemServico(4)" name="Foto4">

                    <label for="file-upload-5" class="file-label">Escolher foto 5 <span class="ok-icon" id="ok-icon-5"><i class="fas fa-check"></i></span></label>
                    <input id="file-upload-5" type="file" onchange="showImagemServico(5)" name="Foto5">

                    <div class="button-container">
                        <button type="button" class="returnFormButton" onclick="showNextForm('form3', 'form2')">Voltar</button>
                        <button class="NextFormButton" type="submit">Concluir</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="right-section">
        <div id="image-preview-container"></div>

        <div class="footer">
            <div class="footer-grid">
                <div class="footer-column">
                    <a href="https://www.instagram.com/mateuscar_oficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                        <i class="fab fa-instagram instagram-icon"></i>
                    </a>
                </div>
                <div class="footer-column">
                    <a href="https://youtube.com/@mateuscar?feature=shared" target="_blank">
                        <i class="fab fa-youtube youtube-icon"></i>
                    </a>
                </div>
                <div class="footer-column">
                    <a href="https://wa.me/5511982491185" target="_blank">
                        <i class="fab fa-whatsapp whatsapp-icon"></i>
                    </a>
                </div>
                <div class="footer-column">
                    <a href="mailto:mateus_StarClean@gmail.com">
                        <i class="fas fa-envelope email-icon"></i>
                    </a>
                </div>
                <div class="footer-column">
                    <a href="https://maps.app.goo.gl/hVR7QxxeoczKUuWg6" target="_blank">
                        <i class="fas fa-map-marker-alt location-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showNextForm(currentFormId, nextFormId) {
    // Ocultar o formulário atual
    const currentFormElement = document.getElementById(currentFormId);
    currentFormElement.classList.remove('ativo');

    // Mostrar o próximo formulário
    const nextFormElement = document.getElementById(nextFormId);
    nextFormElement.classList.add('ativo');
}

function showImagemServico(inputNumber) {
    const fileInput = document.getElementById(`file-upload-${inputNumber}`);
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const labelIcon = document.getElementById(`ok-icon-${inputNumber}`);

    // Verifica se há um arquivo selecionado no input específico
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Verifica se já existe uma imagem para o input e atualiza-a, caso contrário, cria uma nova
            let imgElement = document.getElementById(`img-preview-${inputNumber}`);
            if (!imgElement) {
                imgElement = document.createElement('img');
                imgElement.id = `img-preview-${inputNumber}`;
                imgElement.style.maxWidth = "100%";
                imgElement.style.height = "auto";
                imgElement.style.marginBottom = "10px"; // Espaçamento entre as imagens
                imagePreviewContainer.appendChild(imgElement);
            }
            // Define o src da imagem para o resultado do FileReader
            imgElement.src = e.target.result;
        };
        reader.readAsDataURL(fileInput.files[0]);

        // Mostra o ícone de "ok"
        if (labelIcon) {
            labelIcon.style.display = 'inline';
        }
    }
}
</script>

</body>
</html>
