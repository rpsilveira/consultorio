<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class SalaAtendimentoModel {
      
        private $sala_id;
        private $descricao;
        
        public function __construct() { }
        
        //setters
        public function setSalaId($sala_id) {
          $this->sala_id = $sala_id;
        }
        public function setDescricao($descricao) {
          $this->descricao = $descricao;
        }
        
        //getters
        public function getSalaId() {
          return $this->sala_id;
        }
        public function getDescricao() {
          return $this->descricao;
        }
        
        public function incluirSala() {
        
            try {
        
                $query = "INSERT INTO tbsalasatendimento(descricao) VALUES(?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setSalaId($db->lastInsertId());
                
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarSala() {
          
            $query = "UPDATE tbsalasatendimento 
                      SET descricao = ?
                      WHERE sala_id = ?"; 
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getSalaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirSala() {
        
            try {
          
                $query = "DELETE FROM tbsalasatendimento 
                          WHERE sala_id = ?";
                          
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getSalaId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarSalas() {
        
            $query = "SELECT *
                      FROM tbsalasatendimento
                      ORDER BY descricao";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarSala() {
          
            $query = "SELECT *
                      FROM tbsalasatendimento
                      WHERE sala_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getSalaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }	
        
    }
?>