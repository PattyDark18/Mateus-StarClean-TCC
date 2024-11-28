<?php
// Classe para representar um servico
class Servicos {
    private $ServicoID;        // Codigo para pegar o bamnco de dados
    private $Nome_servicos;        // Nome da Nome_servicos
    private $preco;     // preco do servico
    private $descricao;     // descricao
    private $vantagens;     // vantagens
    private $status;     // status
    private $duracao;     // status
    private $foto1;   
    private $foto2;   
    private $foto3;   
    private $foto4;   
    private $foto5;   
    // Construtor da classe que inicializa as propriedades do servico
    public function __construct($ServicoID, $Nome_servicos, $preco, $descricao, $vantagens, $status, $duracao, $foto1, $foto2, $foto3, $foto4, $foto5) {
        $this->ServicoID = $ServicoID;
        $this->Nome_servicos = $Nome_servicos;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->vantagens = $vantagens;
        $this->status = $status;
        $this->duracao = $duracao;

        $this->foto1 = $foto1;
        $this->foto2 = $foto2;
        $this->foto3 = $foto3;
        $this->foto4 = $foto4;
        $this->foto5 = $foto5;
    }

   // Métodos setters para acessar as propriedades do servico
    public function setServicoID($ServicoID) {
        $this->ServicoID = $ServicoID;
    }

    public function setNome_servicos($Nome_servicos) {
        $this->Nome_servicos = $Nome_servicos;
    }

    public function setpreco($preco) {
        $this->preco = $preco;
    }

    public function setdescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setvantagens($vantagens) {
        $this->vantagens = $vantagens;
    }

    public function setstatus($status) {
        $this->status = $status;
    }
    public function setduracao($duracao) {
        $this->duracao = $duracao;
    }


    public function getServicoID() {
        return $this->ServicoID;
    }

    public function getNome_servicos() {
        return $this->Nome_servicos;
    }

    public function getpreco() {
        return $this->preco;
    }

    public function getdescricao() {
        return $this->descricao;
    }

    public function getvantagens() {
        return $this->vantagens;
    }

    public function getstatus() {
        return $this->status;
    }
    public function getduracao() {
        return $this->duracao;
    }
    public function getfoto1() {
        return $this->foto1;
    }
    public function getfoto2() {
        return $this->foto2;
    }
    public function getfoto3() {
        return $this->foto3;
    }
    public function getfoto4() {
        return $this->foto4;
    }
    public function getfoto5() {
        return $this->foto5;
    }

}

?>
