<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class ContasReceber extends ContasReceberModel {
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
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
            
            $this->setPacienteId($dados_conta["PACIENTE_ID"]);
            $this->setDtEmissao($dados_conta["DT_EMISSAO"]);
            $this->setDtVencimento($dados_conta["DT_VENCIMENTO"]);
            $this->setDtBaixa($dados_conta["DT_BAIXA"]);
            $this->setValor($dados_conta["VALOR"]);
            $this->setJuros($dados_conta["JUROS"]);
            $this->setDesconto($dados_conta["DESCONTO"]);
            $this->setValorPago($dados_conta["VALOR_PAGO"]);
            
            return ($ret_consulta['CONTA_ID'] == $codigo);
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