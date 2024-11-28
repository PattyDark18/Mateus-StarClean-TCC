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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/preset/reset.css">
    <link rel="stylesheet" href="../../css/fonts.css">
    <link rel="stylesheet" href="../../css/preset/vars.css">
    <link rel="stylesheet" href="../../css/preset/modals.css">
    <link rel="stylesheet" href="../../css/preset/bases/base-form.css">
    <link rel="stylesheet" href="../../css/form-style/login_style.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Login</title>
</head>
<body>

<div class="container">
    <div class="left-section">
        <button class="return"><a href="../home.php"><i class="fas fa-arrow-left"></i></a></button>
        <div class="welcome-info">
            <h2 class="welcome">Bem vindo de volta!</h2>
            <div class="redirect-container">
                <h3 class="redirect-text">Não possui uma conta?</h3>
                <button class="redirect-button"><a href="criar_conta.php">Cadastre-se</a></button>
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
        <div class="form-container">
            <div class="logo-container">
                <img class="logo-form" src="../../src/img/logo/logo.png" alt="Logo Mateus StarClean">
            </div>
            <form action="../../backend/cadastro e login/logar_usuario.php" method="post" class="form" id="main-form">
                <input  name="Email" type="email" placeholder="E-mail" required>
                <div class="password-container">
                    <input name="Senha" type="password" placeholder="Senha" id="password" required>
                    <span id="togglePassword" class="fa fa-fw fa-eye"></span>
                </div>
                <button type="submit">Logar</button>
                <a href="esqueci-senha.php" class="forgot-password">Esqueci minha senha</a>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        </div>
    </div>
<?php endif; ?>



<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});




 // Obtém o modal
 var modal = document.getElementById("myModal");

// Obtém o botão de fechar
var span = document.getElementsByClassName("close")[0];

// Se houver uma mensagem, exibe a modal
<?php if (!empty($mensagem)): ?>
    window.onload = function() {
        modal.style.display = "block";
    }
<?php endif; ?>

// Quando o usuário clicar no "x", fecha a modal
span.onclick = function() {
    modal.style.display = "none";
}

// Quando o usuário clicar fora da modal, fecha a modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</script>

</body>
</html>
