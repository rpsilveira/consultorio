<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Estados extends EstadosModel {
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
      
        public function listar() {
      
          return $this->listarEstados();
        }
        
        public function buscarPorCodigo() {
          
            $consulta = $this->buscarEstadosPorCod();
            
            $this->setRazaoSocial($consulta["SIGLA_UF"]);
            $this->setFantasia($consulta["NOME"]);
        }
    
    }

?>