<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Materiais extends MaterialModel {
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "material_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarMaterial($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setMaterialId($codigo);
            
            $ret_consulta = $this->buscarMaterial();
            
            $this->setNome($ret_consulta["NOME"]);
            $this->setSaldoMin($ret_consulta["SALDO_MIN"]);
            $this->setSaldoAtual($ret_consulta["SALDO_ATUAL"]);
            $this->setValor($ret_consulta["VALOR"]);
            
            return ($ret_consulta['MATERIAL_ID'] == $codigo);
        }
        
        public function incluir(){
          
            $this->setNome(trim(strip_tags(filter_input(INPUT_POST, "nome"))));
            $this->setSaldoMin(trim(strip_tags(filter_input(INPUT_POST, "saldo_min"))));
            $this->setValor(trim(strip_tags(filter_input(INPUT_POST, "valor"))));
            
            return $this->incluiMaterial();
        }
        
        public function alterar() {
          
            $this->setMaterialId(trim(strip_tags(filter_input(INPUT_POST, "material_id"))));
            $this->setNome(trim(strip_tags(filter_input(INPUT_POST, "nome"))));
            $this->setSaldoMin(trim(strip_tags(filter_input(INPUT_POST, "saldo_min"))));
            $this->setValor(trim(strip_tags(filter_input(INPUT_POST, "valor"))));
            
            return $this->alterarMaterial();
        }
      
        public function excluir($codigo){
          
            $this->setMaterialId($codigo);

            return $this->excluirMaterial();
        }
      
        public function somaEstoque($codigo, $quantidade){
          
            $this->setMaterialId($codigo);
            
            return $this->addEstoque($quantidade);
        }
      
        public function subtraiEstoque($codigo, $quantidade){
            
            $this->setMaterialId($codigo);
            
            return $this->subEstoque($quantidade);
        }
        
    }
?>