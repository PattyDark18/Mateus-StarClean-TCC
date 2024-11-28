<?php
session_start();

// Gerencia a mensagem de sessão
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Limpa a mensagem da sessão após recuperá-la
} else {
    $mensagem = '';
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/preset/reset.css">
    <link rel="stylesheet" href="../../css/fonts.css">
    <link rel="stylesheet" href="../../css/preset/modals.css">
    <link rel="stylesheet" href="../../css/preset/vars.css">
    <link rel="stylesheet" href="../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../css/form-style/cadastro.style.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Cadastre-se</title>

</head>
<body>

<div class="container">
    <div class="left-section">
        <button class="return"><a href="../home.php"><i class="fas fa-arrow-left"></i></a></button>
        <div class="welcome-info">
            <h2 class="welcome">Crie sua Conta</h2>
            <p>Crie uma conta para poder agendar serviços e muito mais!</p>
            <div class="redirect-container">
                <h3 class="redirect-text">Já possui uma conta?</h3>
                <button class="redirect-button"><a href="login.php">Faça login</a></button>
            </div>
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
            <i style="color:white" class="fab fa-whatsapp whatsapp-icon"></i>
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
      <form id="main-form" action="../../backend/cadastro e login/novo_usuario.php" method="post"  enctype="multipart/form-data" class="form">
        <div id="form1" class="form-container ativo">
          <div class="form">
                <h3>Informações Pessoais (Obrigatório)</h3>
                <input type="text" name="Nome" placeholder="Nome" required>
                <input type="text" name="Sobrenome" placeholder="Sobrenome" required>
                <input type="tel" name="Telefone" placeholder="Telefone" required>
                <input type="email" name="Email" placeholder="E-mail" required>
                <div class="password-container">
                    <input type="password" id="password" name="Senha" placeholder="Senha" required>
                    <i id="togglePassword" class="fas fa-eye"></i>
                </div>

                <div class="button-container">
                  <button class="NextFormButton" type="button" onclick="showNextForm('form1', 'form2')">Avançar</button>
                </div>
          </div>
        </div>

 
        <div id="form2" class="form-container">
            <div class="form">
                <h3>Escolha uma foto de perfil (opcional)</h3>
                <img id="profile-pic" src="https://voxnews.com.br/wp-content/uploads/2017/04/unnamed.png" alt="Foto de Perfil">
                <label for="file-upload" class="file-label">Escolher arquivo</label>
                <input id="file-upload" type="file" onchange="updateProfilePic()" name="Foto">
                <div class="button-container">
                  <button type="button" class="returnFormButton" onclick="showNextForm('form2', 'form1')">Voltar</button>
                  <button class="creatteAcc" type="submit">Criar Conta</button>
                </div>
            </div>
        </div>
      </form>
    </div>
</div>


<!-- Modal de erro -->
<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Por favor, preencha todos os campos obrigatórios.</p>
    </div>
</div>




<script src="../../src/js/formularios.js"></script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
</body>
</html>
