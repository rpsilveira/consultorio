<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class TipoConsulta extends TipoConsultaModel{
  
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            return $this->listarTipoConsulta();
        }
        
        public function buscar($codigo) {
        
            $this->setTipoConsultaId($codigo);
            
            $ret_consulta = $this->buscarTipoConsulta();
            
            $this->setTipoConsultaId($ret_consulta["TIPOCONSULTA_ID"]);	
            $this->setDescricao($ret_consulta["DESCRICAO"]);	
            $this->setValor($ret_consulta["VALOR"]);
            
            return ($ret_consulta['TIPOCONSULTA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            
            return $this->incluirTipoConsulta();
        }
        
        public function alterar() {
          
            $this->setTipoConsultaId(trim(strip_tags(filter_input(INPUT_POST, "tipoconsulta_id"))));
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            
            return $this->alterarTipoConsulta();
        }
        
        public function excluir($codigo) {
          
            $this->setTipoConsultaId($codigo);
            
            return $this->excluirTipoConsulta();
        }
        
    }
?>