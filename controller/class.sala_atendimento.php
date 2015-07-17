<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class SalaAtendimento extends SalaAtendimentoModel {
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            return $this->listarSalas();
        }
        
        public function buscar($codigo) {
        
          $this->setSalaId($codigo);
          
          $ret_consulta = $this->buscarSala();
          
          $this->setDescricao($ret_consulta["DESCRICAO"]);
          
          return ($ret_consulta['SALA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            
            return $this->incluirSala();
        }
        
        public function alterar($codigo) {
          
            $this->setSalaId($codigo);
            $this->setDescricao(trim(strip_tags(filter_input(INPUT_POST, "descricao"))));
            
            return $this->alterarSala();
        }
        
        public function excluir($codigo) {
          
          $this->setSalaId($codigo);
          
          return $this->excluirSala();
        }
        
    }
    
?>