<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Servico extends ServicoModel{
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function incluir() {

            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setTipoTratamentoId(trim(strip_tags(filter_input(INPUT_POST, "tipotratamento_id"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            
            return $this->incluirServico();
        }
        
        public function listarTodos() {
          
            return $this->listarServicos();
        }
        
        public function buscar($codigo) {
        
            $this->setServicoId($codigo);
          
            $ret_consulta = $this->buscarServico();
            
            $this->setServicoId($ret_consulta["SERVICO_ID"]);
            $this->setDescricao($ret_consulta["DESCRICAO"]);
            $this->setTipoTratamentoId($ret_consulta["TIPOTRATAMENTO_ID"]);	
            $this->setValor($ret_consulta["VALOR"]);
            
            return ($ret_consulta['SERVICO_ID'] == $codigo);
        }
        
        public function excluir($servico_id){
          
            $this->setServicoId($servico_id);
            
            return $this->excluirServico();
        }
        
        public function alterar() {
          
            $this->setServicoId(trim(strip_tags(filter_input(INPUT_POST, "servico_id"))));
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setTipoTratamentoId(trim(strip_tags(filter_input(INPUT_POST, "tipotratamento_id"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            
            return $this->alterarServico();
        }
        
    }
    
?>