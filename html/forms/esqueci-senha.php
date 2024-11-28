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
    <link rel="stylesheet" href="../../css/form-style/esqueci_senha.css">
    <!-- <link rel="stylesheet" href="../../css/responsivo.css"> -->
    <title>Esqueci minha Senha</title>
</head>
<body>

<div class="container">
    <button class="return"><a href="../forms/login.php"><i class="fas fa-arrow-left"></i></a></button>
    <div class="form-wrapper">
    <div class="form-container">
<form class="form" action="../../backend/editar/usuario-senha/reset_password.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            <input type="submit" value="Solicitar redefinição de senha">
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
    // Obtém o modal
    var modal = document.getElementById("myModal");

    // Obtém o botão de fechar
    var span = document.getElementsByClassName("close")[0];

    // Se houver uma mensagem, exibe o modal
    <?php if (!empty($mensagem)): ?>
        window.onload = function() {
            modal.style.display = "block";
        }
    <?php endif; ?>

    // Quando o usuário clicar no "x", fecha o modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Quando o usuário clicar fora do modal, fecha o modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


</script>

</body>
</html>
