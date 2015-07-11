<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class MovEstoque extends MovEstoqueModel{
      
        public function __construct() { }
        
        public function incluir() {
          
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setMaterialId($_POST["material_id"]);
            $this->setQuantidade($_POST["quantidade"]);
            $this->setTipo($_POST["tipo"]);
            
            return $this->incluirMovEstoque();
        }
        
        public function listarTodos(){
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "movestoque_id");
            $tipo_busca = (isset($_POST["tipo_busca"]) ? $_POST["tipo_busca"] : 0);
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarMovEstoque($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setMovEstoqueId($codigo);
            
            $dados_mov_estoque = $this->buscarMovEstoque();
                  
            $this->setData($dados_mov_estoque["data"]);
            $this->setMaterialId($dados_mov_estoque["material_id"]);
            $this->setQuantidade($dados_mov_estoque["quantidade"]);
            $this->setTipo($dados_mov_estoque["tipo"]);
        }
        
        public function alterar() {
          
            $this->setMovEstoqueId($_POST["movestoque_id"]);
            $this->setData(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setMaterialId($_POST["material_id"]);
            $this->setQuantidade($_POST["quantidade"]);
            $this->setTipo($_POST["tipo"]);
            
            return $this->alterarMovEstoque();
        }
        
        public function excluir($codigo) {
          
            $this->setMovEstoqueId($codigo);
            
            return $this->excluirMovEstoque();
        }
        
    }
	
?>