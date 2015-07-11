<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class AgendaModel {
      
        private $agenda_id;
        private $data;
        private $dentista_id;
        private $paciente_id;
        private $sala_id;
        private $observacao;
        private $tipoconsulta_id;
        private $horario;
        
        public function __construct() { }
        
        //setters
        public function setAgendaId($agenda_id) {
          $this->agenda_id = $agenda_id;
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
        public function getAgendaId() {
          return $this->agenda_id;
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
        
        public function incluirAgenda() {
        
            try {
        
                $query = "INSERT INTO tbagenda(data, dentista_id, paciente_id, sala_id, tipoconsulta_id, horario, observacao)
                          VALUES(?, ?, ?, ?, ?, ?, ?)";
                          
                $db = Dao::abreConexao();

                $sql = $db->prepare($query);

                $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getDentistaId(), PDO::PARAM_INT);
                $sql->bindValue(3, $this->getPacienteId(), PDO::PARAM_INT);
                $sql->bindValue(4, $this->getSalaId(), PDO::PARAM_INT);
                $sql->bindValue(5, $this->getTipoConsultaId(), PDO::PARAM_INT);
                $sql->bindValue(6, $this->getHorario(), PDO::PARAM_STR);
                $sql->bindValue(7, $this->getObservacao(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setAgendaid($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarAgenda() {
          
            $query = "UPDATE tbagenda SET 
                      data = ?,
                      dentista_id = ?,
                      paciente_id = ?,
                      sala_id = ?,
                      tipoconsulta_id = ?,
                      horario = ?,
                      observacao = ?
                      WHERE agenda_id = ?";
                      
            $sql = Dao::abreConexao()->prepare($query);
          
            $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getDentistaId(), PDO::PARAM_INT);
            $sql->bindValue(3, $this->getPacienteId(), PDO::PARAM_INT);
            $sql->bindValue(4, $this->getSalaId(), PDO::PARAM_INT);
            $sql->bindValue(5, $this->getTipoConsultaId(), PDO::PARAM_INT);
            $sql->bindValue(6, $this->getHorario(), PDO::PARAM_STR);
            $sql->bindValue(7, $this->getObservacao(), PDO::PARAM_STR);
            $sql->bindValue(8, $this->getAgendaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirAgenda() {
        
            try {
          
                $query = "DELETE FROM tbagenda WHERE agenda_id = ?";
          
                $sql = Dao::abreConexao()->prepare($query);
              
                $sql->bindValue(1, $this->getAgendaId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarAgenda($campo, $valor) {
        
            $query = "SELECT
                      tbagenda.agenda_id,
                      CAST(tbagenda.data as date) AS data,
                      tbagenda.dentista_id,
                      tbagenda.paciente_id,
                      tbagenda.sala_id,
                      tbagenda.tipoconsulta_id,
                      tbagenda.horario,
                      tbagenda.observacao,
                      tbagenda.cancelada,
                      dentista.nome as dentista,
                      paciente.nome as paciente,
                      tbsalasatendimento.nome as sala
                      FROM tbagenda
                      LEFT JOIN tbpessoa dentista ON (dentista.pessoa_id = tbagenda.dentista_id)
                      LEFT JOIN tbpessoa paciente ON (paciente .pessoa_id = tbagenda.paciente_id)
                      LEFT JOIN tbsalasatendimento ON (tbsalasatendimento.sala_id = tbagenda.sala_id)
                      WHERE tbagenda.? LIKE ?
                      ORDER BY tbagenda.data, tbagenda.horario";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $campo, PDO::PARAM_STR);
            $sql->bindValue(2, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarAgendaPaciente($paciente_id) {
        
            $query = "SELECT
                      tbagenda.agenda_id,
                      CAST(tbagenda.data as date) AS data,
                      tbagenda.dentista_id,
                      tbagenda.paciente_id,
                      tbagenda.sala_id,
                      tbagenda.tipoconsulta_id,
                      tbagenda.horario,
                      tbagenda.observacao,
                      tbagenda.cancelada,
                      dentista.nome as dentista,
                      paciente.nome as paciente,
                      tbsalasatendimento.nome as sala
                      FROM tbagenda
                      LEFT JOIN tbpessoa dentista ON (dentista.pessoa_id = tbagenda.dentista_id)
                      LEFT JOIN tbpessoa paciente ON (paciente .pessoa_id = tbagenda.paciente_id)
                      LEFT JOIN tbsalasatendimento ON (tbsalasatendimento.sala_id = tbagenda.sala_id)
                      WHERE tbagenda.paciente_id = ?
                      ORDER BY tbagenda.data, tbagenda.horario";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $paciente_id, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarDia($data_atual) {
        
            $query = "SELECT
                      tbagenda.agenda_id,
                      CAST(tbagenda.data as date) AS data,
                      tbagenda.dentista_id,
                      tbagenda.paciente_id,
                      tbagenda.sala_id,
                      tbagenda.tipoconsulta_id,
                      tbagenda.horario,
                      tbagenda.observacao,
                      tbagenda.cancelada,
                      dentista.nome as dentista,
                      paciente.nome as paciente,
                      tbsalasatendimento.nome as sala
                      FROM tbagenda
                      LEFT JOIN tbpessoa dentista ON (dentista.pessoa_id = tbagenda.dentista_id)
                      LEFT JOIN tbpessoa paciente ON (paciente.pessoa_id = tbagenda.paciente_id)
                      LEFT JOIN tbsalasatendimento ON (tbsalasatendimento.sala_id = tbagenda.sala_id)
                      WHERE tbagenda.data = ?
                      ORDER BY tbagenda.data";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $data_atual, PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarAgenda() {
          
            $query = "SELECT
                      agenda_id,
                      CAST(data AS date) as data,
                      dentista_id,
                      paciente_id,
                      sala_id,
                      tipoconsulta_id,
                      horario,
                      cancelada,
                      observacao
                      FROM tbagenda
                      WHERE agenda_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getAgendaId, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function cancelarAgenda() {
          
            $query = "UPDATE tbagenda 
                      SET cancelada = 'S' 
                      WHERE agenda_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
          
            $sql->bindValue(1, $this->getAgendaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function remarcarAgenda() {
          
            $query = "UPDATE tbagenda SET data = ?,
                      horario = ?
                      WHERE agenda_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
          
            $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getHorario(), PDO::PARAM_STR);
            $sql->bindValue(3, $this->getAgendaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
?>