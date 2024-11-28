<?php
require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'ClassServicos.php';

interface IArmazenarServicos {
    public function cadastrarServico($Servico);
    public function atualizarServico($nome_servicos, $preco, $descricao, $vantagens, $duracao, $foto1, $foto2, $foto3, $foto4, $foto5, $ServicoID);
    public function listarTodosServicos();
    public function buscarServico($ServicoID);
    public function buscarServicoParaEditar($ServicoID);
    public function removerServico($ServicoID);
    public function alterarstatus($ServicoID,$status);
    public function buscarPreco($ServicoID);
    public function buscarFotos($ServicoID);
    public function buscarFoto1($ServicoID);
    public function buscarFoto2($ServicoID);
    public function buscarFoto3($ServicoID);
    public function buscarFoto4($ServicoID);
    public function buscarFoto5($ServicoID);


}

class ArmazenarServicoMYSQL implements IArmazenarServicos {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }
    }

    public function cadastrarServico($Servico) {
        // Verificar se o objeto Servico é válido
        if (!$Servico) {
            throw new Exception("O objeto usuário não foi inicializado corretamente.");
        }

        // Obtendo dados do serviço
        $ServicoID = $Servico->getServicoID();
        $Nome_servicos = $Servico->getNome_servicos();
        $preco = $Servico->getpreco();
        $descricao = $Servico->getdescricao();
        $vantagens = $Servico->getvantagens();
        $status = $Servico->getstatus();
        $duracao = $Servico->getduracao();
        $foto1 = $Servico->getfoto1(); 
        $foto2 = $Servico->getfoto2();
        $foto3 = $Servico->getfoto3(); 
        $foto4 = $Servico->getfoto4(); 
        $foto5 = $Servico->getfoto5();


    // Preparando a query SQL para inserção do serviço
    $sql = "INSERT INTO Servicos (ServicoID, Nome_servicos, preco, descricao, vantagens, status, duracao, foto1, foto2, foto3, foto4, foto5)
                VALUES ('$ServicoID', '$Nome_servicos', '$preco', '$descricao', '$vantagens', '$status', '$duracao', '$foto1', '$foto2', '$foto3', '$foto4', '$foto5')";
    $registro = $this->conexao->executarQuery($sql);
    return $registro;


    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ArmazenarServico.php

public function atualizarServico($nome_servicos, $preco, $descricao, $vantagens, $duracao, $foto1, $foto2, $foto3, $foto4, $foto5, $ServicoID) {
    // Monta a base da query
    $sql = "UPDATE servicos SET nome_servicos= '$nome_servicos', preco='$preco', descricao='$descricao', vantagens='$vantagens', duracao='$duracao'";

    // Condicionalmente adiciona os campos das fotos apenas se houver uma nova
    if ($foto1 !== null) {
        $sql .= ", foto1='$foto1'";
    }
    if ($foto2 !== null) {
        $sql .= ", foto2='$foto2'";
    }
    if ($foto3 !== null) {
        $sql .= ", foto3='$foto3'";
    }
    if ($foto4 !== null) {
        $sql .= ", foto4='$foto4'";
    }
    if ($foto5 !== null) {
        $sql .= ", foto5='$foto5'";
    }

    // Finaliza a query com a condição do ID do serviço
    $sql .= " WHERE ServicoID='$ServicoID'";

    // Executa a query
    $alterar = $this->conexao->executarQuery($sql);
    
    // Verifica se a query foi bem-sucedida
    if (!$alterar) {
        throw new Exception("Erro ao atualizar o serviço: " . $this->conexao->getErro());
    }

    return $alterar;
}
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function listarTodosServicos() {
        $sql = "SELECT * FROM Servicos ORDER BY Nome_servicos ASC";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function buscarServico($ServicoID) {
        $sql = "SELECT * FROM Servicos WHERE ServicoID = $ServicoID";
        $result = $this->conexao->executarQuery($sql);
        return $result;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

    public function buscarServicoParaEditar($ServicoID) {
        $sql = "SELECT * FROM Servicos WHERE ServicoID = $ServicoID";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            throw new Exception("Erro ao buscar usuário: " . $this->conexao->getErro());
        }
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function removerServico($ServicoID) {
        $sql = "DELETE FROM Servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function alterarstatus($ServicoID, $status) {
        $sql = "UPDATE Servicos SET status = '$status' WHERE ServicoID = '$ServicoID'";
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function buscarPreco($ServicoID)
    {
        $sql = "SELECT Preco FROM Servicos WHERE ServicoID = $ServicoID";
        $result = $this->conexao->executarQuery($sql);


        if ($result && $row = $result->fetch_object()) {
            return $row->Preco; // Retorna o preço diretamente
        }
        return null; // Retorna null se não encontrar
    
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function buscarFotos($ServicoID) {
        $sql = "SELECT foto1, foto2, foto3, foto4, foto5 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            $imagens = array();
            while ($row = $result->fetch_assoc()) {
                $imagens[] = $row['foto1'];
                $imagens[] = $row['foto2'];
                $imagens[] = $row['foto3'];
                $imagens[] = $row['foto4'];
                $imagens[] = $row['foto5'];
            }
            return $imagens;
        } else {
            return null;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    
    public function buscarFoto1($ServicoID){
        $sql = "SELECT foto1 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_object()->foto1;
        } else {
            return null;
        }
    
    }
    public function buscarFoto2($ServicoID){
        $sql = "SELECT foto2 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_object()->foto2;
        } else {
            return null;
        }
    
    }
    public function buscarFoto3($ServicoID){
        $sql = "SELECT foto3 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_object()->foto3;
        } else {
            return null;
        }
    
    }
    public function buscarFoto4($ServicoID){
        $sql = "SELECT foto4 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_object()->foto4;
        } else {
            return null;
        }
    
    }
    public function buscarFoto5($ServicoID){
        $sql = "SELECT foto5 FROM servicos WHERE ServicoID = '$ServicoID'";
        $result = $this->conexao->executarQuery($sql);
        if ($result) {
            return $result->fetch_object()->foto5;
        } else {
            return null;
        }
    
    }
    
}

?>
