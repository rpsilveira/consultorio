<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class TipoTratamento extends TipoTratamentoModel{

        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            return $this->listarTipoTratamento();
        }
        
        public function buscar($codigo) {
        
            $this->setTipoTratamentoId($codigo);
            
            $ret_consulta = $this->buscarTipoTratamento();
            
            $this->setDescricao($ret_consulta["DESCRICAO"]);	
            
            return ($ret_consulta['TIPOTRATAMENTO_ID'] == $codigo);
        }
        
        public function incluir(){
          
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            
            return $this->incluirTipoTratamento();
        }
        
        public function alterar($codigo) {
          
            $this->setTipoTratamentoId($codigo);
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            
            return $this->alterarTipoTratamento();
        } 
        
        public function excluir($codigo){
          
            $this->setTipoTratamentoId($codigo);
            
            return $this->excluirTipoTratamento();
        }
        
    }
    
?>