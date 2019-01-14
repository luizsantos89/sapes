<?php
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
        
        public function getUsuarioById($idUsuario) {
            $sql = $this->con->prepare("SELECT * FROM usuario where idUsuario = :idUsuario");
            $sql->bindValue(':idUsuario', $idUsuario);
            $sql->execute();
            
            $usuario = new Usuario();
            $usuario = $sql->fetch(PDO::FETCH_OBJ);
            return $usuario;
        }
        
        public function editarUsuario($usuario){
            $sql = $this->con->prepare("UPDATE usuario SET nome = :nome, login = :login, senha = :senha WHERE idUsuario = :idUsuario");
            $sql->bindValue(":idUsuario",$usuario->idUsuario);
            $sql->bindValue(":nome",$usuario->nome);
            $sql->bindValue(":login",$usuario->login);
            $sql->bindValue(":senha",$usuario->senha);
            $sql->execute();
        }
        
        public function novoUsuario($usuario) {
            $sql = $this->con->prepare("INSERT INTO usuario(nome, login, senha) VALUES(:nome, :login, :senha)");
            $sql->bindValue(":nome",$usuario->nome);
            $sql->bindValue(":login",$usuario->login);
            $sql->bindValue(":senha",$usuario->senha);
            $sql->execute();
        }
        
    }