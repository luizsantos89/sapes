<?php
    require('TipoSancao.php');
    
    class TipoSancaoDAO{   
        private $con;
        
        function TipoSancaoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        public function incluirTipoSancao($tipoSancao){
            $sql = $this->con->prepare("insert into tipo_sancao (descricao, peso, idUsuario, dataCadastro) values (:descricao, :peso, :idUsuario, :dataCadastro)");
            $sql->bindValue(':descricao', $tipoSancao->getDescricao());
            $sql->bindValue(':peso', $tipoSancao->getPeso());
            $sql->bindValue(':idUsuario',$tipoSancao->getIdUsuario());
            $sql->bindValue(':dataCadastro',$tipoSancao->getDataCadastro());
            
            $sql->execute();
        }
        
        public function getTipoSancoes() {
            $query = "SELECT * FROM tipo_sancao";
            $rs = $this->con->query($query);
            $lista = array();
        
            $tipoSancao = new TipoSancao();
            
            while ($tipoSancao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $tipoSancao;
            }
            return $lista;
        }
        
        public function getTipoSancaoById($idTipoSancao) {
            $sql = $this->con->prepare("SELECT * FROM tipo_sancao where idTipo = :idTipoSancao");
            $sql->bindValue(':idTipoSancao', $idTipoSancao);
            $sql->execute();
            
            $tipoSancao = new TipoSancao();
            $tipoSancao = $sql->fetch(PDO::FETCH_OBJ);
            return $tipoSancao;
        }
        
        public function editarTipoSancao($tipoSancao){
            $sql = $this->con->prepare("UPDATE tipo_sancao SET descricao = :descricao, peso = :peso WHERE idTipo = :idTipoSancao");
            $sql->bindValue(':descricao', $tipoSancao->getDescricao());
            $sql->bindValue(':peso', $tipoSancao->getPeso());
            $sql->bindValue(':idTipoSancao',$tipoSancao->getIdTipo());
            
            $sql->execute();
        }
        
        public function excluirTipoSancao($tipoSancao){
            $sql = $this->con->prepare('DELETE FROM tipo_sancao WHERE idTipo = :idTipoSancao');
            $sql->bindValue(':idTipoSancao', $tipoSancao->getIdTipo());
            $sql->execute();
        }
    }