function showNextForm(currentForm, nextForm) {
    const currentFormElement = document.getElementById(currentForm);
    const inputs = currentFormElement.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.checkValidity()) {
            isValid = false;
            input.classList.add('invalid');
        } else {
            input.classList.remove('invalid');
        }
    });

    if (isValid) {
        currentFormElement.classList.remove('ativo');
        document.getElementById(nextForm).classList.add('ativo');
    } else {
        showErrorModal(); // Exibe o modal de erro em vez do alerta
    }
}

function showErrorModal() {
    var modal = document.getElementById("errorModal");
    var closeButton = document.querySelector(".modal .close");

    // Exibe o modal
    modal.style.display = "block";

    // Fecha o modal ao clicar no "x"
    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    // Fecha o modal ao clicar fora do conteúdo
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

document.getElementById('main-form').addEventListener('submit', function(event) {
    const inputs = this.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.checkValidity()) {
            isValid = false;
            input.classList.add('invalid');
        } else {
            input.classList.remove('invalid');
        }
    });

    if (!isValid) {
        event.preventDefault(); // Impede o envio do formulário
        showErrorModal(); // Exibe o modal de erro em vez do alerta
    }
});


function updateProfilePic() {
    const fileInput = document.getElementById('file-upload');
    const profilePic = document.getElementById('profile-pic');

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            profilePic.src = e.target.result;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
}


function consultarCEP(cep) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                preencherCamposEndereco(data);
            } else {
                mostrarModal('CEP não encontrado.');
            }
        })
        .catch(error => {
            console.error('Erro ao consultar API do ViaCEP:', error);
            mostrarModal('Erro ao consultar CEP. Por favor, tente novamente.');
        });
}

function mostrarModal(mensagem) {
    var modal = document.getElementById('cepModal');
    var modalMessage = document.getElementById('modal-message');
    var closeBtn = document.getElementsByClassName('close')[0];

    modalMessage.textContent = mensagem;
    modal.style.display = "block";

    // Fecha o modal ao clicar no 'x'
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    // Fecha o modal ao clicar fora dele
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}
function preencherCamposEndereco(data) {
    document.getElementById('rua').value = data.logradouro;
    document.getElementById('bairro').value = data.bairro;
    document.getElementById('cidade').value = data.localidade;
    document.getElementById('estado').value = data.uf;
}



