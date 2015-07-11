<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class SalaAtendimentoModel {
      
        private $sala_id;
        private $nome;
        
        public function __construct() { }
        
        //setters
        public function setSalaId($sala_id) {
          $this->sala_id = $sala_id;
        }
        public function setNome($nome) {
          $this->nome = $nome;
        }
        
        //getters
        public function getSalaId() {
          return $this->sala_id;
        }
        public function getNome() {
          return $this->nome;
        }
        
        public function incluirSala() {
        
            try {
        
                $query = "INSERT INTO tbsalasatendimento(nome) VALUES(?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getNome(), PDO::PARAM_STR);
                
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
                      SET nome = ?
                      WHERE sala_id = ?"; 
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getNome(), PDO::PARAM_STR);
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
        
        public function listarSalas($campo, $valor) {
        
            $query = "SELECT 
                      sala_id,
                      nome
                      FROM tbsalasatendimento
                      WHERE ? LIKE ?
                      ORDER BY nome";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $campo, PDO::PARAM_STR);
            $sql->bindValue(2, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarSala() {
          
            $query = "SELECT 
                      sala_id,
                      nome
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