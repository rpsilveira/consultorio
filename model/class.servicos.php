<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class ServicoModel{
      
        private $servico_id;
        private $descricao;
        private $valor;
        private $tipotratamento_id;
        
        public function __construct(){}
        
        public function setServicoId($servico_id){
          $this->servico_id = $servico_id;
        }
        public function setDescricao($descricao){
          $this->descricao = $descricao;
        }
        public function setValor($valor){
          $this->valor = $valor;
        }
        public function setTipoTratamentoId($tipotratamento_id){
          $this->tipotratamento_id = $tipotratamento_id;
        }
        
        public function getServicoId(){
          return $this->servico_id;
        }
        public function getDescricao(){
          return $this->descricao;
        }
        public function getValor(){
          return $this->valor;
        }
        public function getTipoTratamentoId(){
          return $this->tipotratamento_id;
        }        
        
        public function incluirServico() {
        
            try {
        
                $query = "INSERT INTO tbservicos(descricao, tipotratamento_id, valor)
                          VALUES (?, ?, ?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getTipoTratamentoId(), PDO::PARAM_INT);
                $sql->bindValue(3, $this->getValor(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setServicoId($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarServico() {
          
            $query = "UPDATE tbservicos SET 
                      descricao = ?,
                      tipotratamento_id = ?,
                      valor = ?
                      WHERE servico_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getTipoTratamentoId(), PDO::PARAM_INT);
            $sql->bindValue(3, $this->getValor(), PDO::PARAM_STR);
            $sql->bindValue(4, $this->getServicoId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirServico() {
        
            try {
          
                $query = "DELETE FROM tbservicos 
                          WHERE servico_id = ?";
              
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getServicoId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarServicos() {
          
            $query = "SELECT
                      S.SERVICO_ID,
                      S.DESCRICAO,
                      S.VALOR,
                      T.DESCRICAO AS TIPOTRATAMENTO
                      FROM TBSERVICOS S
                      LEFT JOIN TBTIPOTRATAMENTO T ON (T.TIPOTRATAMENTO_ID = S.TIPOTRATAMENTO_ID)
                      ORDER BY S.DESCRICAO";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarServico() {
        
            $query = "SELECT *
                      FROM tbservicos
                      WHERE servico_id = ?";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getServicoId(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
      
    }

?>