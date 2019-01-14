<?php
    require('Absenteismo.php');
    
    class AbsenteismoDAO{   
        private $con;
        public $porPagina;
        
        function AbsenteismoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
                $this->porPagina = 25;
        }
        
        public function incluirAbsenteismo($absenteismo){
            $sql = $this->con->prepare("insert into absenteismo (idFuncionario, idUsuario, qtdHoras, mes, ano, dataLancamento) values (:idFuncionario, :idUsuario, :qtdHoras, :mes, :ano, :dataLancamento)");
            
            $sql->bindValue(':idFuncionario', $absenteismo->getIdFuncionario());
            $sql->bindValue(':idUsuario',$absenteismo->getIdUsuario());
            $sql->bindValue(':qtdHoras',$absenteismo->getQtdHoras());
            $sql->bindValue(':mes',$absenteismo->getMes());
            $sql->bindValue(':ano',$absenteismo->getAno());
            $sql->bindValue(':dataLancamento',$absenteismo->getDataLancamento());
            
            $sql->execute();
        }
        
        public function getAbsenteismo() {
            $query = "SELECT * FROM absenteismo ORDER BY ano, mes";
            $rs = $this->con->query($query);
            $lista = array();
        
            $absenteismo = new Absenteismo();
            
            while ($absenteismo = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $absenteismo;
            }
            return $lista;
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
        
        public function getAbsenteismoPeriodo($mes,$ano) {
            $sql = $this->con->prepare("SELECT * FROM absenteismo WHERE mes = :mes AND ano = :ano");
            $sql->bindValue(':mes',$mes);
            $sql->bindValue(':ano',$ano);
            $sql->execute();
            $lista = array();
        
            $absenteismo = new Absenteismo();
            
            while ($absenteismo = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $absenteismo;
            }
            return $lista;
        }
        
        
        public function getAbsenteismoById($idAbsenteismo) {
            $sql = $this->con->prepare("SELECT * FROM absenteismo where idAbsenteismo = :idAbsenteismo");
            $sql->bindValue(':idAbsenteismo', $idAbsenteismo);
            $sql->execute();
            
            $absenteismo = new Absenteismo();
            $absenteismo = $sql->fetch(PDO::FETCH_OBJ);
            return $absenteismo;
        }
        
        public function getAbsenteismoPaginacao($pagina) {
            $init = ($pagina-1) * $this->porPagina;
            
            $query = "SELECT * FROM absenteismo ORDER BY dataLancamento limit $init, $this->porPagina";
            $rs = $this->con->query($query);
            $lista = array();
        
            $absenteismo = new Absenteismo();
            
            while ($absenteismo = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $absenteismo;
            }
            return $lista;
        }
        
        public function getPagina() {
            $result_total = $this->con->query("SELECT count(*) as total FROM funcionario")->fetch(PDO::FETCH_OBJ);
            
            $num_paginas = ceil($result_total->total/$this->porPagina)+1;
            
            return $num_paginas;
        }
        
        public function editarAbsenteismo($absenteismo){
            $sql = $this->con->prepare("UPDATE absenteismo SET qtdHoras =:qtdHoras, mes=:mes, ano=:ano WHERE idAbsenteismo = :idAbsenteismo");
            $sql->bindValue(':idAbsenteismo', $absenteismo->getIdAbsenteismo());
            $sql->bindValue(':qtdHoras',$absenteismo->getQtdHoras());
            $sql->bindValue(':mes',$absenteismo->getMes());
            $sql->bindValue(':ano',$absenteismo->getAno());
                       
            $sql->execute();
        }
        
        public function excluirAbsenteismo($absenteismo){
            $sql = $this->con->prepare('DELETE FROM absenteismo WHERE idAbsenteismo = :idAbsenteismo');
            $sql->bindValue(':idAbsenteismo', $absenteismo->getIdAbsenteismo());
            $sql->execute();
        }
    }