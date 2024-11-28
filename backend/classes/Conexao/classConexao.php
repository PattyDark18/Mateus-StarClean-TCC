<?php
class Conexao {
    private $host;        // Armazena o endereço do servidor de banco de dados
    private $usuario;    // Armazena o nome de usuário para conexão com o banco de dados
    private $senha;      // Armazena a senha para conexão com o banco de dados
    private $banco;      // Armazena o nome do banco de dados
    private $conexao;    // Armazena o objeto de conexão com o banco de dados
    private $erro;       // Armazena mensagens de erro

    // Construtor da classe que inicializa as propriedades de conexão
    public function __construct($host, $usuario, $senha, $banco) {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->banco = $banco;
    }

    // Método para estabelecer a conexão com o banco de dados
    public function conectar() {
        $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);

        // Verifica se ocorreu um erro na conexão
        if ($this->conexao->connect_error) {
            $this->erro = "Falha na conexão: " . $this->conexao->connect_error;
            return false;
        }
        return true;
    }

    // Método para executar uma query SQL no banco de dados
    public function executarQuery($sql) {
        $resultado = $this->conexao->query($sql);
        
        // Verifica se ocorreu um erro na execução da query
        if ($this->conexao->error) {
            $this->erro = "Erro na execução da query: " . $this->conexao->error;
        }
        return $resultado;
    }

    // Método para obter a mensagem de erro atual
    public function getErro() {
        return $this->erro;
    }


    public function getUltimoId() {
        return $this->conexao->insert_id;
    }


    
    
}
?>
