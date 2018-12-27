<?php

class TipoSancao{
    private $idSancao;
    private $descricao;
    private $peso;
    
    public function getIdSancao() {
        return $this->idSancao;
    }
    
    public function setIdSancao($idSancao) {
        $this->idSancao = $idSancao;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
    
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getPeso() {
        return $this->peso;
    }
    
    public function setPeso($peso) {
        $this->peso = $peso;
    }
}
