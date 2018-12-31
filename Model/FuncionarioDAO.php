<?php
    require('Funcionario.php');
    
    class FuncionarioDAO{   
        private $con;
        
        function FuncionarioDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        public function incluirFuncionario($funcionario){
            $sql = $this->con->prepare("insert into funcionario (idUsuario, idSecao, nome, cargo, situacao, dataAdmissao, cracha, dataCadastro, funcAtivo) values (:idUsuario, :idSecao, :nome, :cargo, :situacao, :dataAdmissao, :cracha, :dataCadastro, :funcAtivo)");
            $sql->bindValue(':idUsuario', $funcionario->getIdUsuario());
            $sql->bindValue(':idSecao',$funcionario->getIdSecao());
            $sql->bindValue(':nome',$funcionario->getNome());
            $sql->bindValue(':cargo',$funcionario->getCargo());
            $sql->bindValue(':situacao',$funcionario->getSituacao());
            $sql->bindValue(':dataAdmissao',$funcionario->getDataAdmissao());
            $sql->bindValue(':cracha',$funcionario->getCracha());
            $sql->bindValue(':dataCadastro',$funcionario->getDataCadastro());
            $sql->bindValue(':funcAtivo',$funcionario->getFuncAtivo());
            
            if ($funcionario->getFuncAtivo == 0) {
                $sql->bindValue(":dataInativacao", $funcionario->getDataInativacao());
            } else {
                $sql->bindValue(":dataInativacao", null);                
            }
            
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
        
        public function getFuncionariosByCargo($cargo) {
            $sql = $this->con->prepare("SELECT * FROM funcionario ORDER BY funcAtivo DESC, cracha ASC where cargo = :cargo");
            $sql->bindValue(':cargo', $cargo);
            $rs = $this->con->query($query);
            $lista = array();
        
            $funcionario = new Funcionario();
            
            while ($funcionario = $rs->fetch(PDO::FETCH_OBJ)) {
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
            $sql = $this->con->prepare("UPDATE funcionario SET nome = :nome, cracha = :cracha, cargo = :cargo, situacao = :situacao, funcAtivo = :funcAtivo, dataInativacao = :dataInativacao, dataAdmissao = :dataAdmissao, idSecao = :idSecao WHERE idFuncionario = :idFuncionario");
            $sql->bindValue(":nome",$funcionario->getNome());
            $sql->bindValue(":cracha",$funcionario->getCracha());
            $sql->bindValue(":cargo",$funcionario->getCargo());
            $sql->bindValue(':situacao', $funcionario->getSituacao());
            $sql->bindValue(":funcAtivo",$funcionario->getFuncAtivo());
            $sql->bindValue(":dataInativacao", $funcionario->getDataInativacao());
            $sql->bindValue(":dataAdmissao", $funcionario->getDataAdmissao());
            $sql->bindValue(":idSecao",$funcionario->getIdSecao());
            $sql->bindValue(":idFuncionario",$funcionario->getIdFuncionario());
                       
            
            $sql->execute();
        }
        
        public function excluiFuncionario($funcionario){
            $sql = $this->con->prepare('DELETE FROM funcionario WHERE idFuncionario = :idFuncionario');
            $sql->bindValue(':idFuncionario', $funcionario->getIdFuncionario());
            $sql->execute();
        }
    }