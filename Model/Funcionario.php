<?php

class Funcionario {
    private $idFuncionario;
    private $idUsuario;
    private $idSecao;
    private $nome;
    private $cracha;
    private $cargo;
    private $dataAdmissao;
    private $dataCadastro;
    private $funcAtivo;
    private $situacao;
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
    
    public function setDataAdmissao($dataAdmissao) {
        $this->dataAdmissao = $dataAdmissao;
    }
    
    public function getDataAdmissao() {
        return $this->dataAdmissao;
    }
    
    public function getCracha(){
        return $this->cracha;
    }
    
    public function setCracha($cracha) {
        $this->cracha = $cracha;
    }
    
    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }
    
    public function getCargo() {
        return $this->cargo;
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
    
    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
    
    public function getSituacao() {
        return $this->situacao;
    }
    
    public function getDataInativacao(){
        return $this->dataInativacao;
    }
    
    public function setDataInativacao($dataInativacao) {
        $this->dataInativacao = $dataInativacao;
    }
    
    public function setIdSecao($idSecao) {
        $this->idSecao = $idSecao;
    }
    
    public function getIdSecao() {
        return $this->idSecao;
    }
}

