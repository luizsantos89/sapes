<?php
    require('Aproveitamento.php');
    
    class AproveitamentoDAO{   
        private $con;
        public $porPagina;
        
        function AproveitamentoDAO(){
                $c = new Conexao();
                $this->con = $c->getConexao();
                $this->porPagina = 25;
        }
        
        public function incluirAproveitamento($aproveitamento){
            $sql = $this->con->prepare("insert into aproveitamento(idFuncionario, idUsuario, semestre, ano, horasAbsenteismo, maxHorasAbsenteismo, maxFatorDisciplinar, pesoDesempenho, pesoAbsenteismo, pesoFatorDisciplinar, fatorDisciplinar, indiceDesempenho, indiceCargaHoraria, indiceAbsenteismo, indiceDisciplinar, indiceAproveitamento, dataLancamento) values (:idFuncionario, :idUsuario, :semestre, :ano, :horasAbsenteismo, :maxHorasAbsenteismo, :maxFatorDisciplinar, :pesoDesempenho, :pesoAbsenteismo, :pesoFatorDisciplinar, :fatorDisciplinar, :indiceDesempenho, :indiceCargaHoraria, :indiceAbsenteismo, :indiceDisciplinar, :indiceAproveitamento, CURRENT_TIME)");
            
            $sql->bindValue(':idFuncionario', $aproveitamento->getIdFuncionario());
            $sql->bindValue(':idUsuario', $aproveitamento->getIdUsuario());
            $sql->bindValue(':semestre', $aproveitamento->getSemestre());
            $sql->bindValue(':ano', $aproveitamento->getAno());
            $sql->bindValue(':horasAbsenteismo', $aproveitamento->getHorasAbsenteismo());
            $sql->bindValue(':maxHorasAbsenteismo', $aproveitamento->getMaxHorasAbsenteismo());
            $sql->bindValue(':maxFatorDisciplinar', $aproveitamento->getMaxFatorDisciplinar());
            $sql->bindValue(':pesoDesempenho', $aproveitamento->getPesoDesempenho());
            $sql->bindValue(':pesoAbsenteismo', $aproveitamento->getPesoAbsenteismo());
            $sql->bindValue(':pesoFatorDisciplinar', $aproveitamento->getFatorDisciplinar());
            $sql->bindValue(':fatorDisciplinar', $aproveitamento->getFatorDisciplinar());
            $sql->bindValue(':indiceDesempenho', $aproveitamento->getIndiceDesempenho());
            $sql->bindValue(':indiceCargaHoraria',$aproveitamento->getIndiceCargaHoraria());
            $sql->bindValue(':indiceAbsenteismo', $aproveitamento->getIndiceAbsenteismo());
            $sql->bindValue(':indiceDisciplinar', $aproveitamento->getIndiceDisciplinar());
            $sql->bindValue(':indiceAproveitamento', $aproveitamento->getIndiceAproveitamento());
            
            $sql->execute();
        }
        
        public function getAproveitamento() {
            $query = "SELECT * FROM aproveitamento ORDER BY ano, semestre ASC, indiceAproveitamento DESC, idFuncionario ASC;";
            $rs = $this->con->query($query);
            $lista = array();
        
            $aproveitamento = new Aproveitamento();
            
            while ($aproveitamento = $rs->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $aproveitamento;
            }
            return $lista;
        }
        
        public function getAproveitamentoByFuncionario($idFuncionario) {
            $sql = $this->con->prepare("SELECT * FROM aproveitamento where idFuncionario = :idFuncionario ORDER BY ano, semestre;");
            $sql->bindValue(':idFuncionario', $idFuncionario);
            $sql->execute();
            $lista = array();
        
            $aproveitamento = new Aproveitamento();
            
            while ($aproveitamento = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $aproveitamento;
            }
            return $lista;
        }
        
        public function getAproveitamentoPorPeriodo($semestre,$ano) {
            $sql = $this->con->prepare("SELECT * FROM aproveitamento WHERE semestre = :semestre AND ano = :ano ORDER BY indiceAproveitamento DESC;");
            $sql->bindValue(':semestre',$semestre);
            $sql->bindValue(':ano',$ano);
            $sql->execute();
            $lista = array();
        
            $aproveitamento = new Aproveitamento();
            
            while ($aproveitamento = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $aproveitamento;
            }
            return $lista;
        }
        
        public function excluirAproveitamentoPeriodo($semestre,$ano) {
            $sql = $this->con->prepare("DELETE FROM aproveitamento WHERE semestre = :semestre AND ano = :ano;");
            $sql->bindValue(':semestre',$semestre);
            $sql->bindValue(':ano',$ano);
            $sql->execute();
        }
        
        
        public function getAproveitamentoById($idAproveitamento) {
            $sql = $this->con->prepare("SELECT * FROM aproveitamento where idAproveitamento = :idAproveitamento");
            $sql->bindValue(':idAproveitamento', $idAproveitamento);
            $sql->execute();
            
            $aproveitamento = new Aproveitamento();
            
            $aproveitamento = $sql->fetch(PDO::FETCH_OBJ);
            return $aproveitamento;
        }
        
        public function getAproveitamentoPaginacao($pagina) {
            $init = ($pagina-1) * $this->porPagina;
            
            $query = "SELECT * FROM aproveitamento ORDER BY ano, semestre LIMIT $init, $this->porPagina";
            $rs = $this->con->query($query);
            $lista = array();
        
            $aproveitamento = new Aproveitamento();
            
            while ($aproveitamento = $sql->fetch(PDO::FETCH_OBJ)) {
                $lista[] = $aproveitamento;
            }
            return $lista;
        }
        
        public function getPagina() {
            $result_total = $this->con->query("SELECT count(*) as total FROM aproveitamento")->fetch(PDO::FETCH_OBJ);
            
            $num_paginas = ceil($result_total->total/$this->porPagina)+1;
            
            return $num_paginas;
        }
        
        public function editarAproveitamento($aproveitamento){
            $sql = $this->con->prepare("UPDATE aproveitamento SET idFuncionario = :idFuncionario, idUsuarioLancamento =: idUsuarioLancamento, semestre = :semestre, ano = :ano, horasAbsenteismo = :horasAbsenteismo, maxHorasAbsenteismo = :maxHorasAbsenteismo, maxFatorDisciplinar = :maxFatorDisciplinar, pesoDesempenho = :pesoDesempenho, pesoAbsenteismo = :pesoAbsenteismo, pesoFatorDisciplinar = :pesoFatorDisciplinar, fatorDisciplinar = :fatorDisciplinar, indiceDesempenho = :indiceDesempenho, indiceCargaHoraria = :indiceCargaHoraria, indiceAbsenteismo = :indiceAbsenteismo, indiceDisciplinar = :indiceDisciplinar, indiceAproveitamento = :indiceAproveitamento, dataLancamento = :dataLancamento, idUsuarioUltimaAlteracao = :idUsuarioUltimaAlteracao, dataUltimaAlteracao = CURRENT_TIME) WHERE idAproveitamento = :idAproveitamento");
            

            $sql->bindValue(':idFuncionario', $aproveitamento->getIdFuncionario());
            $sql->bindValue(':idUsuario', $aproveitamento->getIdUsuario());
            $sql->bindValue(':semestre', $aproveitamento->getSemestre());
            $sql->bindValue(':ano', $aproveitamento->getAno());
            $sql->bindValue(':horasAbsenteismo', $aproveitamento->getHorasAbsenteismo());
            $sql->bindValue(':maxHorasAbsenteismo', $aproveitamento->getMaxHorasAbsenteismo());
            $sql->bindValue(':maxFatorDisciplinar', $aproveitamento->getMaxFatorDisciplinar());
            $sql->bindValue(':pesoDesempenho', $aproveitamento->getPesoDesempenho());
            $sql->bindValue(':pesoAbsenteismo', $aproveitamento->getPesoAbsenteismo());
            $sql->bindValue(':pesoFatorDisciplinar', $aproveitamento->getFatorDisciplinar());
            $sql->bindValue(':fatorDisciplinar', $aproveitamento->getFatorDisciplinar());
            $sql->bindValue(':indiceDesempenho', $aproveitamento->getIndiceDesempenho());
            $sql->bindValue(':indiceCargaHoraria',$aproveitamento->getIndiceCargaHoraria());
            $sql->bindValue(':indiceAbsenteismo', $aproveitamento->getIndiceAbsenteismo());
            $sql->bindValue(':indiceDisciplinar', $aproveitamento->getIndiceDisciplinar());
            $sql->bindValue(':indiceAproveitamento', $aproveitamento->getIndiceAproveitamento());
            $sql->bindValue(':dataLancamento', $aproveitamento->getDataLancamento());
            $sql->bindValue(':idUsuarioUltimaAlteracao', $aproveitamento->getIdUsuarioUltimaAlteracao());
                       
            $sql->execute();
        }
        
        
        public function excluirAproveitamento($aproveitamento){
            $sql = $this->con->prepare('DELETE FROM aproveitamento WHERE idAproveitamento = :idAproveitamento');
            $sql->bindValue(':idAproveitamento', $aproveitamento->getIdAproveitamento());
            $sql->execute();
        }
    }