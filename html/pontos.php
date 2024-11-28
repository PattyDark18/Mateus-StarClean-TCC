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

    $user_id = $_SESSION['ID'];
    $ArmazenarUsuario = new ArmazenarUsuarioMYSQL();
    $usuario = $ArmazenarUsuario->buscarUsuario($user_id);
  
    $Pontos_usuario = $ArmazenarUsuario->buscarPontosUsuario($user_id);



    // Dados do usuário
    $Nome = $_SESSION['nome'];
    $Sobrenome = $_SESSION['sobrenome'];
    $Telefone = $_SESSION['telefone'];
    $Email = $_SESSION['email'];
    $Senha = $_SESSION['senha'];
    $Foto = $_SESSION['foto'];
    $Tipo = $_SESSION['tipo'];

      if ($Pontos_usuario !== null) {
          $Pontos = $Pontos_usuario['Pontos'];
          $_SESSION['Pontos'] = $Pontos;
      }else{
        $Pontos = 0;
      
  }




    // $Pontos = isset($Pontos) ? $Pontos : 0; // Certifique-se de que $Pontos seja definido
    // $maxPontos = 500; // Pontuação máxima para completar a barra de progresso
    // $percentualProgresso = min(($Pontos / $maxPontos) * 100, 100); // Calcule o percentual de progresso, limitando a 100%


$maxPontos = 500; // Pontuação máxima para completar a barra de progresso

// Adicione a verificação para limitar os pontos ao máximo
$Pontos = min($Pontos, $maxPontos); // Garante que $Pontos não ultrapasse $maxPontos

$percentualProgresso = ($Pontos / $maxPontos) * 100; // Calcule o percentual de progresso

}


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
    <link rel="stylesheet" href="../css/preset/reset.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/preset/vars.css">
    <link rel="stylesheet" href="../css/preset/modals.css">
    <link rel="stylesheet" href="../css/preset/bases/base-estilo.css">
    <link rel="stylesheet" href="../css/perfil_e_pontos/points_style.css">
    <link rel="stylesheet" href="../css/home-style/responsivo.css">
    <title>Suas Estrelas</title>
