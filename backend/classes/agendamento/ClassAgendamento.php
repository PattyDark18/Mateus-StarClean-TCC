<?php

// Classe para representar um Agendamento
class Agendamento {
    private $AgendamentoID;        // UsuarioID para pegar o banco de dados
    private $UsuarioID;        // Nome da UsuarioID
    private $Servico_Principal;     // Servico_Principal do Agendamento
    private $Dia;     // dia do Agendamento
    private $Horario;     // horario do Agendamento
    private $Preco;     // horario do Agendamento
    private $Local;     // local do Agendamento
    private $Servico_Adicional;     // Servico_Adicional do Agendamento
    private $Marca_carro;     // marca do Agendamento
    private $Modelo_carro;     // modelo do Agendamento
    private $Pagamento;     // pagamento do Agendamento
    private $Observacoes;     // observacoes do Agendamento
    private $Status;     // Status
    private $observacoes_adm;     // Status
    private $duracao;


    // Construtor da classe que inicializa as propriedades do Agendamento
    public function __construct($AgendamentoID, $UsuarioID, $Servico_Principal, $Dia, $Horario, $Preco, $Local, $Servico_Adicional, $Marca_carro, $Modelo_carro, $Pagamento, $Observacoes, $Status, $observacoes_adm, $duracao) {
        $this->AgendamentoID = $AgendamentoID;
        $this->UsuarioID = $UsuarioID;
        $this->Servico_Principal = $Servico_Principal;
        $this->Dia = $Dia;
        $this->Horario = $Horario;
        $this->Preco = $Preco;
        $this->Local = $Local;
        $this->Servico_Adicional= $Servico_Adicional;
        $this->Marca_carro = $Marca_carro;
        $this->Modelo_carro = $Modelo_carro;
        $this->Pagamento = $Pagamento;
        $this->Observacoes = $Observacoes;
        $this->Status = $Status;
        $this->observacoes_adm = $observacoes_adm;
        $this->duracao = $duracao;

    }

   // Métodos setters para acessar as propriedades do Agendamento
    public function setAgendamentoID($AgendamentoID) {
        $this->AgendamentoID = $AgendamentoID;
    }

    public function setUsuarioID($UsuarioID) {
        $this->UsuarioID = $UsuarioID;
    }

    public function setServico_Principal($Servico_Principal) {
        $this->Servico_Principal = $Servico_Principal;
    }

    public function setDia($Dia) {
        $this->Dia= $Dia;
    }

    public function setHorario($Horario) {
        $this->Horario = $Horario;
    }

    public function setPreco($Preco) {
        $this->Preco = $Preco;
    }

    public function setLocal($Local) {
        $this->Local = $Local;
    }

    public function setServico_Adicional($Servico_Adicional) {
        $this->Servico_Adicional = $Servico_Adicional;
    }

    public function setMarca_carro($Marca_carro) {
        $this->Marca_carro = $Marca_carro;
    }

    public function setModelo_carro($Modelo_carro) {
        $this->Modelo_carro = $Modelo_carro;
    }

    public function setPagamento($Pagamento) {
        $this->Pagamento = $Pagamento;
    }

    public function setObservacoes($Observacoes) {
        $this->Observacoes = $Observacoes;
    }
    public function setstatus($Status) {
        $this->Status = $Status;
    }
    public function setobservacoes_adm($observacoes_adm) {
        $this->Status = $observacoes_adm;
    }
    public function setduracao($duracao) {
        $this->Status = $duracao;
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   // Métodos getters para acessar as propriedades do Agendamento

    public function getAgendamentoID() {
        return $this->AgendamentoID;
    }

    public function getUsuarioID() {
        return $this->UsuarioID;
    }

    public function getServico_Principal() {
        return $this->Servico_Principal;
    }

    public function getDia() {
        return $this->Dia;
    }

    public function getHorario() {
        return $this->Horario;
    }
    public function getPreco() {
        return $this->Preco;
    }

    public function getLocal() {
        return $this->Local ;
    }

    public function getServico_Adicional() {
        return $this->Servico_Adicional;
    }

    public function getMarca_carro() {
        return $this->Marca_carro ;
    }

    public function getModelo_carro() {
        return $this->Modelo_carro ;
    }

    public function getPagamento() {
        return $this->Pagamento ;
    }

    public function getObservacoes() {
        return $this->Observacoes ;
    }

    public function getstatus() {
        return $this->Status;
    }
    public function getobservacoes_adm() {
        return $this->observacoes_adm;
    }
    public function getduracao() {
        return $this->duracao;
    }
}

?>
