<?php
session_start();




require_once '../../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../../backend/classes/Premios/ArmazenarPremios.php';


// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
} else {
    $logado = true;
    $Tipo = $_SESSION['tipo'];


    if ($Tipo == 0) {
        header('Location:../../home.php');
        exit();
        
      }
  }


  // $valor = $_GET['campo_fixo'];

  $PremioID = $_GET['id'];
  $ArmazenarPremios = new ArmazenarPremiosMYSQL();
      $buscarPremio= $ArmazenarPremios->buscarCamposPremio($PremioID);

//   if($valor == 100){
//     $ArmazenarPremios = new ArmazenarPremios100MYSQL();
//     $buscarPremio= $ArmazenarPremios->buscarCamposPremio($PremioID);

//   }

// else if($valor == 250){
//     $ArmazenarPremios = new ArmazenarPremios250MYSQL();
//     $buscarPremio= $ArmazenarPremios->buscarCamposPremio($PremioID);

//   }

  
// else if($valor == 500){
//     $ArmazenarPremios = new ArmazenarPremios500MYSQL();
//     $buscarPremio= $ArmazenarPremios->buscarCamposPremio($PremioID);

//   }else{
//     echo "erro: valor do Prêmio invalido";
//   }

  




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
    <link rel="stylesheet" href="../../../css/form-style/update_premio.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Editar Prêmio</title>
</head>
<body>




<div class="container">
    <div class="left-section">
        <button class="return"><a href="../../adm/editar_premios.php"><i class="fas fa-arrow-left"></i></a></button>
        <div class="add-info">
            <h2 class="info-h2">Editar Prêmio</h2>

             
              
       

        </div>

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

    <div class="right-section">
      <form id="main-form" action="../../../backend/editar/premios/premioEspecifico.php?id=<?php echo $PremioID ?>" method="post"  enctype="multipart/form-data" class="form">
        <div id="form1" class="form-container ativo">
          <div class="form">
               
            <h2>Editar Prêmio</h2>
            <label>editar descrição do prêmio:</label>
                <input type="text" name="premio" value="<?php echo $buscarPremio['premio'] ?>"  placeholder="exemplo: 20% de desconto">
      


                <label>Alterar a quantidade de estrelas?</label>
                <select name="premio_qnt" id="premio_qnt" required>
                <option value="" selected disabled>Selecione uma opção</option>
                <option value="100" <?= ($buscarPremio['Valor_Pontos'] == 100) ? 'selected' : ''; ?>>100 estrelas</option>
                <option value="250"<?= ($buscarPremio['Valor_Pontos'] == 250) ? 'selected' : ''; ?>> 250 estrelas</option>
                <option value="500" <?= ($buscarPremio['Valor_Pontos'] == 500) ? 'selected' : ''; ?>>500 estrelas</option>
              </select>
              



                <label> Alterar Tipo de Prêmio:</label>
                <select name="tipo" id="tipo" required onchange="mostrarValorDesconto()">
                <option value="" selected disabled>Selecione uma opção</option>
                <option value="0" <?= ($buscarPremio['tipo'] == 0) ? 'selected' : ''; ?>>Desconto</option>
                <option value="1"<?= ($buscarPremio['tipo'] == 1) ? 'selected' : ''; ?>>Cortesia / outro</option>
                </select>
           

            <div id="valorDescontoContainer" style="display: none;">
            <label>valor do desconto: (porcentagem):</label>
                <input type="number" name="valor_desconto"  value="<?php echo $buscarPremio['valor_desconto'] ?>" placeholder="exemplo: 20">
            </div>


                <div class="button-container">
                  <button class="concluir-btn" type="submit">Editar</button>
                </div>
          </div>
        </div>
      </form>
    </div>
</div>


<script>
// Verifica se a opção "Desconto" está selecionada quando a página é carregada
document.addEventListener("DOMContentLoaded", function() {
    var tipoPremio = document.getElementById("tipo").value;
    var valorDescontoContainer = document.getElementById("valorDescontoContainer");

    if (tipoPremio === "0") {
        valorDescontoContainer.style.display = "block";
    }
});

function mostrarValorDesconto() {
    // Captura o valor do select
    var tipoPremio = document.getElementById("tipo").value;
    var valorDescontoContainer = document.getElementById("valorDescontoContainer");

    // Mostra o valor capturado no console para depuração
    console.log("Valor selecionado:", tipoPremio);

    // Verifica se a opção selecionada é 'Desconto'
    if (tipoPremio === "0") {
        valorDescontoContainer.style.display = "block";
    } else {
        valorDescontoContainer.style.display = "none";
    }
}
    
    </script>
</body>
</html>
