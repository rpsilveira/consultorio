<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class TipoConsultaModel{
      
        private $tipoconsulta_id;
        private $descricao;
        private $valor;
        
        public function __construct() { }
        
        //setters
        public function setTipoConsultaId($tipoconsulta_id) {
          $this->tipoconsulta_id = $tipoconsulta_id;
        }
        public function setDescricao($descricao) {
          $this->descricao = $descricao;
        }
        public function setValor($valor) {
          $this->valor = $valor;
        }
        
        //getters
        public function getTipoConsultaId() {
          return $this->tipoconsulta_id;
        }
        public function getDescricao() {
          return $this->descricao;
        }
        public function getValor() {
          return $this->valor;
        }
        
        public function incluirTipoConsulta() {
        
            try {
        
                $query = "INSERT INTO tbtipoconsulta(descricao, valor)
                          VALUES(?, ?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getValor(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setTipoConsultaId($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarTipoConsulta() {
          
            $query = "UPDATE tbtipoconsulta SET 
                      descricao = ?,
                      valor = ?
                      WHERE tipoconsulta_id = ?"; 
                      
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getValor(), PDO::PARAM_STR);
            $sql->bindValue(3, $this->getTipoConsultaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirTipoConsulta() {
        
            try {
          
                $query = "DELETE FROM tbtipoconsulta 
                          WHERE tipoconsulta_id = ?";
              
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getTipoConsultaId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarTipoConsulta() {
        
            $query = "SELECT *
                      FROM tbtipoconsulta
                      ORDER BY descricao";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarTipoConsulta() {
          
            $query = "SELECT *
                      FROM tbtipoconsulta
                      WHERE tipoconsulta_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getTipoConsultaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }

?>
