<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class ContasReceber extends ContasReceberModel {
    
        public function __construct() { }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "conta_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarContas($buscar_por, $busca);
        }
        
        public function listarTodosPaciente($paciente_id) {
        
            return $this->listarContasPaciente($paciente_id);
        }
      
        public function listarContasDia($data_atual) {
        
            return $this->listarContasDia($data_atual);
        }
        
        public function buscar($codigo) {
        
            $this->setContaId($codigo);
            
            $dados_conta = $this->buscarConta();
            
            $this->setPacienteId($dados_conta["paciente_id"]);
            $this->setDtEmissao($dados_conta["dt_emissao"]);
            $this->setDtVencimento($dados_conta["dt_vencimento"]);
            $this->setDtBaixa($dados_conta["dt_baixa"]);
            $this->setValor($dados_conta["valor"]);
            $this->setJuros($dados_conta["juros"]);
            $this->setDesconto($dados_conta["desconto"]);
            $this->setValorPago($dados_conta["valor_pago"]);
        }
        
        public function incluir() {
          
            $this->setPacienteId($_POST["paciente_id"]);
            $this->setDtEmissao(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setDtVencimento(implode("-", array_reverse(explode("/", $_POST["data_2"]))));
            $this->setValor($_POST["valor"]);
            $this->setJuros($_POST["juros"]);
            $this->setDesconto($_POST["desconto"]);
            
            return $this->incluirConta();
        }
        
        public function incluirTitulo($paciente_id, $valor) {
        
            $this->setPacienteId($paciente_id);
            $this->setValor($valor);
            
            return $this->incluirContaPaciente();
        }
        
        public function alterar() {
          
            $this->setContaId($_POST["conta_id"]);
            $this->setPacienteId($_POST["paciente_id"]);
            $this->setDtEmissao(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setDtVencimento(implode("-", array_reverse(explode("/", $_POST["data_2"]))));
            $this->setValor($_POST["valor"]);
            $this->setJuros($_POST["juros"]);
            $this->setDesconto($_POST["desconto"]);
            
            return $this->alterarConta();
        }
        
        public function excluir($codigo) {
          
            $this->setContaId($codigo);

            return $this->excluirConta();
        }
        
        public function baixar($codigo) {

            $this->setContaId($codigo);

            $this->setDtBaixa(implode("-", array_reverse(explode("/", $_POST["dt_baixa"]))));
            $this->setValorPago($_POST["valor_pago"]);

            return $this->baixarConta();
        }
        
    }
    
?>