</head>
<body>




    <header>
        <nav class="menu" role="navigation" aria-label="Menu Principal">
            <img class="logo" src="../src/img/logo/logo.png" alt="logo Mateus StarClean" role="img">
            <div class="hamburger" aria-label="Abrir menu responsivo">
                &#9776;
            </div>
            <ul class="links" role="menubar">
                <li role="menuitem"><a href="home.php">Home</a></li>
                <li class="dropdown" role="menuitem">
                    <a href="servicos/servicos.php" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Serviços <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
                    <ul class="dropdown-content" role="menu" aria-label="Serviços">
                    <?php
                $Servicos = $ArmazenarServicos->listarTodosServicos();
                while ($linhas = $Servicos->fetch_object()) {
                    ?>
               
                        <li role="menuitem"><a href="servicos/pagina_servico.php?id=<?php echo $linhas->ServicoID; ?>"><?php echo htmlspecialchars($linhas->nome_servicos); ?></a></li>
               
                <?php
                }
                ?>
              </ul>
                </li>
                
                <?php if (isset($_SESSION['logado']) && $_SESSION['logado']): ?>
            <?php if ($Tipo == 0): ?>
                <li class="dropdown" role="menuitem">
                    <a href="#" class="dropdown-link" aria-haspopup="true" aria-expanded="false">Agendamento <span class="seta" aria-hidden="true">&#9660;</span><span class="sr-only">submenu</span></a>
                    <ul class="dropdown-content" role="menu" aria-label="Cupons">
                        <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendar serviço</a></li>
                        <li role="menuitem"><a href="meus_agendamentos.php">Meus Serviços agendados</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendamento</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li role="menuitem"><a href="forms/agendamento/agendamento.php">Agendamento</a></li>
        <?php endif; ?>
    

            </ul>

          
                <div class="botoes">
                    <div class="dropdown-perfil">
                        <span class="dropbtn"><?php echo htmlspecialchars($Nome);  ?></span>
                        <div class="dropdown-perfil-content">
                            <div class="perfil-info">
                                <?php

                                if ($Foto) {
                                ?>
                                <img  src="data:image/jpeg;base64,<?= $Foto ?>" alt="Foto de Perfil">
                                <?php
                                } else {
                                ?>

                                <img src="https://voxnews.com.br/wp-content/uploads/2017/04/unnamed.png" alt="Foto de Perfil">
                                <?php

                                }


                                ?>
                            </div>
                            <ul>
                          <?php
                          if($Tipo == 0){
                          ?>
                          <li><a href="#">Tipo: Usuário Comum</a></li>
                          <li><a href="pontos.php">Estrelas:  <?php echo $_SESSION['Pontos']; ?></a></li>
                          <?php
                          }else if ($Tipo == 1){
                            ?>
                              <li><a href="#">Tipo: Administrador</a></li>
                           
                            <?php
                          }
                          ?>
                                <li><a href="perfil.php">Editar Perfil</a></li>
                                <li><a href="../backend/cadastro e login/logout.php" id="logoutButton">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </nav>
    </header>
    <div class="main-content">
      
      <div class="container" role="region" aria-label="Apresentação do sistema de pontuação - Estrelas">
        <div class="div-top">
        
         <p class="AnnouncePts">Suas estrelas: <?php echo $_SESSION['Pontos']; ?></p>
         <h2>Obtenha estrelas e consiga algo valioso para seu carro em troca!</h2>
        </div>

        <div class="div-bottom">
            <div class="vantagens-pts">
                    <div class="text-content">
                        <h1>Vantagens</h1>
                        <ul>
                            <li><b> Ganhe Recompensas Rápidas: </b> Acumule e utilize recompensas de forma rápida e simples</li>
                            <li><b> Descontos Especiais: </b> Você pode receber descontos exclusivos nos agendamentos online, através do acumulo de pontos</li>
                            <li><b> Descontos Progressivos:</b> Conforme você utiliza mais serviços, os cupons valem mais estrelas</li>
                            
                        </ul>
                    </div>
                    <img src="../src/img/outros/estrela.jpg" alt="Estrela" class="star-vantagens">
            </div>


         
        </div>
        </div>

        <h1>Como funciona?</h1>
        <div class="Como-Funciona">
    <div class="ComoFuncionaPassos">
        <img src="../src/img/outros/passoUm.png" alt="">
        <div class="hover-info">
            <p>1 - A cada 5 serviços automotivos realizados na Mateus StarClean, você receberá um Cupom com um código</p>
        </div>
    </div>
    <div class="ComoFuncionaPassos">
        <img src="../src/img/outros/passo2.png" alt="">
        <div class="hover-info">
            <p>2- Esses Cupons valem Estrelas. Coloque o código no formulário demonstrado e será convertido. </p>
        </div>
    </div>
    <div class="ComoFuncionaPassos">
        <img src="../src/img/outros/passo3.png" alt="">
        <div class="hover-info">
            <p>3- Conforme você acumula pontos, você vai desbloqueando a trilha das estrelas. Cada passagem, um prêmio diferente. Ou seja, mais descontos e cortesias você ganha no seu agendamento online!</p>
        </div>
    </div>

</div>

  

        <div class="container-Star-Trail">
        <div class="title-container">
        <h1>Trilha das Estrelas</h1>
        </div>

        <div class="stars-trail-container">
            <div class="stars-container">
                <div class="star" data-value="0">
                <img src="../src/img/outros/star-locked.png" alt="0 estrelas">
                <p class="star-value">0 estrelas</p>
                </div>
                <div class="star" data-value="100">
                <img src="../src/img/outros/star-locked.png" alt="100 estrelas">
                <p class="star-value">100 estrelas</p>
                </div>
                <div class="star" data-value="250">
                <img src="../src/img/outros/star-locked.png" alt="250 estrelas">
                <p class="star-value">250 estrelas</p>
                </div>
                <div class="star" data-value="500">
                <img src="../src/img/outros/star-locked.png" alt="500 estrelas">
                <p class="star-value">500 estrelas</p>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            </div>
        </div>




        <div class="div-cupom">
        <h1>Transforme o seu Cupom em estrelas!</h1>
        <form method="POST" action="../backend/classes/Cupom/conferir.cupom.php">
            <div class="cupom-container">
            <div class="cupom">
                 <input type="text" id="codigoCupom" name="codigoCupom" placeholder="Exemplo: 3AI-2024">
                <button type="submit" id="resgatarCupomButton" class="resgatar-btn">Resgatar</button>
            </div>
            </div>
        </form>
        </div>





        
        
        <footer role="contentinfo">
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
        </footer>
        
        
        <?php if (!empty($mensagem)): ?>
    <div id="couponModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        </div>
    </div>
    <?php endif; ?>
        
        <div id="logoutModal" class="modal">
            <div class="modal-content" style="height: 200px">
    <span class="close">&times;</span>
    <p>Você tem certeza que deseja sair?</p>
    <button  class="confirmButton" id="confirmButtonLogout">sim</button>
    <button class="cancelButton" id="cancelButtonLogout">não</button>
  </div>
