<?php
    require('Desempenho.php');
    
    class DesempenhoDAO{   
        private $con;
        public $porPagina;
        
        function DesempenhoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
                $this->porPagina = 25;
        }
        
        public function incluirDesempenho($desempenho){
            $sql = $this->con->prepare("insert into desempenho (idFuncionario, idUsuario, nota, semestre, ano, dataLancamento) values (:idFuncionario, :idUsuario, :nota, :semestre, :ano, :dataLancamento)");
            
            $sql->bindValue(':idFuncionario', $desempenho->getIdFuncionario());
            $sql->bindValue(':idUsuario',$desempenho->getIdUsuario());
            $sql->bindValue(':nota',$desempenho->getNota());
            $sql->bindValue(':semestre',$desempenho->getSemestre());
            $sql->bindValue(':ano',$desempenho->getAno());
            $sql->bindValue(':dataLancamento',$desempenho->getDataLancamento());
            
            $sql->execute();
        }
        
        public function getDesempenhos() {
            $query = "SELECT * FROM desempenho ORDER BY ano ASC, semestre ASC, nota DESC";
            $rs = $this->con->query($query);
            $lista = array();
        
            $desempenho = new Desempenho();
            
            while ($desempenho = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $desempenho;
            }
            return $lista;
        }
        
        public function getDesempenhosPeriodo($semestre,$ano) {
            $sql = $this->con->prepare("SELECT * FROM desempenho WHERE semestre = :semestre AND ano = :ano ORDER BY ano ASC, semestre ASC, nota DESC");
            $sql->bindValue(':semestre',$semestre);
            $sql->bindValue(':ano',$ano);
            $sql->execute();
            $lista = array();
        
            $desempenho = new Desempenho();
            
            while ($desempenho = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $desempenho;
            }
            return $lista;
        }
                
        
        public function getDesempenhoById($idDesempenho) {
            $sql = $this->con->prepare("SELECT * FROM desempenho where idDesempenho = :idDesempenho ORDER BY ano ASC, semestre ASC, nota DESC");
            $sql->bindValue(':idDesempenho', $idDesempenho);
            $sql->execute();
            
            $desempenho = new Desempenho();
            $desempenho = $sql->fetch(PDO::FETCH_OBJ);
            return $desempenho;
        }
        
        public function getDesempenhoPaginacao($desempenho) {
            $init = ($pagina-1) * $this->porPagina;
            
            $query = "SELECT * FROM desempenho ORDER BY ano ASC, semestre ASC, nota DESC limit $init, $this->porPagina";
            $rs = $this->con->query($query);
            $lista = array();
        
            $desempenho = new Desempenho();
            
            while ($desempenho = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $desempenho;
            }
            return $lista;
        }
        
        public function getPagina() {
            $result_total = $this->con->query("SELECT count(*) as total FROM desempenho")->fetch(PDO::FETCH_OBJ);
            
            $num_paginas = ceil($result_total->total/$this->porPagina)+1;
            
            return $num_paginas;
        }
        
        public function editarDesempenho($desempenho){
            $sql = $this->con->prepare("UPDATE desempenho SET nota =:nota, semestre=:semestre, ano=:ano WHERE idDesempenho = :idDesempenho");
            $sql->bindValue(':idDesempenho', $desempenho->getIdDesempenho());
            $sql->bindValue(':nota',$desempenho->getNota());
            $sql->bindValue(':semestre',$desempenho->getSemestre());
            $sql->bindValue(':ano',$desempenho->getAno());
                       
            $sql->execute();
        }
        
        public function excluirDesempenho($desempenho){
            $sql = $this->con->prepare('DELETE FROM desempenho WHERE idDesempenho = :idDesempenho');
            $sql->bindValue(':idDesempenho', $desempenho->getIdDesempenho());
            $sql->execute();
        }
        
        public function getDesempenhoFunc($desempenho) {
            $sql = $this->con->prepare("SELECT * FROM desempenho WHERE idFuncionario = :idFuncionario");
            $sql->bindValue(':idFuncionario',$desempenho->getIdFuncionario());
            $sql->execute();
            $lista = array();
        
            $desempenho = new Desempenho();
            
            while ($desempenho = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $desempenho;
            }
            return $lista;
        }
    }