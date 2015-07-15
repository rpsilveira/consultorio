<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class TipoConsulta extends TipoConsultaModel{
  
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "tipoconsulta_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return TipoConsultaModel::listarTipoConsulta($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setTipoConsultaId($codigo);
            
            $dados_tipo_consulta = $this->buscarTipoConsulta();
            
            $this->setTipoConsultaId($dados_tipo_consulta["TIPOCONSULTA_ID"]);	
            $this->setDescricao($dados_tipo_consulta["DESCRICAO"]);	
            $this->setValor($dados_tipo_consulta["VALOR"]);
            
            return ($ret_consulta['TIPOCONSULTA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setDescricao($_POST["descricao"]);
            $this->setValor($_POST["valor"]);
            
            return $this->incluiTipoConsulta();
        }
        
        public function alterar() {
          
            $this->setTipoConsultaId($_POST["tipoconsulta_id"]);
            $this->setDescricao($_POST["descricao"]);
            $this->setValor($_POST["valor"]);
            
            return $this->alterarTipoConsulta();
        }
        
        public function excluir($codigo) {
          
            $this->setTipoConsultaId($codigo);
            
            return $this->excluirTipoConsulta();
        }
        
    }
?>