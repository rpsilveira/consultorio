<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Cidades extends CidadesModel {
        
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
      
        public function listar($estado = "") {
          
            $this->setSiglaUf($estado);
            
            return $this->listarTodas();
        }
        
        public function buscarPorCodigo($id_cidade){
          
            $consulta = $this->buscarCidade($id_cidade);
            
            $this->setNome($consulta["NOME"]);
            $this->setSiglaUf($consulta["SIGLA_UF"]);
        }
      
    }
    
?>