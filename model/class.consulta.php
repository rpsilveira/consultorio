<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class ConsultaModel {
      
        private $consulta_id;
        private $data;
        private $dentista_id;
        private $paciente_id;
        private $sala_id;
        private $observacao;
        private $tipoconsulta_id;
        private $horario;
        
        public function __construct() { }
        
        //setters
        public function setConsultaId($consulta_id) {
          $this->consulta_id = $consulta_id;
        }
        public function setData($data) {
          $this->data = $data;
        }
        public function setDentistaId($dentista_id) {
          $this->dentista_id = $dentista_id;
        }
        public function setPacienteId($paciente_id) {
          $this->paciente_id = $paciente_id;
        }
        public function setSalaId($sala_id) {
          $this->sala_id = $sala_id;
        }
        public function setObservacao($observacao) {
          $this->observacao = $observacao;
        }
        public function setTipoConsultaId($tipoconsulta_id) {
          $this->tipoconsulta_id = $tipoconsulta_id;
        }
        public function setHorario($horario) {
          $this->horario = $horario;
        }
        
        //getters
        public function getConsultaId() {
          return $this->consulta_id;
        }
        public function getData() {
          return $this->data;
        }
        public function getDentistaId() {
          return $this->dentista_id;
        }
        public function getPacienteId() {
          return $this->paciente_id;
        }
        public function getSalaId() {
          return $this->sala_id;
        }
        public function getObservacao() {
          return $this->observacao;
        }
        public function getTipoConsultaId() {
          return $this->tipoconsulta_id;
        }
        public function getHorario() {
          return $this->horario;
        }
        
        public function incluirConsulta($mat_codigo, $mat_quant, $srv_codigo, $srv_quant) {
        
            $db = Dao::abreConexao();
            
            $db->beginTransaction();
        
            try {

                //insere o cabeçalho da consulta
                $query = "INSERT INTO tbconsulta(data, dentista_id, paciente_id, sala_id, tipoconsulta_id, horario, observacao)
                          VALUES(?, ?, ?, ?, ?, ?, ?)";
                          
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getDentistaId(), PDO::PARAM_INT);
                $sql->bindValue(3, $this->getPacienteId(), PDO::PARAM_STR);
                $sql->bindValue(4, $this->getSalaId(), PDO::PARAM_STR);
                $sql->bindValue(5, $this->getTipoConsultaId(), PDO::PARAM_STR);
                $sql->bindValue(6, $this->getHorario(), PDO::PARAM_STR);
                $sql->bindValue(7, $this->getObservacao(), PDO::PARAM_STR);
                
                $sql->execute();
                
                $this->setConsultaId($db->lastInsertId());

                //insere os materiais
                for ($i = 0; $i < sizeof($mat_codigo); $i++) {
                    $query = "INSERT INTO tbconsulta_materiais(consulta_id, material_id, quantidade)
                              VALUES(?, ?, ?)";
                              
                    $sql = $db->prepare($query);
                    
                    $sql->bindValue(1, $this->getConsultaId(), PDO::PARAM_INT);
                    $sql->bindValue(2, $mat_codigo[$i], PDO::PARAM_INT);
                    $sql->bindValue(3, $mat_quant[$i], PDO::PARAM_STR);
                    
                    $sql->execute();
                }
                
                //insere os servicos
                for ($i = 0; $i < sizeof($srv_codigo); $i++) {
                    $query = "INSERT INTO tbconsulta_servicos(consulta_id, servico_id, quantidade)
                              VALUES(?, ?, ?)";
                               
                    $sql = $db->prepare($query);
                    
                    $sql->bindValue(1, $this->getConsultaId(), PDO::PARAM_INT);
                    $sql->bindValue(2, $srv_codigo[$i], PDO::PARAM_INT);
                    $sql->bindValue(3, $srv_quant[$i], PDO::PARAM_STR);
                    
                    $sql->execute();
                }

                $retorno = $db->commit();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();

                $db->rollBack();
              
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }

        public function listarConsulta($campo, $valor) {
        
            $query = "SELECT
                      tbconsulta.consulta_id,
                      tbconsulta.horario,
                      cast(tbconsulta.data as date) as data,
                      dentista.nome AS dentista,
                      paciente.nome AS paciente,
                      tbsalasatendimento.nome AS sala,
                      tbtipoconsulta.descricao AS tipoconsulta
                      FROM tbconsulta
                      LEFT JOIN tbpessoa dentista ON (dentista.pessoa_id = tbconsulta.dentista_id)
                      LEFT JOIN tbpessoa paciente ON (paciente.pessoa_id = tbconsulta.paciente_id)					  
                      LEFT JOIN tbsalasatendimento ON (tbsalasatendimento.sala_id = tbconsulta.sala_id)
                      LEFT JOIN tbtipoconsulta ON (tbtipoconsulta.tipoconsulta_id = tbconsulta.tipoconsulta_id)
                      WHERE ? LIKE ?
                      ORDER BY tbconsulta.data, tbconsulta.horario";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $campo, PDO::PARAM_STR);
            $sql->bindValue(2, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarConsultaPaciente($paciente_id) {
        
            $query = "SELECT
                      tbconsulta.consulta_id,
                      tbconsulta.horario,
                      cast(tbconsulta.data as date) as data,
                      dentista.nome AS dentista,
                      paciente.nome AS paciente,
                      tbsalasatendimento.nome AS sala,
                      tbtipoconsulta.descricao AS tipoconsulta
                      FROM tbconsulta
                      LEFT JOIN tbpessoa dentista ON (dentista.pessoa_id = tbconsulta.dentista_id)
                      LEFT JOIN tbpessoa paciente ON (paciente.pessoa_id = tbconsulta.paciente_id)
                      LEFT JOIN tbsalasatendimento ON (tbsalasatendimento.sala_id = tbconsulta.sala_id)
                      LEFT JOIN tbtipoconsulta ON (tbtipoconsulta.tipoconsulta_id = tbconsulta.tipoconsulta_id)
                      WHERE tbconsulta.paciente_id = ?
                      ORDER BY tbconsulta.data, tbconsulta.horario";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $paciente_id, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarConsulta() {
          
            $query = "SELECT
                      consulta_id, 
                      cast(data as date) as data,
                      dentista_id,
                      paciente_id,
                      sala_id,
                      tipoconsulta_id,
                      horario,
                      observacao
                      FROM tbconsulta
                      WHERE consulta_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getConsultaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarMatConsulta() {
        
            $query = "SELECT
                      tbconsulta_materiais.consultamat_id, 
                      tbconsulta_materiais.consulta_id,
                      tbconsulta_materiais.material_id,
                      tbconsulta_materiais.quantidade,
                      tbmateriais.nome AS material
                      FROM tbconsulta_materiais
                      JOIN tbmateriais ON (tbmateriais.material_id = tbconsulta_materiais.material_id)
                      WHERE tbconsulta_materiais.consulta_id = ?
                      ORDER BY tbmateriais.nome";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getConsultaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarServConsulta() {
        
            $query = "SELECT
                      tbconsulta_servicos.consultasrv_id, 
                      tbconsulta_servicos.consulta_id,
                      tbconsulta_servicos.servico_id,
                      tbconsulta_servicos.quantidade,
                      tbservicos.nome AS servico
                      FROM tbconsulta_servicos
                      JOIN tbservicos ON (tbservicos.servico_id = tbconsulta_servicos.servico_id)
                      WHERE tbconsulta_servicos.consulta_id = ?
                      ORDER BY tbservicos.nome";
                      
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getConsultaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
?>