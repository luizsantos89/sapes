<?php

class Desempenho{
    private $idDesempenho;
    private $idFuncionario;
    private $idUsuario;
    private $nota;
    private $semestre;
    private $ano;
    private $dataLancamento;
    
    public function setIdDesempenho($idDesempenho) {
        $this->idDesempenho = $idDesempenho;
    }
    
    public function getIdDesempenho() {
        return $this->idDesempenho;
    }
    
    public function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }
    
    public function getIdFuncionario() {
        return $this->idFuncionario;
    }
    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    
    public function setNota($nota) {
        $this->nota = $nota;
    }
    
    public function getNota() {
        return $this->nota;
    }
    
    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }
    
    public function getSemestre() {
        return $this->semestre;
    }
    
    public function setAno($ano) {
        $this->ano = $ano;
    }
    
    public function getAno() {
        return $this->ano;
    }
    
    public function setDataLancamento($dataLancamento) {
        $this->dataLancamento = $dataLancamento;
    }
    
    public function getDataLancamento() {
        return $this->dataLancamento;
    }
    
}

