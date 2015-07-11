<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Materiais extends MaterialModel {
    
        public function __construct() { }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "material_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarMaterial($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setMaterialId($codigo);
            
            $dados_material = $this->buscarMaterial();
            
            $this->setNome($dados_material["nome"]);
            $this->setSaldoMin($dados_material["saldo_min"]);
            $this->setSaldoAtual($dados_material["saldo_atual"]);
            $this->setValor($dados_material["valor"]);
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