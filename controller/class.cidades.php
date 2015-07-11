<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Cidades extends CidadesModel {
        
        public function __construct() {}
      
        public function listar($estado = "") {
          
            $this->setSiglaUf($estado);
            
            return $this->listarTodas();
        }
        
        public function buscarPorCodigo($id_cidade){
          
            $consulta = $this->buscarCidade($id_cidade);
            
            $this->setNome($consulta["nome"]);
            $this->setSiglaUf($consulta["sigla_uf"]);
        }
      
    }
    
?>