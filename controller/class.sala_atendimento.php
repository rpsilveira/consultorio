<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class SalaAtendimento extends SalaAtendimentoModel {
      
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function listarTodos() {
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "sala_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return SalaAtendimentoModel::listarSala($buscar_por, $busca);
        }
        
        public function buscar($codigo) {
        
          $this->setSalaId($codigo);
          
          $dados_sala = $this->buscarSala();
          
          $this->setNome($dados_sala["NOME"]);
          
          return ($ret_consulta['SALA_ID'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setNome($_POST["nome"]);
            
            return $this->incluiSala();
        }
        
        public function alterar() {
          
            $this->setSalaId($_POST["sala_id"]);
            $this->setNome(utf8_decode($_POST["nome"]));
            
            return $this->alterarSala();
        }
        
        public function excluir($codigo) {
          
          $this->setSalaId($codigo);
          
          return $this->excluirSala();
        }
        
    }
    
?>