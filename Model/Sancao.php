<?php

class Sancao{
    private $idSancao;
    private $idTipo;
    private $idFuncionario;
    private $idUsuario;
    private $numDoc;
    private $qtdDias;
    private $motivo;
    private $dataSancao;
    private $dataLancamento;
    
    public function getIdSancao() {
        return $this->idSancao;
    }
    
    public function setIdSancao($idSancao) {
        $this->idSancao = $idSancao;
    }
    
    public function getIdTipo() {
        return $this->idTipo;
    }
    
    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }
    
    public function getIdFuncionario() {
        return $this->idFuncionario;
    }
    
    public function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    public function getNumDoc() {
        return $this->numDoc;
    }
    
    public function setNumDoc($numDoc) {
        $this->numDoc = $numDoc;
    }
    public function getQtdDias() {
        return $this->qtdDias;
    }
    
    public function setQtdDias($qtdDias) {
        $this->qtdDias = $qtdDias;
    }
    
    public function getMotivo() {
        return $this->motivo;
    }
    
    public function setMotivo($motivo) {
        $this->motivo = $motivo;
    }
    public function getDataSancao() {
        return $this->dataSancao;
    }
    
    public function setDataSancao($dataSancao) {
        $this->dataSancao = $dataSancao;
    }
    
    public function getDataLancamento() {
        return $this->dataLancamento;
    }
    
    public function setDataLancamento($dataLancamento) {
        $this->dataLancamento = $dataLancamento;
    }
}
