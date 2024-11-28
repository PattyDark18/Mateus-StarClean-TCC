<?php

class Token {
    private $id;        
    private $user_id;       
    private $token;     
    private $create_at;   

    public function __construct($id, $user_id, $token, $create_at) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->token = $token;
        $this->create_at = $create_at;
    
    }


    public function getid() {
        return $this->id;
    }

    public function getuser_id() {
        return $this->user_id;
    }

    public function gettoken() {
        return $this->token;
    }

    public function getcreate_at() {
        return $this->create_at;
    }
}

?>