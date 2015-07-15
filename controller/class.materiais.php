<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
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
            
            $dados_material = $this->buscarMaterial();
            
            $this->setNome($dados_material["NOME"]);
            $this->setSaldoMin($dados_material["SALDO_MIN"]);
            $this->setSaldoAtual($dados_material["SALDO_ATUAL"]);
            $this->setValor($dados_material["VALOR"]);
            
            return ($ret_consulta['MATERIAL_ID'] == $codigo);
        }
        
        public function incluir(){
          
            $this->setNome($_POST["nome"]);
            $this->setSaldoMin($_POST["saldo_min"]);
            $this->setValor($_POST["valor"]);
            
            return $this->incluiMaterial();
        }
        
        public function alterar() {
          
            $this->setMaterialId($_POST["material_id"]);
            $this->setNome($_POST["nome"]);
            $this->setSaldoMin($_POST["saldo_min"]);
            $this->setValor($_POST["valor"]);
            
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