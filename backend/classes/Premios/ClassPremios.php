<?php




// Classe para representar um Cupom
class Premios{
    private $PremiosID;        // premio para pegar o banco de dados
    private $premio;        // Nome da premio
    private $status; 
    private $tipo; 
    private $valor_desconto; 
    private $Valor_Pontos;




    
    public function __construct($PremiosID, $premio, $status, $tipo, $valor_desconto, $Valor_Pontos) {
        $this->PremiosID = $PremiosID;
        $this->premio = $premio;
        $this->status = $status;
        $this->tipo = $tipo;
        $this->valor_desconto = $valor_desconto;
        $this->Valor_Pontos = $Valor_Pontos;

    }


    public function setPremiosID($PremiosID) {
        $this->PremiosID = $PremiosID;
    }

    public function setpremio($premio) {
        $this->premio = $premio;
    }

    public function setstatus($status) {
        $this->status = $status;
    }
    public function settipo($tipo) {
        $this->status = $tipo;
    }
    public function setvalor_desconto($valor_desconto) {
        $this->valor_desconto = $valor_desconto;
    }

    public function setValor_Pontos($Valor_Pontos) {
        $this->Valor_Pontos = $Valor_Pontos;
    }


    public function getPremiosID() {
        return $this->PremiosID;
    }

    public function getpremio() {
        return $this->premio;
    }

    public function getstatus() {
        return $this->status;
    }

    public function gettipo() {
        return $this->tipo;
    }

    public function getvalor_desconto() {
        return $this->valor_desconto;
    }
    public function getValor_Pontos() {
        return $this->Valor_Pontos;
    }

}


?>
