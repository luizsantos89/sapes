<?php

    class Divisao {
        private $idDivisao;
        private $idGerencia;
        private $descricao;

        public function setIdDivisao($idDivisao) {
            $this->idDivisao = $idDivisao;
        }
        
        public function getIdDivisao() {
            return $this->idDivisao;
        }
        
        public function setIdGerencia($idGerencia) {
            $this->idGerencia = $idGerencia;
        }
        
        public function getIdGerencia() {
            return $this->idGerencia;
        }
        
        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }
    
    }
?>