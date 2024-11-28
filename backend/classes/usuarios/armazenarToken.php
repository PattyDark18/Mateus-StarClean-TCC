<?php
require_once __DIR__ . '/../Conexao/classConexao.php';
include_once 'token-class.php';

interface IArmazenarToken {
    public function armazenarToken($user_id, $token);
    public function validarToken($token, $user_id);

}

class ArmazenarTokenMYSQL implements IArmazenarToken{

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao("localhost", "root", "", "Mateus_StarCleanTCC");
        if ($this->conexao->conectar() == false) {
            die("Erro: não foi possível conectar ao banco de dados.");
        }
    }

        public function armazenarToken($user_id, $token) {
            $sql = "INSERT INTO password_resets (user_id, token, created_at) VALUES ('$user_id', '$token', NOW())";
            $result = $this->conexao->executarQuery($sql);
            return $result;
        }
    
        public function validarToken($token, $user_id) {
            $sql = "SELECT * FROM password_resets WHERE user_id = '$user_id' AND token = '$token'";
            $result = $this->conexao->executarQuery($sql);
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    
}
