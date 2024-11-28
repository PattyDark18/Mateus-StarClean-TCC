<?php
session_start();




require_once '../../../backend/classes/usuarios/ArmazenarUsuario.php';
require_once '../../../backend/classes/Cupom/ArmazenarCupom.php';


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


  $CupomID = $_GET['id'];
  $ArmazenarCupom = new ArmazenarCupomMYSQL();
  $buscarCupom= $ArmazenarCupom->buscarCupom($CupomID);


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
    <link rel="stylesheet" href="../../../css/form-style/update_cupom.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Editar Cupom</title>
</head>
<body>




<div class="container">
    <div class="left-section">
        <button class="return"><a href="../../adm/editar_cupons.php"><i class="fas fa-arrow-left"></i></a></button>
        <div class="add-info">
            <h2 class="info-h2">Editar Cupom</h2>
         
            <h3>Lembre-se que: </h3>
            <ul>
                <li>O cupom deve conter 7 caracteres;</li>
                <li>Deve Conter Números e letras;</li>
                <li>Deve conter um valor entre 1 e 500 pontos;</li>
                <li>Deve Conter ese formato: XXX-XXXX</li>
            </ul>

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
    <form id="main-form" action="../../../backend/editar/cupom/editarCupom.php?Cupomid=<?php echo $CupomID; ?>" method="post" enctype="multipart/form-data" class="form">
        <div id="form1" class="form-container ativo">
        <div class="form">
        
        <input type="text" name="codigo"  placeholder="Codigo do cupom" value="<?php echo htmlspecialchars($buscarCupom['codigo']); ?>">

        <input type="number" name="Valor" placeholder="Valor do cupom" value="<?php echo htmlspecialchars($buscarCupom['valor']); ?>">

            

                <div class="button-container">
                <button class="concluir-btn" type="submit">Editar</button>
                </div>
        </div>
        </div>
    </form>
    </div>
</div>


</body>
</html>