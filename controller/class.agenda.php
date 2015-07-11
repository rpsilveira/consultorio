<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Agenda extends AgendaModel {
      
        public function __construct() { }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "agenda_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            $retorno = $this->listarAgenda($buscar_por, $busca);
            
            return $retorno;
        }
        
        public function listarTodosPaciente($paciente_id) {
        
            return $this->listarAgendaPaciente($paciente_id);
        }
        
        public function listarAgendaDia($data_atual) {
        
            return $this->listarDia($data_atual);
        }
        
        public function buscar($codigo) {
        
            $this->setAgendaId($codigo);
            
            $dados_agenda = $this->buscarAgenda();
            
            $this->setData($dados_agenda["data"]);
            $this->setDentistaId($dados_agenda["dentista_id"]);
            $this->setPacienteId($dados_agenda["paciente_id"]);
            $this->setSalaId($dados_agenda["sala_id"]);
            $this->setTipoConsultaId($dados_agenda["tipoconsulta_id"]);
            $this->setHorario($dados_agenda["horario"]);
            $this->setObservacao($dados_agenda["observacao"]);
        }
        
        public function incluir() {
          
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setDentistaId($_POST["dentista_id"]);
            $this->setPacienteId($_POST["paciente_id"]);
            $this->setSalaId($_POST["sala_id"]);
            $this->setTipoConsultaId($_POST["tipoconsulta_id"]);
            $this->setHorario($_POST["horario"]);
            $this->setObservacao($_POST["observacao"]);
            
            return $this->incluiAgenda();
        }
        
        public function alterar() {
          
            $this->setAgendaId($_POST["agenda_id"]);
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setDentistaId($_POST["dentista_id"]);
            $this->setPacienteId($_POST["paciente_id"]);
            $this->setSalaId($_POST["sala_id"]);
            $this->setTipoConsultaId($_POST["tipoconsulta_id"]);
            $this->setHorario($_POST["horario"]);
            $this->setObservacao($_POST["observacao"]);
            
            return $this->alterarAgenda();
        }
        
        public function excluir($codigo) {
          
            $this->setAgendaId($codigo);

            return $this->excluirAgenda();
        }
        
        public function cancelar($codigo) {
            
            $this->setAgendaId($codigo);

            return $this->cancelarAgenda();
        }
        
        public function remarcar($codigo) {
          
            $this->setAgendaId($codigo);
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setHorario($_POST["novo_horario"]);

            return $this->remarcarAgenda();
        }
        
    }
    
?>