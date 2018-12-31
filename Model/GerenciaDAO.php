<?php
    require('Gerencia.php');
    
    class GerenciaDAO {   
        private $con;
        
        function GerenciaDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        
        public function incluirGerencia($gerencia){
            $sql = $this->con->prepare("insert into gerencia (descricao) values (:descricao)");
            $sql->bindValue(':descricao',$gerencia->getDescricao());
                        
            $sql->execute();
        }
        
        public function getGerencias() {
            $query = "SELECT * FROM gerencia";
            $rs = $this->con->query($query);
            $lista = array();        
            $gerencia = new Gerencia();            
            while ($gerencia = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $gerencia;
            }
            return $lista;
        }
        
        public function getGerenciaById($idGerencia) {
            $sql = $this->con->prepare("SELECT * FROM gerencia where idGerencia = :idGerencia");
            $sql->bindValue(':idGerencia', $idGerencia);
            $sql->execute();
            
            $gerencia = new Gerencia();
            $gerencia = $sql->fetch(PDO::FETCH_OBJ);
            return $gerencia;
        }
        
        public function editarGerencia($gerencia){
            $sql = $this->con->prepare("UPDATE gerencia SET descricao = :descricao WHERE idGerencia = :idGerencia");
            $sql->bindValue(":idGerencia",$gerencia->getIdGerencia());
            $sql->bindValue(":descricao",$gerencia->getDescricao());
                        
            $sql->execute();
        }
        
        public function excluirGerencia($gerencia){
            $sql = $this->con->prepare('DELETE FROM gerencia WHERE idGerencia = :idGerencia');
            $sql->bindValue(':idGerencia', $gerencia->getIdGerencia());
            $sql->execute();
        }
    }