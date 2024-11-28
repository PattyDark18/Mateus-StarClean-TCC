<?php
// Classe para representar um endereço
class Endereco {
    private $cep;        // Código de Endereçamento Postal
    private $rua;        // Nome da rua
    private $numero;     // Número do imóvel
    private $bairro;     // Bairro
    private $cidade;     // Cidade
    private $estado;     // Estado

    // Construtor da classe que inicializa as propriedades do endereço
    public function __construct($cep, $rua, $numero, $bairro, $cidade, $estado) {
        $this->cep = $cep;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }

    // Métodos getters para acessar as propriedades do endereço
    public function getCep() {
        return $this->cep;
    }

    public function getRua() {
        return $this->rua;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }
}

// Classe para representar um usuário
class usuario {
    private $id;         // Identificador único do usuário
    private $nome;       // Nome do usuário
    private $sobrenome;  // Sobrenome do usuário
    private $telefone;   // Número de telefone do usuário
    private $email;      // Endereço de e-mail do usuário
    private $senha;      // Senha do usuário (deve ser armazenada de forma segura)
    private $foto;       // Caminho para a foto do usuário
    private $pontos;     // Pontos acumulados pelo usuário
    private $tipo;     //


    // Construtor da classe que inicializa as propriedades do usuário
    public function __construct($id, $nome, $sobrenome, $telefone, $email, $senha, $foto, $pontos, $tipo) {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
        $this->foto = $foto;
        $this->pontos = $pontos;
        $this->tipo = $tipo;
    }

    // Métodos getters para acessar as propriedades do usuário
    public function getID() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getSobrenome() { return $this->sobrenome; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getFoto() { return $this->foto; }
    public function getPontos() { return $this->pontos; }
    public function getTipo() { return $this->tipo; }
}

?>