</div>




    <script src="../src/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.2/dist/confetti.browser.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const pontos = <?php echo $Pontos; ?>;
    const estrelas = document.querySelectorAll('.stars-container .star');
    const progress = document.querySelector('.progress');

    // Define os valores das estrelas e posições em porcentagem
    const valoresEstrelas = [0, 100, 250, 500];
    const maxPontos = 500; // Pontuação máxima
    const totalEstrelas = estrelas.length;

    estrelas.forEach((estrela, index) => {
        const valor = valoresEstrelas[index];
        const imagem = estrela.querySelector('img');
        const valorTexto = estrela.querySelector('.star-value');

        // Atualiza a imagem da estrela e o texto com base nos pontos
        if (pontos >= valor) {
            imagem.src = '../src/img/outros/star-unlocked.png'; // Imagem de estrela desbloqueada
        } else {
            imagem.src = '../src/img/outros/star-locked.png'; // Imagem de estrela bloqueada
        }
        
        // Atualiza o texto com o valor correspondente
        valorTexto.textContent = `${valor} estrelas`;
        
        // Calcula a posição percentual das estrelas
        const percentual = (valor / maxPontos) * 100;
        estrela.style.left = `${percentual}%`;
    });

    const percentualProgresso = Math.min((pontos / maxPontos) * 100, 100); // Limite a 100%
    progress.style.width = `${percentualProgresso}%`;
});











document.addEventListener('DOMContentLoaded', function () {
    const logoutModal = document.getElementById('logoutModal');
    const closeBtn = document.querySelector('.close');
    const cancelLogoutBtn = document.getElementById('cancelButtonLogout');
    const confirmLogoutBtn = document.getElementById('confirmButtonLogout');

    // Abre o modal quando o botão de logout é clicado
    document.getElementById('logoutButton').addEventListener('click', function (event) {
        event.preventDefault(); // Impede o redirecionamento imediato
        logoutModal.style.display = 'block'; // Exibe o modal
    });

    // Fecha o modal ao clicar no "X" ou no botão de cancelar
    closeBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
    });

    cancelLogoutBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
    });

    // Redireciona para o logout ao confirmar
    confirmLogoutBtn.addEventListener('click', function () {
        window.location.href = '../backend/cadastro e login/logout.php'; // Redireciona para o script de logout
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
});




document.addEventListener('DOMContentLoaded', function () {
    const logoutModal = document.getElementById('logoutModal');
    const closeBtn = document.querySelector('.close');
    const cancelLogoutBtn = document.getElementById('cancelButtonLogout');
    const confirmLogoutBtn = document.getElementById('confirmButtonLogout');

    // Abre o modal quando o botão de logout é clicado
    document.getElementById('logoutButton').addEventListener('click', function (event) {
        event.preventDefault(); // Impede o redirecionamento imediato
        logoutModal.style.display = 'block'; // Exibe o modal
    });

    // Fecha o modal ao clicar no "X" ou no botão de cancelar
    closeBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
    });

    cancelLogoutBtn.addEventListener('click', function () {
        logoutModal.style.display = 'none';
    });

    // Redireciona para o logout ao confirmar
    confirmLogoutBtn.addEventListener('click', function () {
        window.location.href = '../backend/cadastro e login/logout.php'; // Redireciona para o script de logout
    });

    // Fecha o modal ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const couponModal = document.getElementById('couponModal');
    const closeBtn = couponModal.querySelector('.close');

    // Exibe o modal se houver uma mensagem na sessão
    if (<?php echo json_encode(!empty($mensagem)); ?>) {
        couponModal.style.display = 'block';
    }

    // Fecha o modal ao clicar no "X" ou fora do modal
    closeBtn.addEventListener('click', function () {
        couponModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === couponModal) {
            couponModal.style.display = 'none';
        }
    });
});



    </script>



<script src="../src/js/script.js"></script>
<script>document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
});
</script>
</body>
</html>
