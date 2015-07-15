<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Servicos extends ServicosModel{
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function inserir() {

            $this->setNome($_POST["nome"]);
            $this->setTipoTratamentoId($_POST["tipotratamento_id"]);
            $this->setValor($_POST["valor"]);
            
            return $this->inserirServicos();
        }
        
        public function listarTodos() {
          
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "servico_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return ServicosModel::buscaServicos($buscar_por, $busca);
        }
        
        public function buscarPorCodigo($codigo) {
        
            $this->setServicoId($codigo);
          
            $consulta = $this->buscaServicosCodigo();
            
            $this->setServicoId($consulta["SERVICO_ID"]);
            $this->setNome($consulta["NOME"]);
            $this->setTipoTratamentoId($consulta["TIPOTRATAMENTO_ID"]);	
            $this->setValor($consulta["VALOR"]);
            
            return ($ret_consulta['SERVICO_ID'] == $codigo);
        }
        
        public function excluir($servico_id){
          
            $this->setServicoId($servico_id);
            
            return $this->excluirServico();
        }
        
        public function alterar() {
          
            $this->setServicoId($_POST["servico_id"]);
            $this->setNome($_POST["nome"]);
            $this->setTipoTratamentoId($_POST["tipotratamento_id"]);
            $this->setValor($_POST["valor"]);
            
            return $this->alterarServico();
        }
        
    }
    
?>