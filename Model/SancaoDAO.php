<?php
    require('Sancao.php');
    
    class SancaoDAO{   
        private $con;
        
        function SancaoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
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
            $query = "SELECT * FROM sancao ORDER BY idFuncionario ASC, dataSancao DESC";
            $rs = $this->con->query($query);
            $lista = array();
        
            $sancao = new Sancao();
            
            while ($sancao = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $sancao;
            }
            return $lista;
        }
        
        public function getSancaoByFunc($idFuncionario) {
            $sql = $this->con->prepare("SELECT * FROM sancao where idFuncionario = :idFuncionario");
            $sql->bindValue(':idFuncionario', $idFuncionario);
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
            $sql = $this->con->prepare('DELETE FROM funcionario WHERE idSancao = :idSancao');
            $sql->bindValue(':idSancao', $sancao->getIdSancao());
            $sql->execute();
        }
    }