<?php
    require('Sancao.php');
    
    class SancaoDAO{   
        private $con;
        public $porPagina;
        
        function SancaoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
                $this->porPagina = 25;
        }
        public function incluirSancao($sancao){
            $sql = $this->con->prepare("insert into sancao (idFuncionario, idUsuario, idTipo, numDoc, qtdDias, motivo, dataSancao, dataLancamento) values (:idFuncionario, :idUsuario, :idTipo, :numDoc, :qtdDias, :motivo, :dataSancao, :dataLancamento)");
            $sql->bindValue(':idFuncionario', $sancao->getIdFuncionario());
            $sql->bindValue(':idUsuario', $sancao->getIdUsuario());
            $sql->bindValue(':idTipo', $sancao->getIdTipo());
            $sql->bindValue(':numDoc', $sancao->getNumDoc());
            $sql->bindValue(':qtdDias', $sancao->getQtdDias());
            $sql->bindValue(':motivo', $sancao->getMotivo());
            $sql->bindValue(':dataSancao', $sancao->getDataSancao());
            $sql->bindValue(':dataLancamento', $sancao->getDataLancamento());
            
            $sql->execute();
        }
        
        public function getSancoes() {
            $query = "SELECT * FROM sancao ORDER BY dataSancao";
            $rs = $this->con->query($query);
            $lista = array();
        
            $sancao = new Sancao();
            
            while ($sancao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $sancao;
            }
            return $lista;
        }
        
        public function getSancoesPaginacao($pagina) {
            $init = ($pagina-1) * $this->porPagina;
            
            $query = "SELECT * FROM sancao ORDER BY dataSancao limit $init, $this->porPagina";
            $rs = $this->con->query($query);
            $lista = array();
        
            $sancao = new Sancao();
            
            while ($sancao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $sancao;
            }
            return $lista;
        }
        
        public function getPagina() {
            $result_total = $this->con->query("SELECT count(*) as total FROM sancao")->fetch(PDO::FETCH_OBJ);
            
            $num_paginas = ceil($result_total->total/$this->porPagina)+1;
            
            return $num_paginas;
        }
        
        public function getSancaoById($idSancao) {
            $sql = $this->con->prepare("SELECT * FROM sancao where idSancao = :idSancao");
            $sql->bindValue(':idSancao', $idSancao);
            $sql->execute();
            
            $sancao = new Sancao();
            $sancao = $sql->fetch(PDO::FETCH_OBJ);
            return $sancao;
        }
        
        public function editarSancao($sancao){
            $sql = $this->con->prepare("UPDATE sancao SET idFuncionario = :idFuncionario, idUsuario = :idUsuario, idTipo = :idTipo, numDoc = :numDoc, qtdDias = :qtdDias, motivo = :motivo, dataSancao = :dataSancao, dataLancamento = :dataLancamento WHERE idSancao = :idSancao");
            $sql->bindValue(':idSancao', $sancao->getIdSancao());
            $sql->bindValue(':idFuncionario', $sancao->getIdFuncionario());
            $sql->bindValue(':idUsuario', $sancao->getIdUsuario());
            $sql->bindValue(':idTipo', $sancao->getIdTipo());
            $sql->bindValue(':numDoc', $sancao->getNumDoc());
            $sql->bindValue(':qtdDias', $sancao->getQtdDias());
            $sql->bindValue(':motivo', $sancao->getMotivo());
            $sql->bindValue(':dataSancao', $sancao->getDataSancao());
            $sql->bindValue(':dataLancamento', $sancao->getDataLancamento());
            
            $sql->execute();
        }
        
        public function excluirSancao($sancao){
            $sql = $this->con->prepare('DELETE FROM sancao WHERE idSancao = :idSancao');
            $sql->bindValue(':idSancao', $sancao->getIdSancao());
            $sql->execute();
        }
        
        public function sancaoPorSemestre($dataInicial, $dataFinal) {
            $sql = $this->con->prepare("select * from sancao WHERE dataSancao between :dataInicial AND :dataFinal");
            $sql->bindValue(':dataInicial', $dataInicial);
            $sql->bindValue(':dataFinal', $dataFinal);
            $sql->execute();
            $lista = array();        
            $sancao = new Sancao();
            
            while ($sancao = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $sancao;
            }
            return $lista;
        }
    }