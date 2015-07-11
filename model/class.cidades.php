<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');
	
    class CidadesModel {
      
        private $cidade_id;
        private $nome;
        private $sigla_uf;
        
        public function __construct() {}
        
        public function setCidadeId($cidade_id){
          $this->cidade_id = $cidade_id;
        }
        public function setNome($nome){
          $this->nome = $nome;
        }
        public function setSiglaUf($sigla_uf){
          $this->sigla_uf = $sigla_uf;
        }
        
        public function getCidadeId(){
          return $this->cidade_id;
        }
        public function getNome(){
          return $this->nome;
        }
        public function getSiglaUf(){
          return $this->sigla_uf;
        }
        
      
        public function buscarCidade($id_cidade) {
        
            $query = "SELECT cidade_id, nome, sigla_uf FROM tbcidades 
                      WHERE cidade_id = ?";
            
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $id_cidade, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
      
        public function listarCidades() {
          
          $query = "SELECT cidade_id, nome, sigla_uf FROM tbcidades 
                    WHERE sigla_uf = ?' 
                    ORDER BY nome";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getSiglaUf, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
      
    }

?>