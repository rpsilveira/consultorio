<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Consulta extends ConsultaModel {
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "consulta_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarConsulta($buscar_por, $busca);
        }
        
        public function listarTodosPaciente($paciente_id){
        
            return $this->listarConsultaPaciente($paciente_id);
        }
        
        public function buscar($codigo) {
        
            $this->setConsultaId($codigo);
            
            $dados_consulta = $this->buscarConsulta();
            
            $this->setData($dados_consulta["DATA"]);
            $this->setDentistaId($dados_consulta["DENTISTA_ID"]);
            $this->setPacienteId($dados_consulta["PACIENTE_ID"]);
            $this->setSalaId($dados_consulta["SALA_ID"]);
            $this->setTipoConsultaId($dados_consulta["TIPOCONSULTA_ID"]);
            $this->setHorario($dados_consulta["HORARIO"]);
            $this->setObservacao($dados_consulta["OBSERVACAO"]);
            
            return ($ret_consulta['CONSULTA_ID'] == $codigo);
        }
        
        public function buscarMateriais($codigo) {
          
            $this->setConsultaId($codigo);

            return $this->buscarMatConsulta();
        }
        
        public function buscarServicos($codigo) {
          
            $this->setConsultaId($codigo);

            return $this->buscarServConsulta();
        }
        
        public function incluir() {
          
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setDentistaId($_POST["dentista_id"]);
            $this->setPacienteId($_POST["paciente_id"]);
            $this->setSalaId($_POST["sala_id"]);
            $this->setHorario($_POST["horario"]);
            $this->setTipoConsultaId($_POST["tipoconsulta_id"]);
            $this->setObservacao($_POST["observacao"]);
            
            $mat_codigo = isset($_POST["mat_codigo"]) ? $_POST["mat_codigo"] : array();
            $mat_quant = isset($_POST["mat_quant"]) ? $_POST["mat_quant"] : array();
            
            $srv_codigo = isset($_POST["srv_codigo"]) ? $_POST["srv_codigo"] : array();
            $srv_quant = isset($_POST["srv_quant"]) ? $_POST["srv_quant"] : array();
            
            return $this->incluirConsulta($mat_codigo, $mat_quant, $srv_codigo, $srv_quant);
        }

    }
?>