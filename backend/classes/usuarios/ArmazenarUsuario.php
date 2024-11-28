<?php
require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'ClassUsuario.php';

interface IArmazenarUsuarios {
    public function cadastrarUsuario($usuario);
    public function atualizarUsuario($id, $Nome, $Sobrenome, $Telefone, $Senha_cripto);
    public function listarTodosUsuarios();
    public function verificarEmail($email);
    public function verificarLogin($email, $senha);
    public function buscarUsuario($id);
    public function removerUsuario($id);
    public function alterarTipo($id,$tipo);
    public function alterarFoto($id,$foto);
    public function buscarPontosUsuario($id);
    public function adicionarPontos($id, $pontos);
    public function atualizarPontosUsados($idUsuario, $pontos);
    public function atualizarEndereco($CEP, $Rua, $Numero, $Bairro, $Cidade, $Estado, $idUsuario);
    public function atualizarSenha($user_id, $novaSenha);
    // public function pegarIDPeloEmail($email);
    public function pegarUsuarioPeloEmail($email);
}

class ArmazenarUsuarioMYSQL implements IArmazenarUsuarios {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }
    }

    public function cadastrarUsuario($usuario) {
        // Verificar se o objeto usuario é válido
        if (!$usuario) {
            throw new Exception("O objeto usuário não foi inicializado corretamente.");
        }

        // Obtendo dados do usuário
        $ID = $usuario->getID();
        $Nome = $usuario->getNome();
        $Sobrenome = $usuario->getSobrenome();
        $Telefone = $usuario->getTelefone();
        $Email = $usuario->getEmail();
        $Senha = $usuario->getSenha();
        $Senha_cripto = sha1($Senha).sha1('');
        $Foto = $usuario->getFoto();
        $Pontos = $usuario->getPontos();
        $Tipo = $usuario->getTipo(); // Novo campo Tipo

        // Preparando a query SQL para inserção do usuário
        $sqlUsuario = "INSERT INTO usuarios (ID, Nome, Sobrenome, Telefone, Email, Senha, Foto, Tipo)
                       VALUES ('$ID', '$Nome', '$Sobrenome', '$Telefone', '$Email', '$Senha_cripto', '$Foto', '$Tipo')";


 
        // Executando a query para inserir o usuário
        if (!$this->conexao->executarQuery($sqlUsuario)) {
            throw new Exception("Erro ao cadastrar usuário: " . $this->conexao->getErro());
        }

 // Obtém o ID do último usuário inserido
 $idUsuario = $this->conexao->getUltimoId();
 if (!$idUsuario) {
     throw new Exception("Não foi possível obter o ID do usuário inserido.");
 }

 // Insere a entrada na tabela pontos_usuario com 0 pontos
 $sqlEndereco = "INSERT INTO endereco_usuario (id_usuario) VALUES ('$idUsuario')";
 if (!$this->conexao->executarQuery($sqlEndereco)) {
    throw new Exception("Erro ao inserir pontos para o usuário: " . $this->conexao->getErro());
}


 $sqlPontos = "INSERT INTO pontos_usuario (id_usuario, Pontos) VALUES ('$idUsuario', 0)";
//  print_r($sqlPontos); // Para depuração, você pode remover isso em produção

 if (!$this->conexao->executarQuery($sqlPontos)) {
     throw new Exception("Erro ao inserir pontos para o usuário: " . $this->conexao->getErro());
 }


}

