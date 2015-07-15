<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');
	
    class TipoTratamentoModel{
    
        private $tipotratamento_id;
        private $descricao;
        
        public function __construct() { }
        
        //setters
        public function setTipoTratamentoId($tipotratamento_id) {
          $this->tipotratamento_id = $tipotratamento_id;
        }
        public function setDescricao($descricao) {
          $this->descricao = $descricao;
        }
        
        //getters
        public function getTipoTratamentoId() {
          return $this->tipotratamento_id;
        }
        public function getDescricao() {
          return $this->descricao;
        }
        
        public function incluirTipoTratamento() {
        
            try {
        
                $query = "INSERT INTO tbtipotratamento (descricao)
                     VALUES ( '".$this->getDescricao()."' )";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setTipoTratamentoId($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarTipoTratamento() {
          
            $query = "UPDATE tbtipotratamento 
                      SET descricao = ?
                      WHERE tipotratamento_id = ?"; 
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getTipoTratamentoId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirTipoTratamento() {
        
            try {
          
                $query = "DELETE FROM tbtipotratamento 
                          WHERE tipotratamento_id = ?";
            
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getTipoTratamentoId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarTipoTratamento() {
        
            $query = "SELECT *
                      FROM tbtipotratamento
                      ORDER BY descricao";
                 
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarTipoTratamento() {
          
            $query = "SELECT *
                      FROM tbtipotratamento
                      WHERE tipotratamento_id = ?
                      ORDER BY descricao";
            
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getTipoTratamentoId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
      
    }
    
?>