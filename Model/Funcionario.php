<?php

class Funcionario {
    private $idFuncionario;
    private $idUsuario;
    private $nome;
    private $cracha;
    private $dataCadastro;
    private $funcAtivo;
    private $dataInativacao;

    public function getIdFuncionario(){
        return $this->idFuncionario;
    }
    
    public function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }
    
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function getCracha(){
        return $this->cracha;
    }
    
    public function setCracha($cracha) {
        $this->cracha = $cracha;
    }
    
    public function getDataCadastro(){
        return $this->dataCadastro;
    }
    
    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }
    
    public function getFuncAtivo(){
        return $this->funcAtivo;
    }
    
    public function setFuncAtivo($funcAtivo) {
        $this->funcAtivo = $funcAtivo;
    }
    
    public function getDataInativacao(){
        return $this->dataInativacao;
    }
    
    public function setDataInativacao($dataInativacao) {
        $this->dataInativacao = $dataInativacao;
    }
}

