<?php

class TipoSancao{
    private $idTipo;
    private $idUsuario;
    private $dataCadastro;
    private $descricao;
    private $peso;
    
    public function getIdTipo() {
        return $this->idTipo;
    }
    
    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
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
    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    
    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }
    
    public function getDataCadastro() {
        return $this->dataCadastro;
    }
}
