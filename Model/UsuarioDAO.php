<?php
    //require('../includes/conexao.inc');
    require('Usuario.php');
    
    class UsuarioDAO{   
        private $con;
        
        function UsuarioDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
        }
        
        public function login($usuario, $senha){
            $sql = $this->con->prepare("SELECT * FROM usuario WHERE login = :login AND senha = :senha");
            $sql.bindValue(":login",$login);
            $sql.bindValue(":senha",$senha);
            
            $sql.execute();
            
            return $sql->fetch(PDO::FETCH_OBJ);
        }
        
        public function getUsuarios() {
            $query = "SELECT * FROM usuario";
            $rs = $this->con->query($query);
            $lista = array();
        
            $usuario = new Usuario();
            
            while ($usuario = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $usuario;
            }
            return $lista;
        }
        
        public function getFuncionarioByID($idUsuario) {
            $sql = $this->con->prepare("SELECT * FROM usuario where idUsuario = :idUsuario");
            $sql->bindValue(':idUsuario', $idUsuario);
            $sql->execute();
            
            $usuario = new Usuario();
            $usuario = $sql->fetch(PDO::FETCH_OBJ);
            return $usuario;
        }
        
        public function editarUsuario($funcionario){
            $sql = $this->con->prepare("UPDATE funcionario SET nome = :nome, email = :email, usuario = :usuario, cpf = :cpf, dataDemissao = :dataDemissao WHERE idUsuario = :idUsuario");
            $sql->bindValue(":idUsuario",$funcionario->idUsuario);
            $sql->bindValue(":nome",$funcionario->nome);
            $sql->bindValue(":email",$funcionario->email);
            $sql->bindValue(":usuario",$funcionario->usuario);
            $sql->bindValue(":cpf",$funcionario->cpf);
            $sql->bindValue(":dataDemissao",$funcionario->dataDemissao);
            $sql->execute();
        }
    }