<?php

    class Usuario {
        private $idUsuario;
        private $idTipoUsuario;
        private $nome;
        private $login;
        private $senha;
        private $ultimoAcesso;
        
        
        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }
        
        public function getIdUsuario() {
            return $this->idUsuario;
        }
        
        public function setIdTipoUsuario($idTipoUsuario) {
            $this->idTipoUsuario = $idTipoUsuario;
        }
        
        public function getIdTipoUsuario() {
            return $this->idTipoUsuario;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }
        
        public function getNome() {
            return $this->nome;
        }
        
        public function setLogin($login) {
            $this->login = $login;
        }
        
        public function getLogin(){
            return $this->login;
        }

        public function setSenha($senha) {
            $this->senha = $senha;
        }
        
        public function getSenha() {
            return $this->senha;
        }   

        public function setUltimoAcesso($ultimoAcesso) {
            $this->ultimoAcesso = $ultimoAcesso;
        }
        
        public function getUltimoAcesso() {
            return $this->ultimoAcesso;
        }          
    }