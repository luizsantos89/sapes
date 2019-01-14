<?php

    class Absenteismo {
        private $idAbsenteismo;
        private $idFuncionario;
        private $idUsuario;
        private $qtdHoras;
        private $mes;
        private $ano;
        private $dataLancamento;
    
        public function getIdAbsenteismo() {
            return $this->idAbsenteismo;
        }
        
        public function setIdAbsenteismo($idAbsenteismo) {
            $this->idAbsenteismo = $idAbsenteismo;
        }
        
        public function getIdFuncionario() {
            return $this->idFuncionario;
        }
        
        public function setIdFuncionario($idFuncionario) {
            $this->idFuncionario = $idFuncionario;
        }
        
        public function getIdUsuario() {
            return $this->idUsuario;
        }
        
        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }
        
        public function getQtdHoras() {
            return $this->qtdHoras;
        }
        
        public function setQtdHoras($qtdHoras) {
            $this->qtdHoras = $qtdHoras;
        }
        
        public function getMes() {
            return $this->mes;
        }
        
        public function setMes($mes) {
            $this->mes = $mes;
        }
        
        public function getAno() {
            return $this->ano;
        }
        
        public function setAno($ano) {
            $this->ano = $ano;
        }
        
        public function getDataLancamento() {
            return $this->dataLancamento;
        }
        
        public function setDataLancamento($dataLancamento) {
            $this->dataLancamento = $dataLancamento;
        }
    }
?>