public function atualizarUsuario($Nome, $Sobrenome, $Telefone, $Senha, $id) {
    // Criptografar a senha nova, se for fornecida
    if (!empty($Senha)){
        $Senha_cripto = sha1($Senha).sha1('');
        $sql = "UPDATE usuarios SET Nome='$Nome', Sobrenome='$Sobrenome', Telefone='$Telefone', Senha='$Senha_cripto' WHERE ID = '$id'";
        $alterar = $this->conexao->executarQuery($sql);
        
        if (!$alterar) {
            throw new Exception("Erro ao atualizar o usuário: " . $this->conexao->getErro());
        }
        
        return $alterar;
        
    } else {
        // Caso a senha não seja alterada, não incluímos o campo Senha
        $sql = "UPDATE usuarios SET Nome='$Nome', Sobrenome='$Sobrenome', Telefone='$Telefone' WHERE ID = '$id'";

        $alterar = $this->conexao->executarQuery($sql);
        
        if (!$alterar) {
            throw new Exception("Erro ao atualizar o usuário: " . $this->conexao->getErro());
        }
        
        return $alterar;
    }

    // Executar a query de atualização
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function atualizarEndereco($CEP, $Rua, $Numero, $Bairro, $Cidade, $Estado, $idUsuario){
    $sql = "UPDATE endereco_usuario SET CEP='$CEP', Rua='$Rua', Numero='$Numero', Bairro='$Bairro', Cidade='$Cidade', Estado='$Estado' WHERE id_usuario = '$idUsuario'";
    $alterar = $this->conexao->executarQuery($sql);
    
    if (!$alterar) {
        throw new Exception("Erro ao atualizar o usuário: " . $this->conexao->getErro());
    }
    
    return $alterar;
}


    public function listarTodosUsuarios() {

        $sql = "SELECT * FROM usuarios ORDER BY Nome ASC";
        $registro = $this->conexao->executarQuery($sql);
        return $registro;
    }

    public function verificarEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE Email = '$email'";
        return $this->conexao->executarQuery($sql);
    }
    
    // public function pegarIDPeloEmail($email) {
    //     $sql = "SELECT ID, Email FROM usuarios WHERE Email = '$email'";
    //     $resultado = $this->conexao->executarQuery($sql);
    //     $linha = $resultado->fetch_assoc();
    //     return $linha;
    // }

    public function pegarUsuarioPeloEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $this->conexao->executarQuery($sql);
        $linha = $resultado->fetch_assoc();
        return $linha;
    }


    public function verificarLogin($email, $senha) {
        $senha_cripto = sha1($senha).sha1(''); // Usa a mesma criptografia usada no cadastro
        $sql = "SELECT * FROM usuarios WHERE Email = '$email' AND Senha = '$senha'";
        $result = $this->conexao->executarQuery($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retorna o registro do usuário
        }
        return null; // Retorna null se nenhum registro for encontrado
    }

    public function buscarUsuario($id) {
        $sql = "SELECT usuarios.ID, usuarios.Nome, usuarios.Sobrenome, usuarios.Telefone, usuarios.Email, endereco_usuario.cep, endereco_usuario.rua, endereco_usuario.numero, endereco_usuario.bairro, endereco_usuario.cidade, endereco_usuario.estado
        FROM usuarios
        LEFT JOIN endereco_usuario ON usuarios.ID = endereco_usuario.id_usuario
        WHERE usuarios.ID = '$id'";
        
        $result = $this->conexao->executarQuery($sql);

        if ($result) {
            return $result->fetch_assoc();
        } else {
            throw new Exception("Erro ao buscar usuário: " . $this->conexao->getErro());
        }
            }

    public function removerUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE ID = '$id'";
        $excluir = $this->conexao->executarQuery($sql);
        return $excluir;
    }
    
    public function alterarTipo($id, $tipo)
    {
        $sql = "UPDATE usuarios SET Tipo = '$tipo' WHERE ID = '$id'";
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;
    }

    public function alterarFoto($id, $foto) {
        $sql = "UPDATE usuarios SET Foto = '$foto' WHERE ID = '$id'";
        $alterar = $this->conexao->executarQuery($sql);
        return $alterar;
    }


    
    public function buscarPontosUsuario($id) {
     $sql = "SELECT Pontos FROM pontos_usuario WHERE id_usuario = $id";
    $pontos = $this->conexao->executarQuery($sql);
    $result = $pontos->fetch_assoc();
    return $result;

    }



            public function adicionarPontos($idUsuario, $valorPontos) {
                // Verifica se o usuário existe na tabela pontos_usuario
                $sqlVerificaUsuario = "SELECT * FROM pontos_usuario WHERE id_usuario = '$idUsuario'";
                $resultado = $this->conexao->executarQuery($sqlVerificaUsuario);
            
                if ($resultado && $resultado->num_rows > 0) {
                    // Usuário encontrado, adiciona os pontos
                    $sqlAdicionaPontos = "UPDATE pontos_usuario SET Pontos = Pontos + $valorPontos WHERE id_usuario = '$idUsuario'";
                    if (!$this->conexao->executarQuery($sqlAdicionaPontos)) {
                        throw new Exception("Erro ao adicionar pontos: " . $this->conexao->getErro());
                    }
                } else {
                    throw new Exception("Usuário não encontrado para adicionar pontos.");
                }
            }
        
    

        public function atualizarPontosUsados($idUsuario, $pontos) {
            $sql = "UPDATE pontos_usuario SET Pontos = '$pontos' WHERE id_usuario = '$idUsuario'";
            $result = $this->conexao->executarQuery($sql);
            return $result;
        }
    


    public function atualizarSenha($user_id, $Senha){
        $Senha_criptoNova = sha1($Senha).sha1('');
        $sql = "UPDATE usuarios SET Senha='$Senha_criptoNova' WHERE ID = '$user_id'";

        $alterar = $this->conexao->executarQuery($sql);
        
        if (!$alterar) {
            throw new Exception("Erro ao atualizar o usuário: " . $this->conexao->getErro());
        }
        
        return $alterar;
    }
}
?>




