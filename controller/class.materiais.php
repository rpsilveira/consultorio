<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Material extends MaterialModel {
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "material_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarMaterial($buscar_por, $busca);
        }
        
        public function buscar() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : (isset($_SESSION["busca1"]) ? $_SESSION["busca1"] : ""));
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : (isset($_SESSION["busca2"]) ? $_SESSION["busca2"] : ""));
            
            $_SESSION["busca1"] = $buscar_por;
            $_SESSION["busca2"] = $busca;
          
            return $this->listarMateriais($buscar_por, $busca);
        }
        
        public function buscarPorCodigo($codigo) {
        
            $this->setMaterialId($codigo);
            
            $ret_consulta = $this->buscarMaterial();
            
            $this->setDescricao($ret_consulta["DESCRICAO"]);
            $this->setSaldoMin($ret_consulta["SALDO_MIN"]);
            $this->setSaldoAtual($ret_consulta["SALDO_ATUAL"]);
            $this->setValor($ret_consulta["VALOR"]);
            
            return ($ret_consulta['MATERIAL_ID'] == $codigo);
        }
        
        public function incluir(){
          
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setSaldoMin(trim(strip_tags(filter_input(INPUT_POST, "saldo_min"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            $this->setSaldoMin(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "saldo_minimo")))));
            
            return $this->incluiMaterial();
        }
        
        public function alterar($codigo) {
          
            $this->setMaterialId($codigo);
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            $this->setSaldoMin(trim(strip_tags(filter_input(INPUT_POST, "saldo_min"))));
            $this->setValor(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "valor")))));
            $this->setSaldoMin(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "saldo_minimo")))));
            
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