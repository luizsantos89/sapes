<?php
    require('Divisao.php');
    
    class DivisaoDAO {   
        private $con;
        
        function DivisaoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        
        public function incluirDivisao($divisao){
            $sql = $this->con->prepare("insert into divisao (idGerencia, descricao) values (:idGerencia, :descricao)");
            $sql->bindValue(':idGerencia', $divisao->getIdDivisao());
            $sql->bindValue(':descricao',$divisao->getDescricao());
                        
            $sql->execute();
        }
        
        public function getDivisoes() {
            $query = "SELECT * FROM divisao ORDER BY idGerencia, descricao";
            $rs = $this->con->query($query);
            $lista = array();        
            $divisao = new Divisao();            
            while ($divisao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $divisao;
            }
            return $lista;
        }
        
        public function getDivisaoById($idDivisao) {
            $sql = $this->con->prepare("SELECT * FROM divisao where idDivisao = :idDivisao");
            $sql->bindValue(':idDivisao', $idDivisao);
            $sql->execute();
            
            $divisao = new Divisao();
            $divisao = $sql->fetch(PDO::FETCH_OBJ);
            return $divisao;
        }
        
        public function editarDivisao($divisao){
            $sql = $this->con->prepare("UPDATE divisao SET descricao = :descricao, idGerencia = :idGerencia WHERE idDivisao = :idDivisao");
            $sql->bindValue(":idDivisao",$divisao->getIdDivisao());
            $sql->bindValue(":descricao",$divisao->getDescricao());
            $sql->bindValue(":idGerencia",$divisao->getIdGerencia());
                        
            $sql->execute();
        }
        
        public function excluirDivisao($divisao){
            $sql = $this->con->prepare('DELETE FROM divisao WHERE idDivisao = :idDivisao');
            $sql->bindValue(':idDivisao', $divisao->getIdDivisao());
            $sql->execute();
        }
    }