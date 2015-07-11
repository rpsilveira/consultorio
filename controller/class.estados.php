<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
	
    class Estados extends EstadosModel {
      
        public function __construct() {}
      
        public function listar() {
      
          return $this->listarEstados();
        }
        
        public function buscarPorCodigo() {
          
            $consulta = $this->buscarEstadosPorCod();
            
            $this->setRazaoSocial($consulta["sigla_uf"]);
            $this->setFantasia($consulta["nome"]);
        }
    
    }

?>