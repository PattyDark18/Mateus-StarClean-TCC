<?php
require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'ClassAgendamento.php';

interface IArmazenarAgendamento {
    public function cadastrarAgendamento($Agendamento);
    public function atualizarAgendamento($Agendamento);
    public function listarTodosAgendamentos();
    public function listarAgendamentoDoUsuario($UsuarioID);
    public function buscarAgendamento($AgendamentoID);
    public function removerAgendamento($AgendamentoID);
    public function alterarStatus($AgendamentoID,$Status);
    public function alterarObsAdm($AgendamentoID, $observacoesADM);
    public function alterarRemarcar($AgendamentoID, $Dia, $Horario);
    public function listarAgendamentosComNomeDoServico($UsuarioID);
    public function listarAgendamentoComEndereco($UsuarioID);
    public function listarAgendamentosComNomeDoUsuario($UsuarioID);
    public function inserirServicoAdicional($agendamentoID, $servicoID);
    public function ListarHorariosOcupados($data);
    public function obterDuracaoAgendamentos($data);
 
}

class ArmazenarAgendamentoMYSQL implements IArmazenarAgendamento {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }

        
    }

    public function cadastrarAgendamento($Agendamento) {
        // Verificar se o objeto Agendamento é válido
        if (!$Agendamento) {
            throw new Exception("O objeto usuário não foi inicializado corretamente.");
        }

        // Obtendo dados do serviço
        $AgendamentoID = $Agendamento->getAgendamentoID();
        $UsuarioID = $Agendamento->getUsuarioID();
        $Servico_Principal = $Agendamento->getServico_Principal();
        $Dia = $Agendamento->getDia(); // Novo campo Dia
        $Horario= $Agendamento->getHorario(); // Novo campo Dia
        $Preco= $Agendamento->getPreco(); // Novo campo Dia
        $Local = $Agendamento->getLocal(); // Novo campo Dia
        $Servico_Adicional = $Agendamento->getServico_Adicional(); // Novo campo Dia
        $Marca_carro = $Agendamento->getMarca_carro(); // Novo campo Dia
        $Modelo_carro = $Agendamento->getModelo_carro(); // Novo campo Dia
        $Pagamento = $Agendamento->getPagamento(); // Novo campo Dia
        $Observacoes = $Agendamento->getObservacoes(); // Novo campo Dia
        $Status = $Agendamento->getStatus(); // Novo campo Dia
        $observacoes_adm = $Agendamento->getobservacoes_adm(); // Novo campo Dia
        $duracao_total = $Agendamento->getduracao();

        // Preparando a query SQL para inserção do serviço
        $sql = "INSERT INTO Agendamento (AgendamentoID, UsuarioID, Servico_Principal, Dia, Horario, Preco, Local, Servico_Adicional, Marca_carro, Modelo_carro, Pagamento, Observacoes, Status, observacoes_adm, duracao)
                    VALUES ('$AgendamentoID', '$UsuarioID', '$Servico_Principal','$Dia','$Horario', '$Preco', '$Local','$Servico_Adicional','$Marca_carro','$Modelo_carro','$Pagamento','$Observacoes', '$Status', '$observacoes_adm', '$duracao_total')";

        $registro = $this->conexao->executarQuery($sql);
        return $registro;


        $data = $Agendamento->getDia();
        $horario = $Agendamento->getHorario();
        $horariosOcupados = $this->listarHorariosOcupados($data);
        
        if (in_array($horario, $horariosOcupados)) {
            throw new Exception("O horário selecionado já está ocupado."); // Retornar mensagem de erro
        }
    }


    public function atualizarAgendamento($Agendamento) {
        // Implementação da função
    }

    public function listarTodosAgendamentos() {
        $sql = "SELECT * FROM Agendamento ";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

    public function listarAgendamentoDoUsuario($UsuarioID) {
        $sql = "SELECT * FROM Agendamento WHERE UsuarioID = '$UsuarioID' AND Status = 1";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

    public function buscarAgendamento($AgendamentoID) {
        if (!is_numeric($AgendamentoID) || $AgendamentoID <= 0) {
            throw new Exception("ID do agendamento inválido.");
        }
    
        $sql = "SELECT * FROM Agendamento WHERE AgendamentoID = '$AgendamentoID'";
        $result = $this->conexao->executarQuery($sql);
    
        if ($result) {
            return $result->fetch_assoc();
        } else {
            throw new Exception("Erro ao buscar o serviço: " . $this->conexao->getErro());
        }
    }

    public function removerAgendamento($AgendamentoID) {
        $sql = "DELETE FROM Agendamento WHERE AgendamentoID = '$AgendamentoID'";
        if (!$this->conexao->executarQuery($sql)) {
            throw new Exception("Erro ao remover o serviço: " . $this->conexao->getErro());
        }
    }

    public function alterarStatus($AgendamentoID, $Status) {
        $sql = "UPDATE Agendamento SET Status = '$Status' WHERE AgendamentoID = '$AgendamentoID'";
        echo $sql;
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;

    }


    public function alterarObsAdm($AgendamentoID, $observacoesADM){
        $sql = "UPDATE Agendamento SET observacoes_adm = '$observacoesADM' WHERE AgendamentoID = '$AgendamentoID'";
        echo $sql;
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;

    }


    public function alterarRemarcar($AgendamentoID, $Dia, $Horario){
        $sql = "UPDATE Agendamento SET Dia = '$Dia', horario = '$Horario' WHERE AgendamentoID = '$AgendamentoID'";
        echo $sql;
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;
        
    }


    public function listarAgendamentosComNomeDoServico($UsuarioID) {
        $sql = "SELECT agendamento.*, servicos.nome_servicos AS nome_servico_principal 
                FROM agendamento 
                INNER JOIN servicos ON agendamento.Servico_Principal = servicos.ServicoID 
                WHERE agendamento.usuarioID = '$UsuarioID'";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }
    
    public function listarAgendamentoComEndereco($UsuarioID) {
        $sql = "SELECT 
                agendamento.AgendamentoID, 
                agendamento.UsuarioID, 
                IF(
                    agendamento.Local = '1', 
                    'Endereço fixo da estética automotiva',
                    CONCAT(
                        endereco_usuario.Rua, ', ', 
                        endereco_usuario.numero, ', ', 
                        endereco_usuario.Bairro, ', ', 
                        endereco_usuario.Cidade, ', ', 
                        endereco_usuario.Estado, ' - ', 
                        endereco_usuario.CEP
                    )
                ) AS endereco_servico
            FROM agendamento
            LEFT JOIN endereco_usuario 
            ON agendamento.UsuarioID = endereco_usuario.id_usuario
            WHERE agendamento.UsuarioID = '$UsuarioID'
        ";
        
        $registro = $this->conexao->executarQuery($sql);
        
        if (!$registro) {
            throw new Exception("Erro ao executar a consulta: " . $this->conexao->getErro());
        }
        
        return $registro;
    }


public function listarAgendamentosComNomeDoUsuario($UsuarioID) {
    $sql = "SELECT agendamento.*, usuarios.Nome AS nome_usuario 
            FROM agendamento 
            INNER JOIN usuarios ON agendamento.usuarioID = usuarios.ID 
            WHERE agendamento.usuarioID = '$UsuarioID'";
       
    $registro = $this->conexao->executarQuery($sql);
    return $registro;
}


public function inserirServicoAdicional($agendamentoID, $servicoID) {
    $sql = "INSERT INTO agendamento_servicos (AgendamentoID, ServicoID) 
            VALUES ('$agendamentoID', '$servicoID')";
     $registro = $this->conexao->executarQuery($sql);
     return $registro;
}

public function getUltimoIdAgendamento() {
    return $this->conexao->getUltimoId();
}



public function listarAgendamentoComServicosAdicionais($AgendamentoID) {
    $sql = "SELECT s.ServicoID, s.nome_servicos, s.preco 
    FROM agendamento_servicos t
    INNER JOIN servicos AS s ON t.ServicoID = s.ServicoID
    WHERE t.AgendamentoID = $AgendamentoID";
    
    $result = $this->conexao->executarQuery($sql);
    
    $servicos = [];
    while ($row = $result->fetch_object()) {
        $servicos[] = $row; // Adiciona cada serviço ao array
    }
    return $servicos; // Retorna o array de serviços
}
    

    public function ListarHorariosOcupados($data) {
        $sql = "SELECT Horario FROM Agendamento WHERE Dia = '$data'";
        $registro = $this->conexao->executarQuery($sql);
        $horariosOcupados = [];
        while ($row = $registro->fetch_assoc()) {
            $horariosOcupados[] = $row['Horario'];
        }
        return $horariosOcupados; // Retornar array de horários ocupados
    }
    
    



    public function obterDuracaoAgendamentos($data) {
        $sql = "SELECT duracao FROM Agendamento WHERE Dia = '$data'";
        $registro = $this->conexao->executarQuery($sql);
        
        $duracoes = [];
        while ($row = $registro->fetch_assoc()) {
            $duracoes[] = $row['duracao']; // Adiciona a duração ao array
        }
        return $duracoes; // Retorna um array com as durações dos agendamentos
    }
    


}
?>
