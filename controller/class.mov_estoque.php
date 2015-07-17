<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class MovEstoque extends MovEstoqueModel{
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function incluir() {
          
            $this->setData(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setMaterialId(trim(strip_tags(filter_input(INPUT_POST, "material_id"))));
            $this->setQuantidade(trim(strip_tags(filter_input(INPUT_POST, "quantidade"))));
            $this->setTipo(trim(strip_tags(filter_input(INPUT_POST, "tipo"))));
            
            return $this->incluirMovEstoque();
        }
        
        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "movestoque_id");
            $tipo_busca = (isset($_POST["tipo_busca"]) ? $_POST["tipo_busca"] : 0);
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarMovEstoque($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
            $this->setMovEstoqueId($codigo);
            
            $ret_consulta = $this->buscarMovEstoque();
                  
            $this->setData($ret_consulta["DATA"]);
            $this->setMaterialId($ret_consulta["MATERIAL_ID"]);
            $this->setQuantidade($ret_consulta["QUANTIDADE"]);
            $this->setTipo($ret_consulta["TIPO"]);
            
            return ($ret_consulta['MOVESTOQUE_ID'] == $codigo);
        }
        
    }
	
?>