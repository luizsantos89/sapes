<?php

    class Aproveitamento {
        private $idAproveitamento;
        private $idFuncionario;
        private $idUsuario;
        private $semestre;
        private $ano;
        private $horasAbsenteismo;
        private $maxHorasAbsenteismo;
        private $maxFatorDisciplinar;
        private $pesoDesempenho;
        private $pesoAbsenteismo;
        private $pesoFatorDisciplinar;
        private $fatorDisciplinar;
        private $indiceDesempenho;
        private $indiceCargaHoraria;
        private $indiceAbsenteismo;
        private $indiceDisciplinar;
        private $indiceAproveitamento;
        private $dataLancamento;
        
        public function setIdAproveitamento($idAproveitamento) {
            $this->idAproveitamento = $idAproveitamento;
        }
        
        public function getIdAproveitamento() {
            return $this->idAproveitamento;
        }
        
        public function setIdFuncionario($idFuncionario) {
            $this->idFuncionario($idFuncionario);
        }
        
        public function getIdFuncionario() {
            return $this->idFuncionario;
        }
        
        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }
        
        public function getIdUsuario() {
            return $this->idUsuario;
        }
        
        public function setSemestre($semestre) {
            $this->semestre = $semestre;
        }
        
        public function getSemestre() {
            return $this->semestre;
        }
        
        public function setAno($ano) {
            $this->ano = $ano;
        }
        
        public function getAno() {
            return $this->ano;
        }
        
        public function setHorasAbsenteismo($horasAbsenteismo) {
            $this->horasAbsenteismo = $horasAbsenteismo;
        }

        public function getHorasAbsenteismo() {
            return $this->horasAbsenteismo;
        }
        
        public function setMaxHorasAbsenteismo($maxHorasAbsenteismo) {
            $this->maxHorasAbsenteismo = $maxHorasAbsenteismo;
        }
        
        public function getMaxHorasAbsenteismo() {
            return $this->maxHorasAbsenteismo;
        }
        
        public function setMaxFatorDisciplinar($maxFatorDisciplinar) {
            $this->maxFatorDisciplinar = $maxFatorDisciplinar;
        }
        
        public function getMaxFatorDisciplinar() {
            return $this->maxFatorDisciplinar;
        }
        
        public function setPesoDesempenho($pesoDesempenho) {
            $this->pesoDesempenho = $pesoDesempenho;
        }
        
        public function getPesoDesempenho() {
            return $this->pesoDesempenho;
        }

        public function setPesoAbsenteismo($pesoAbsenteismo) {
            $this->pesoAbsenteismo = $pesoAbsenteismo;
        }
        
        public function getPesoAbsenteismo() {
            return $this->pesoAbsenteismo;
        }
        
        public function setPesoFatorDisciplinar($pesoFatorDisciplinar) {
            $this->pesoFatorDisciplinar = $pesoFatorDisciplinar;
        }
        
        public function getPesoFatorDisciplinar() {
            return $this->pesoFatorDisciplinar;
        }
        
        public function setFatorDisciplinar($fatorDisciplinar) {
            $this->fatorDisciplinar = $fatorDisciplinar;
        }
        
        public function getFatorDisciplinar() {
            return $this->fatorDisciplinar;
        }
        
        public function setIndiceDesempenho($indiceDesempenho) {
            $this->indiceDesempenho = $indiceDesempenho;
        }
        
        public function getIndiceDesempenho() {
            return $this->indiceDesempenho;
        }
        
        public function setIndiceCargaHoraria($indiceCargaHoraria) {
            $this->indiceCargaHoraria = $indiceCargaHoraria;
        }
        
        public function getIndiceCargaHoraria() {
            return $this->indiceCargaHoraria;
        }
        
        public function setIndiceAbsenteismo($indiceAbsenteismo) {
            $this->indiceAbsenteismo = $indiceAbsenteismo;
        }
        
        public function getIndiceAbsenteismo() {
            return $this->indiceAbsenteismo;
        }
        
        public function setIndiceDisciplinar($indiceDisciplinar) {
            $this->indiceDisciplinar = $indiceDisciplinar;
        }
        
        public function getIndiceDisciplinar() {
            return $this->indiceDisciplinar;
        }
        
        public function setIndiceAproveitamento($indiceAproveitamento) {
            $this->indiceAproveitamento = $indiceAproveitamento;
        }
        
        public function getIndiceAproveitamento() {
            return $this->indiceAproveitamento;
        }
        
        public function setDataLancamento($dataLancamento) {
            $this->dataLancamento = $dataLancamento;
        }
        
        public function getDataLancamento(){
            return $this->dataLancamento;
        }
    }