<?php

require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'ClassPremios.php';

interface IArmazenarPremios{
    public function cadastrarPremios($Premios);
    public function atualizarPremios($PremiosID, $premio, $tipo, $valor_desconto);
    public function listarTodosPremios();
    public function removerPremios($PremiosID);
    public function alterarstatus($PremiosID,$status);
    public function listarPremiosAtivos();
    public function listarPremiosAtivosResgatados($pontosUsuario);
    public function BuscarValor_desconto($PremiosID);
    public function BuscarValor_Pontos($PremiosID);
    public function BuscarPremio($PremiosID);
    public function BuscarCamposPremio($PremiosID);
    public function buscarPremiosDisponiveis($pontosUsuario);
}

class ArmazenarPremiosMYSQL implements IArmazenarPremios {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }
    }

    public function cadastrarPremios($Premios) {
        // Verificar se o objeto Premios é válido
        if (!$Premios) {
            throw new Exception("O objeto usuário não foi inicializado corretamente.");
        }

        // Obtendo dados do serviço
        $PremiosID = $Premios->getPremiosID();
        $premio = $Premios->getpremio();
        $status = $Premios->getstatus(); // Novo campo status
        $tipo = $Premios->gettipo(); // Novo campo status
        $valor_desconto= $Premios->getvalor_desconto(); // Novo campo status
        $Valor_Pontos= $Premios->getValor_Pontos();

        // Preparando a query SQL para inserção do serviço
        $sql = "INSERT INTO premios (PremiosID, premio, status, tipo, valor_desconto, Valor_Pontos) 
        VALUES ('$PremiosID', '$premio','$status', '$tipo', '$valor_desconto', '$Valor_Pontos')";


// Executando a query para inserir o serviço
            $registro = $this -> conexao -> executarQuery($sql);
            return $registro;
    }


//Funcao para atualizar todos os premios de  pontos para o adm
public function atualizarPremios($PremiosID, $premio, $tipo, $valor_desconto) {
        if ($tipo == 1) {
            $sql = "UPDATE premios SET premio= '$premio', tipo='$tipo', valor_desconto=NULL
            WHERE PremiosID='$PremiosID'";
        } else {
            $sql = "UPDATE premios SET premio= '$premio', tipo='$tipo', valor_desconto='$valor_desconto'
            WHERE PremiosID='$PremiosID'";
        }

        $alterar = $this->conexao->executarQuery($sql);
    if (!$alterar) {
        throw new Exception("Erro ao atualizar o cupom: " . $this->conexao->getErro());
    }
    
    return $alterar;
}
//Funcao para listar todos os premios de  pontos para o adm
    public function listarTodosPremios() {
        $sql = "SELECT * FROM premios";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }


//Funcao para remover todos os premios de  pontos para o adm
    public function removerPremios($PremiosID) {
        $sql = "DELETE FROM Premios WHERE PremiosID = '$PremiosID'";
        if (!$this->conexao->executarQuery($sql)) {
            throw new Exception("Erro ao remover o serviço: " . $this->conexao->getErro());
        }
    }

//Funcao para altterar todos os premios de  pontos para o adm
    public function alterarstatus($PremiosID, $status) {
        $sql = "UPDATE premios SET status = '$status' WHERE premiosID = '$PremiosID'";
        $alterar = $this->conexao->executarQuery($sql);
        
        if (!$alterar) {
            throw new Exception("Erro ao alterar o status: " . $this->conexao->getErro());
        }
        return $alterar;
    }

//Funcao para listar todos os premios de  pontos ativos para o usuario
    public function listarPremiosAtivos() {
        $sql = "SELECT * FROM premios WHERE status = 1";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }


    public function listarPremiosAtivosResgatados($pontosUsuario) {
        $sql = "SELECT * FROM premios WHERE status = 1 AND Valor_Pontos <= $pontosUsuario";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

    public function BuscarValor_desconto($PremiosID){
        $sql = "SELECT valor_desconto FROM premios WHERE PremiosID = $PremiosID and tipo = 0";
        $result = $this->conexao->executarQuery($sql);


        if ($result && $row = $result->fetch_object()) {
         
            return $row->valor_desconto; // Retorna o preço diretamente
        }
        return null; // Retorna null se não encontrar
    }

    public function BuscarValor_Pontos($PremiosID) {
        $sql = "SELECT Valor_Pontos FROM premios WHERE PremiosID = '$PremiosID'";
        $registro = $this->conexao->executarQuery($sql);
        if ($registro && $registro->num_rows > 0) {
            // Fetch the row and return the 'Valor_Pontos' value
            $row = $registro->fetch_assoc();
            return $row['Valor_Pontos'];
        } else {
            return null;
        }
    }
    public function BuscarPremio($PremiosID){
        $sql = "SELECT premio FROM premios WHERE PremiosID = '$PremiosID'";
        $result = $this->conexao->executarQuery($sql);


        if ($result && $row = $result->fetch_object()) {
            return $row->premio; // Retorna o preço diretamente
        }
        return null; // Retorna null se não encontrar
    }

    
    public function BuscarCamposPremio($PremiosID){
        $sql = "SELECT * FROM premios WHERE PremiosID = '$PremiosID'";
        $result = $this->conexao->executarQuery($sql);

        if ($result) {
            return $result->fetch_assoc();
        } else {
            throw new Exception("Erro ao buscar o serviço: " . $this->conexao->getErro());
        }
    }
    


    public function buscarPremiosDisponiveis($pontosUsuario) {
        $premiosDisponiveis = [];
        
        $sql = "SELECT * FROM premios WHERE Valor_Pontos <= $pontosUsuario ORDER BY Valor_Pontos ASC";
        $resultado = $this->conexao->executarQuery($sql);
        
        while ($premio = $resultado->fetch_assoc()) {
            $premiosDisponiveis[] = $premio;
        }
        
        return $premiosDisponiveis;
    }
}





?>
