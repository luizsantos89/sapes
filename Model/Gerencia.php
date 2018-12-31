<?php

class Gerencia {
    private $idGerencia;
    private $descricao;
    
    
    public function setIdGerencia($idGerencia) {
        $this->idGerencia = $idGerencia;
    }
    
    public function getIdGerencia() {
        return $this->idGerencia;
    }
    
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
}


?>