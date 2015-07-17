<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
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
            
            $ret_consulta = $this->buscarConta();
            
            $this->setPacienteId($ret_consulta["PACIENTE_ID"]);
            $this->setDtEmissao($ret_consulta["DT_EMISSAO"]);
            $this->setDtVencimento($ret_consulta["DT_VENCIMENTO"]);
            $this->setDtBaixa($ret_consulta["DT_BAIXA"]);
            $this->setValor($ret_consulta["VALOR"]);
            $this->setJuros($ret_consulta["JUROS"]);
            $this->setDesconto($ret_consulta["DESCONTO"]);
            $this->setValorPago($ret_consulta["VALOR_PAGO"]);
            
            return ($ret_consulta['CONTA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setPacienteId(trim(strip_tags(filter_input(INPUT_POST, "paciente_id"))));
            $this->setDtEmissao(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setDtVencimento(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_2")))));
            $this->setValor(trim(strip_tags(filter_input(INPUT_POST, "valor"))));
            $this->setJuros(trim(strip_tags(filter_input(INPUT_POST, "juros"))));
            $this->setDesconto(trim(strip_tags(filter_input(INPUT_POST, "desconto"))));
            
            return $this->incluirConta();
        }
        
        public function incluirTitulo($paciente_id, $valor) {
        
            $this->setPacienteId($paciente_id);
            $this->setValor($valor);
            
            return $this->incluirContaPaciente();
        }
        
        public function alterar($codigo) {
          
            $this->setContaId($codigo);
            $this->setPacienteId(trim(strip_tags(filter_input(INPUT_POST, "paciente_id"))));
            $this->setDtEmissao(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setDtVencimento(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_2")))));
            $this->setValor(trim(strip_tags(filter_input(INPUT_POST, "valor"))));
            $this->setJuros(trim(strip_tags(filter_input(INPUT_POST, "juros"))));
            $this->setDesconto(trim(strip_tags(filter_input(INPUT_POST, "desconto"))));
            
            return $this->alterarConta();
        }
        
        public function excluir($codigo) {
          
            $this->setContaId($codigo);

            return $this->excluirConta();
        }
        
        public function baixar($codigo) {

            $this->setContaId($codigo);

            $this->setDtBaixa(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "dt_baixa")))));
            $this->setValorPago(trim(strip_tags(filter_input(INPUT_POST, "valor_pago"))));

            return $this->baixarConta();
        }
        
    }
    
?>