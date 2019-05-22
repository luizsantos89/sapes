<?php
    require('Funcionario.php');
    
    class FuncionarioDAO{   
        private $con;
        public $porPagina;
        
        function FuncionarioDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
                $this->porPagina = 25;
        }
        
        public function incluirFuncionario($funcionario){
            $sql = $this->con->prepare("insert into funcionario (idUsuario, idSecao, nome, cargo, situacao, dataAdmissao, cracha, dataCadastro, funcAtivo, dataInativacao, cargaHoraria, sexo, dataNascimento) values (:idUsuario, :idSecao, :nome, :cargo, :situacao, :dataAdmissao, :cracha, :dataCadastro, :funcAtivo, :dataInativacao, :cargaHoraria, :sexo, :dataNascimento)");
            $sql->bindValue(':idUsuario', $funcionario->getIdUsuario());
            $sql->bindValue(':idSecao',$funcionario->getIdSecao());
            $sql->bindValue(':nome',$funcionario->getNome());
            $sql->bindValue(':cargo',$funcionario->getCargo());
            $sql->bindValue(':situacao',$funcionario->getSituacao());
            $sql->bindValue(':dataAdmissao',$funcionario->getDataAdmissao());
            $sql->bindValue(':cracha',$funcionario->getCracha());
            $sql->bindValue(':dataCadastro',$funcionario->getDataCadastro());
            $sql->bindValue(':funcAtivo',$funcionario->getFuncAtivo());
            $sql->bindValue(":dataInativacao", $funcionario->getDataInativacao());
            $sql->bindValue(":cargaHoraria",$funcionario->getCargaHoraria());
            $sql->bindValue(":sexo", $funcionario->getSexo());
            $sql->bindValue(":dataNascimento", $funcionario->getDataNascimento());
            
            $sql->execute();
        }
        
        public function getFuncionarios() {
            $query = "SELECT * FROM funcionario ORDER BY funcAtivo DESC, cracha ASC";
            $rs = $this->con->query($query);
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getFuncionariosPaginacao($pagina) {
            $init = ($pagina-1) * $this->porPagina;
            
            $query = "SELECT * FROM funcionario ORDER BY funcAtivo DESC, cracha ASC limit $init, $this->porPagina";
            $rs = $this->con->query($query);
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getPagina() {
            $result_total = $this->con->query("SELECT count(*) as total FROM funcionario")->fetch(PDO::FETCH_OBJ);
            
            $num_paginas = ceil($result_total->total/$this->porPagina)+1;
            
            return $num_paginas;
        }
        
        public function getFuncionariosBySecao($idSecao) {
            $sql = $this->con->prepare("SELECT * FROM funcionario where idSecao = :idSecao ORDER BY funcAtivo DESC, cracha ASC ");
            $sql->bindValue(':idSecao', $idSecao);
            $sql->execute();
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getFuncionarioByDivisao($idDivisao) {
            $sql = $this->con->prepare("SELECT f.* FROM funcionario as f INNER JOIN secao as s ON f.idSecao = s.idSecao where s.idDivisao = :idDivisao ORDER BY funcAtivo DESC, cracha ASC ");
            $sql->bindValue(':idDivisao', $idDivisao);
            $sql->execute();
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getFuncionarioByGerencia($idGerencia) {
            $sql = $this->con->prepare("SELECT f.* FROM funcionario as f INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao where d.idGerencia = :idGerencia ORDER BY funcAtivo DESC, cracha ASC ");
            $sql->bindValue(':idGerencia', $idGerencia);
            $sql->execute();
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getFuncionarioByCargo($cargo) {
            $sql = $this->con->prepare("SELECT * FROM funcionario where cargo = :cargo ORDER BY funcAtivo DESC, cracha ASC ");
            $sql->bindValue(':cargo', $cargo);
            $sql->execute();
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $funcionario;
            }
            return $lista;
        }
        
        public function getFuncionarioByID($idFuncionario) {
            $sql = $this->con->prepare("SELECT * FROM funcionario where idFuncionario = :idFuncionario");
            $sql->bindValue(':idFuncionario', $idFuncionario);
            $sql->execute();
            
            $funcionario = new Funcionario();
            $funcionario = $sql->fetch(PDO::FETCH_OBJ);
            return $funcionario;
        }
        
        public function editarFuncionario($funcionario){
            $sql = $this->con->prepare("UPDATE funcionario SET nome = :nome, cracha = :cracha, cargo = :cargo, situacao = :situacao, funcAtivo = :funcAtivo, dataInativacao = :dataInativacao, dataAdmissao = :dataAdmissao, idSecao = :idSecao, cargaHoraria = :cargaHoraria, sexo = :sexo, dataNascimento = :dataNascimento WHERE idFuncionario = :idFuncionario");
            $sql->bindValue(":nome",$funcionario->getNome());
            $sql->bindValue(":cracha",$funcionario->getCracha());
            $sql->bindValue(":cargo",$funcionario->getCargo());
            $sql->bindValue(':situacao', $funcionario->getSituacao());
            $sql->bindValue(":funcAtivo",$funcionario->getFuncAtivo());
            $sql->bindValue(":dataInativacao", $funcionario->getDataInativacao());
            $sql->bindValue(":dataAdmissao", $funcionario->getDataAdmissao());
            $sql->bindValue(":idSecao",$funcionario->getIdSecao());
            $sql->bindValue(":idFuncionario",$funcionario->getIdFuncionario());
            $sql->bindValue(":cargaHoraria",$funcionario->getCargaHoraria());
            $sql->bindValue(":sexo", $funcionario->getSexo());
            $sql->bindValue(":dataNascimento", $funcionario->getDataNascimento());
                       
            
            $sql->execute();
        }
        
        public function excluiFuncionario($funcionario){
            $sql = $this->con->prepare('DELETE FROM funcionario WHERE idFuncionario = :idFuncionario');
            $sql->bindValue(':idFuncionario', $funcionario->getIdFuncionario());
            $sql->execute();
        }
    }