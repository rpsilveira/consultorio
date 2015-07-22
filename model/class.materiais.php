<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class MaterialModel {
      
        private $material_id;
        private $descricao;
        private $saldo_atual;
        private $saldo_min;
        private $valor;
        
        public function __construct() { }
        
        //setters
        public function setMaterialId($material_id) {
          $this->material_id = $material_id;
        }
        public function setDescricao($descricao) {
          $this->descricao = $descricao;
        }
        public function setSaldoAtual($saldo_atual) {
          $this->saldo_atual = $saldo_atual;
        }
        public function setSaldoMin($saldo_min) {
          $this->saldo_min = $saldo_min;
        }
        public function setValor($valor) {
          $this->valor = $valor;
        }
        
        //getters
        public function getMaterialId() {
          return $this->material_id;
        }
        public function getDescricao() {
          return $this->descricao;
        }
        public function getSaldoAtual() {
          return $this->saldo_atual;
        }
        public function getSaldoMin() {
          return $this->saldo_min;
        }
        public function getValor() {
          return $this->valor;
        }
        
        public function incluiMaterial() {
        
            try {
        
                $query = "INSERT INTO tbmateriais (descricao, saldo_atual, saldo_min, valor)
                          VALUES (?, ?, ?, ?)";
                
                $db = Dao::abreConexao();

                $sql = $db->prepare($query);

                $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getSaldoAtual(), PDO::PARAM_STR);
                $sql->bindValue(3, $this->getSaldoMin(), PDO::PARAM_STR);
                $sql->bindValue(4, $this->getValor(), PDO::PARAM_STR);

                $retorno = $sql->execute();

                $this->setMaterialId($db->lastInsertId());
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarMaterial() {
          
            $query = "UPDATE tbmateriais SET 
                      descricao = ?,
                      saldo_min = ?,
                      valor = ?
                      WHERE material_id = ?"; 
                      
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDescricao(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getSaldoMin(), PDO::PARAM_STR);
            $sql->bindValue(3, $this->getValor(), PDO::PARAM_STR);
            $sql->bindValue(4, $this->getMaterialId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirMaterial() {
            
            try {
          
                $query = "DELETE FROM tbmateriais 
                          WHERE material_id = ?";
          
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getMaterialId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarMateriais($campo, $valor) {
        
            $query = "SELECT *
                      FROM tbmateriais
                      WHERE ". $campo ." LIKE ?
                      ORDER BY descricao";
                 
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarMaterial() {
          
            $query = "SELECT *
                      FROM tbmateriais
                      WHERE material_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getMaterialId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function addEstoque($quantidade) {

            $query = "UPDATE tbmateriais 
                      SET saldo_atual = saldo_atual + ?
                      WHERE material_id = ?";

            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $quantidade, PDO::PARAM_STR);
            $sql->bindValue(1, $this->getMaterialId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }

        public function subEstoque($quantidade){

            $query = "UPDATE tbmateriais 
                      SET saldo_atual = saldo_atual - ?
                      WHERE material_id = ?";

            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $quantidade, PDO::PARAM_STR);
            $sql->bindValue(1, $this->getMaterialId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
?>