<?php
require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'ClassCupom.php';

interface IArmazenarCupom {
    public function cadastrarCupom($Cupom);
    public function atualizarCupom($CupomID, $Codigo, $Valor);
    public function listarTodosCupons();
    public function buscarCupom($CupomID);
    public function removerCupom($CupomID);
    public function alterarstatus($CupomID,$status);
    public function verificarCupom($codigoDigitado);
    public function atualizarStatusCupom($codigoDigitado);
}

class ArmazenarCupomMYSQL implements IArmazenarCupom {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function cadastrarCupom($Cupom) {
        // Verificar se o objeto Cupom é válido
        if (!$Cupom) {
            throw new Exception("O objeto usuário não foi inicializado corretamente.");
        }

        // Obtendo dados do serviço
        $CupomID = $Cupom->getCupomID();
        $Codigo = $Cupom->getCodigo();
        $valor = $Cupom->getvalor();
        $status = $Cupom->getstatus(); // Novo campo status

        // Preparando a query SQL para inserção do serviço
        $sql = "INSERT INTO cupom (CupomID, Codigo, valor, status)
                    VALUES ('$CupomID', '$Codigo', '$valor','$status')";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;

    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function atualizarCupom($CupomID, $Codigo, $Valor) {

            // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //     $CupomID = $_GET['Cupomid']; // Verifique se o ID é válido
            //     $ArmazenarCupom->atualizarCupom($CupomID, $_POST['Codigo'], $_POST['Valor']);
            //     $_SESSION['mensagem'] = "Informações alteradas com sucesso!";
            //     header('Location: ../../../html/adm/editar_cupons.php');
            //     exit();
            // }
            

            $sql = "UPDATE cupom SET codigo='$Codigo', valor='$Valor' WHERE cupomID='$CupomID'";
            $alterar = $this->conexao->executarQuery($sql);
            
            if (!$alterar) {
                throw new Exception("Erro ao atualizar o cupom: " . $this->conexao->getErro());
            }
            
            return $alterar;
        }
        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function listarTodosCupons() {
        $sql = "SELECT * FROM cupom ORDER BY Codigo ASC";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function buscarCupom($CupomID) {
    // Verifica se o CupomID não está vazio ou inválido
    // if (empty($CupomID)) {
    //     throw new Exception("O ID do cupom não pode estar vazio.");
    // }

    // Sanitiza o CupomID para evitar injeções SQL
    $CupomID = intval($CupomID); // Supondo que CupomID seja um inteiro

    // Monta a consulta SQL
    $sql = "SELECT * FROM cupom WHERE CupomID = $CupomID";

    $result = $this->conexao->executarQuery($sql);

    if ($result) {
        return $result->fetch_assoc();
    } else {
        throw new Exception("Erro ao buscar o serviço: " . $this->conexao->getErro());
    }
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function removerCupom($CupomID) {
        $sql = "DELETE FROM cupom WHERE CupomID = '$CupomID'";
        if (!$this->conexao->executarQuery($sql)) {
            throw new Exception("Erro ao remover o serviço: " . $this->conexao->getErro());
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    public function alterarstatus($CupomID, $status) {
        $sql = "UPDATE cupom SET status = '$status' WHERE CupomID = '$CupomID'";
        echo $sql;
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;

    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function verificarCupom($codigoDigitado) {
        $sql = "SELECT valor FROM cupom WHERE codigo = '$codigoDigitado' AND status = 1"; // Status 1 assume que o cupom está ativo
        $result = $this->conexao->executarQuery($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['valor']; // Retorna o valor do cupom
        } else {
            return false; // Cupom não encontrado ou não está ativo
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


public function atualizarStatusCupom($codigoDigitado) {
    $sql = "UPDATE cupom SET status = 0 WHERE codigo = '$codigoDigitado'";
    if (!$this->conexao->executarQuery($sql)) {
        throw new Exception("Erro ao atualizar status do cupom: " . $this->conexao->getErro());
    }
}
}

?>
