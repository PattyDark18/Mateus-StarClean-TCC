<?php

// <th>Código</th>
// <th>Valor</th>
// <th>Status</th>
// <th>Editar</th>
// <th>Excluir</th>

// Classe para representar um Cupom
class Cupom {
    private $CupomID;        // Codigo para pegar o banco de dados
    private $Codigo;        // Nome da Codigo
    private $valor;     // valor do Cupom
    private $status;     // Status


    // Construtor da classe que inicializa as propriedades do Cupom
    public function __construct($CupomID, $Codigo, $valor, $status) {
        $this->CupomID = $CupomID;
        $this->Codigo = $Codigo;
        $this->valor = $valor;
        $this->status = $status;
    }

   // Métodos setters para acessar as propriedades do Cupom
    public function setCupomID($CupomID) {
        $this->CupomID = $CupomID;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }

    public function setvalor($valor) {
        $this->valor = $valor;
    }

    public function setstatus($status) {
        $this->status = $status;
    }


    public function getCupomID() {
        return $this->CupomID;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function getvalor() {
        return $this->valor;
    }

    public function getstatus() {
        return $this->status;
    }

}

?>
