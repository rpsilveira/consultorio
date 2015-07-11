<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class ServicosModel{
      
        private $servico_id;
        private $nome;
        private $valor;
        private $tipotratamento_id;
        
        public function __construct(){}
        
        public function setServicoId($servico_id){
          $this->servico_id = $servico_id;
        }
        public function setNome($nome){
          $this->nome = $nome;
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
        public function getNome(){
          return $this->nome;
        }
        public function getValor(){
          return $this->valor;
        }
        public function getTipoTratamentoId(){
          return $this->tipotratamento_id;
        }        
        
        public function incluirServico() {
        
            try {
        
                $query = "INSERT INTO tbservicos(nome, tipotratamento_id, valor)
                          VALUES (?, ?, ?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getNome(), PDO::PARAM_STR);
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
                      nome = ?,
                      tipotratamento_id = ?,
                      valor = ?
                      WHERE servico_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getNome(), PDO::PARAM_STR);
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
        
        public function listarServicos($campo, $valor) {
          
            $query = "SELECT 
                      tbservicos.servico_id,
                      tbservicos.nome,
                      tbservicos.tipotratamento_id,
                      tbservicos.valor,
                      tbtipotratamento.descricao AS tipotratamento
                      FROM tbservicos
                      LEFT JOIN tbtipotratamento ON (tbtipotratamento.tipotratamento_id = tbservicos.tipotratamento_id)
                      WHERE ? LIKE ?
                      ORDER BY nome";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $campo, PDO::PARAM_STR);
            $sql->bindValue(2, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno
        }
        
        public function buscaServico() {
        
            $query = "SELECT servico_id, nome, tipotratamento_id, valor
                      FROM tbservicos
                      WHERE servico_id = ?";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getServicoId(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno
        }
      
    }

?>