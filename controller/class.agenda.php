<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Agenda extends AgendaModel {
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
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
            
            $this->setData($dados_agenda["DATA"]);
            $this->setDentistaId($dados_agenda["DENTISTA_ID"]);
            $this->setPacienteId($dados_agenda["PACIENTE_ID"]);
            $this->setSalaId($dados_agenda["SALA_ID"]);
            $this->setTipoConsultaId($dados_agenda["TIPOCONSULTA_ID"]);
            $this->setHorario($dados_agenda["HORARIO"]);
            $this->setObservacao($dados_agenda["OBSERVACAO"]);
            
            return ($ret_consulta['AGENDA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setData(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setDentistaId(trim(strip_tags(filter_input(INPUT_POST, "dentista_id"))));
            $this->setPacienteId(trim(strip_tags(filter_input(INPUT_POST, "paciente_id"))));
            $this->setSalaId(trim(strip_tags(filter_input(INPUT_POST, "sala_id"))));
            $this->setTipoConsultaId(trim(strip_tags(filter_input(INPUT_POST, "tipoconsulta_id"))));
            $this->setHorario(trim(strip_tags(filter_input(INPUT_POST, "horario"))));
            $this->setObservacao(trim(strip_tags(filter_input(INPUT_POST, "observacao"))));
            
            return $this->incluiAgenda();
        }
        
        public function alterar($codigo) {
          
            $this->setAgendaId($codigo);
            $this->setData(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setDentistaId(trim(strip_tags(filter_input(INPUT_POST, "dentista_id"))));
            $this->setPacienteId(trim(strip_tags(filter_input(INPUT_POST, "paciente_id"))));
            $this->setSalaId(trim(strip_tags(filter_input(INPUT_POST, "sala_id"))));
            $this->setTipoConsultaId(trim(strip_tags(filter_input(INPUT_POST, "tipoconsulta_id"))));
            $this->setHorario(trim(strip_tags(filter_input(INPUT_POST, "horario"))));
            $this->setObservacao(trim(strip_tags(filter_input(INPUT_POST, "observacao"))));
            
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
            $this->setData(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setHorario(trim(strip_tags(filter_input(INPUT_POST, "novo_horario"))));

            return $this->remarcarAgenda();
        }
        
    }
    
?>