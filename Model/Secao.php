<?php

class Secao {
    private $idSecao;
    private $idDivisao;
    private $descricao;
    
    public function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }
    
    public function getIdSecao() {
        return $this->idSecao;
    }

    public function setIdDivisao($idDivisao) {
        $this->idDivisao = $idDivisao;
    }
    
    public function getIdDivisao() {
        return $this->idDivisao;
    }
    
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
}

