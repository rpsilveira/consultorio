<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Consulta extends ConsultaModel {
      
        public function __construct() { }

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
            
            $this->setData($dados_consulta["data"]);
            $this->setDentistaId($dados_consulta["dentista_id"]);
            $this->setPacienteId($dados_consulta["paciente_id"]);
            $this->setSalaId($dados_consulta["sala_id"]);
            $this->setTipoConsultaId($dados_consulta["tipoconsulta_id"]);
            $this->setHorario($dados_consulta["horario"]);
            $this->setObservacao($dados_consulta["observacao"]);
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