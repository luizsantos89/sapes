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
            $sql = $this->con->prepare("UPDATE usuario SET idTipoUsuario = :idTipoUsuario, nome = :nome, login = :login WHERE idUsuario = :idUsuario");
            $sql->bindValue(":idTipoUsuario",$usuario->getIdTipoUsuario());
            $sql->bindValue(":nome",$usuario->getNome());
            $sql->bindValue(":login",$usuario->getLogin());
            $sql->bindValue(":idUsuario",$usuario->getIdUsuario());
            $sql->execute();
        }         
        
        public function alteraSenhaUsuario($usuario){
            $sql = $this->con->prepare("UPDATE usuario SET senha = :senha WHERE idUsuario = :idUsuario");
            $sql->bindValue(":senha", $usuario->senha);
            $sql->bindValue(":idUsuario",$usuario->idUsuario);
            $sql->execute();
        }
        
        public function novoUsuario($usuario) {
            $sql = $this->con->prepare("INSERT INTO usuario(idTipoUsuario,nome, login, senha) VALUES(:idTipoUsuario,:nome, :login, :senha)");
            $sql->bindValue(":idTipoUsuario",$usuario->getIdTipoUsuario());
            $sql->bindValue(":nome",$usuario->getNome());
            $sql->bindValue(":login",$usuario->getLogin());
            $sql->bindValue(":senha",$usuario->getSenha());
            $sql->execute();
        }
        
        public function excluiUsuario($usuario) {
            $sql = $this->con->prepare("DELETE FROM usuario WHERE idUsuario = :idUsuario");
            $sql->bindValue(":idUsuario",$usuario->getIdUsuario());
            $sql->execute();
        }
        
        public function resetaSenha($idUsuario) {
            $sql = $this->con->prepare("UPDATE usuario SET senha = md5('imbel@123') WHERE idUsuario = :idUsuario");
            $sql->bindValue(":idUsuario", $idUsuario);
            $sql->execute();
        }
        
    }