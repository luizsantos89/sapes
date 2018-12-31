<?php
    require('Secao.php');
    
    class SecaoDAO {   
        private $con;
        
        function SecaoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        public function incluirSecao($secao){
            $sql = $this->con->prepare("insert into secao (idDivisao, descricao) values (:idDivisao, :descricao)");
            $sql->bindValue(':idDivisao', $secao->getIdDivisao());
            $sql->bindValue(':descricao',$secao->getDescricao());
                        
            $sql->execute();
        }
        
        public function getSecoes() {
            $query = "SELECT * FROM secao ORDER BY descricao";
            $rs = $this->con->query($query);
            $lista = array();        
            $secao = new Secao();            
            while ($secao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $secao;
            }
            return $lista;
        }
        
        public function getSecaoById($idSecao) {
            $sql = $this->con->prepare("SELECT * FROM secao where idSecao = :idSecao");
            $sql->bindValue(':idSecao', $idSecao);
            $sql->execute();
            
            $secao = new Secao();
            $secao = $sql->fetch(PDO::FETCH_OBJ);
            return $secao;
        }
        
        public function editarSecao($secao){
            $sql = $this->con->prepare("UPDATE secao SET descricao = :descricao, idDivisao = :idDivisao WHERE idSecao = :idSecao");
            $sql->bindValue(":idDivisao",$secao->getIdDivisao());
            $sql->bindValue(":descricao",$secao->getDescricao());
            $sql->bindValue(":idSecao",$secao->getIdSecao());
                        
            $sql->execute();
        }
        
        public function excluirSecao($secao){
            $sql = $this->con->prepare('DELETE FROM secao WHERE idSecao = :idSecao');
            $sql->bindValue(':idSecao', $secao->getIdSecao());
            $sql->execute();
        }
    }