<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class TipoTratamento extends TipoTratamentoModel{

        public function __construct() { }
        

        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "tipotratamento_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return TipoTratamentoModel::listarTipoTratamento($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setTipoTratamentoId($codigo);
            
            $dados_tipo_tratamento = $this->buscarTipoTratamento();
            
            $this->setDescricao($dados_tipo_tratamento["descricao"]);	
        }
        
        public function incluir(){
          
            $this->setDescricao($_POST["descricao"]);
            
            return $this->incluiTipoTratamento();
        }
        
        public function alterar() {
          
            $this->setTipoTratamentoId($_POST["tipotratamento_id"]);
            $this->setDescricao(utf8_decode($_POST["descricao"]));
            
            return $this->alterarTipoTratamento();
        } 
        
        public function excluir($codigo){
          
            $this->setTipoTratamentoId($codigo);
            
            return $this->excluirTipoTratamento();
        }
        
    }
    
?>