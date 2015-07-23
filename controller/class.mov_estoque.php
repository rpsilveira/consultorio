<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    include_once("../../model/class.materiais.php");
    include_once("class.materiais.php");
	
    class MovEstoque extends MovEstoqueModel{
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function incluir() {
          
            $this->setData(date("Y-m-d H:i:s"));
            $this->setMaterialId(trim(strip_tags(filter_input(INPUT_POST, "material_id"))));
            $this->setQuantidade(str_replace(',', '.', trim(strip_tags(filter_input(INPUT_POST, "quantidade")))));
            $this->setTipo(trim(strip_tags(filter_input(INPUT_POST, "tipo"))));
            $this->setObservacao(trim(strip_tags(filter_input(INPUT_POST, "observacao"))));
            $this->setPessoaId($_SESSION["usr_id"]);
            
            $retorno = $this->incluirMovEstoque();
            
            if ($retorno) {
            
                $material = new Material();
                
                if ($this->getTipo() == 'E')
                    $material->somaEstoque($this->getMaterialId(), $this->getQuantidade());
                else
                    $material->subtraiEstoque($this->getMaterialId(), $this->getQuantidade());
            }
            
            return $retorno;
        }
        
        public function buscar() {
        
            $data_ini = (isset($_POST["data_ini"]) ? $_POST["data_ini"] : (isset($_SESSION["busca1"]) ? $_SESSION["busca1"] : ""));
            $data_fin = (isset($_POST["data_fin"]) ? $_POST["data_fin"] : (isset($_SESSION["busca2"]) ? $_SESSION["busca2"] : ""));
            $material_id = (isset($_POST["material_id"]) ? $_POST["material_id"] : (isset($_SESSION["busca3"]) ? $_SESSION["busca3"] : 0));
            $tipo = (isset($_POST["tipo"]) ? $_POST["tipo"] : (isset($_SESSION["busca4"]) ? $_SESSION["busca4"] : ""));
            
            $data_ini = date("Y-m-d", strtotime(str_replace('/', '-', $data_ini)));
            $data_fin = date("Y-m-d", strtotime(str_replace('/', '-', $data_fin)));
            
            $_SESSION["busca1"] = $data_ini;
            $_SESSION["busca2"] = $data_fin;
            $_SESSION["busca3"] = $material_id;
            $_SESSION["busca4"] = $tipo;
            
            return $this->listarMovEstoque($data_ini, $data_fin, $material_id, $tipo);
        }
        
        public function buscarPorCodigo($codigo) {
        
            $this->setMovEstoqueId($codigo);
            
            $ret_consulta = $this->buscarMovEstoque();
                  
            $this->setData($ret_consulta["DATA"]);
            $this->setMaterialId($ret_consulta["MATERIAL_ID"]);
            $this->setQuantidade($ret_consulta["QUANTIDADE"]);
            $this->setTipo($ret_consulta["TIPO"]);
            $this->setObservacao($ret_consulta["OBSERVACAO"]);
            $this->setPessoaId($ret_consulta["PESSOA_ID"]);
            
            return ($ret_consulta['MOVESTOQUE_ID'] == $codigo);
        }
        
    }
	
?>