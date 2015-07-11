<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');
	
    class EstadosModel{
    
        private $sigla;
        private $nome;
        
        public function __construct(){}
        
        public function setSigla($sigla){
          $this->sigla = $sigla;
        }
        public function setNome($nome){
          $this->nome = $nome;	
        }
        
        public function getSigla(){
          return $this->sigla;
        }
        public function getNome(){
          return $this->nome;
        }
        
        public function listarEstados() {
          
            $query = "SELECT sigla_uf, nome FROM tbestados 
                      ORDER BY nome";
            
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
    
?>