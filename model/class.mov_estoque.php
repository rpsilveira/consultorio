<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');
	
    class MovEstoqueModel{
      
        private $movestoque_id;
        private $data;
        private $material_id;
        private $quantidade;
        private $tipo;
        private $pessoa_id;
        private $observacao;
        
        public function __contruct(){}
        
        public function setMovEstoqueId($movestoque_id){
          $this->movestoque_id = $movestoque_id;
        }
        public function setData($data){
          $this->data = $data;
        }
        public function setMaterialId($material_id){
          $this->material_id = $material_id;
        }
        public function setQuantidade($quantidade){
          $this->quantidade = $quantidade;
        }
        public function setTipo($tipo){
          $this->tipo = $tipo;
        }
        public function setPessoaId($pessoa_id){
          $this->pessoa_id = $pessoa_id;
        }
        public function setObservacao($observacao){
          $this->observacao = $observacao;
        }
        
        public function getMovEstoqueId(){
          return $this->movestoque_id;
        }
        public function getData(){
          return $this->data;
        }
        public function getMaterialId(){
          return $this->material_id;
        }
        public function getQuantidade(){
          return $this->quantidade;	
        }
        public function getTipo(){
          return $this->tipo;
        }
        public function getPessoaId(){
          return $this->pessoa_id;
        }
        public function getObservacao(){
          return $this->observacao;	
        }
        
        public function incluirMovEstoque() {
          
            try {
        
                $query = "INSERT INTO tbmovestoque(data, material_id, quantidade, tipo, pessoa_id, observacao)
                          VALUES(?, ?, ?, ?, ?, ?)";
                
                $db = Dao::abreConexao();

                $sql = $db->prepare($query);

                $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getMaterialId(), PDO::PARAM_INT);
                $sql->bindValue(3, $this->getQuantidade(), PDO::PARAM_STR);
                $sql->bindValue(4, $this->getTipo(), PDO::PARAM_STR);
                $sql->bindValue(5, $this->getPessoaId(), PDO::PARAM_INT);
                $sql->bindValue(6, $this->getObservacao(), PDO::PARAM_STR);

                $retorno = $sql->execute();

                $this->setMovEstoqueId($db->lastInsertId());
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        
        public function listarMovEstoque($data_ini, $data_fin, $material_id, $tipo) {
        
            $query = "SELECT 
                      TBMOVESTOQUE.MOVESTOQUE_ID,
                      TBMOVESTOQUE.DATA,
                      TBMATERIAIS.DESCRICAO AS MATERIAL,
                      TBMOVESTOQUE.QUANTIDADE,
                      CASE TBMOVESTOQUE.TIPO
                        WHEN 'E' THEN 'Entrada'
                        ELSE 'Saída'
                      END AS TIPO
                      FROM TBMOVESTOQUE
                      LEFT JOIN TBMATERIAIS ON (TBMOVESTOQUE.MATERIAL_ID = TBMATERIAIS.MATERIAL_ID)
                      WHERE CAST(TBMOVESTOQUE.DATA AS DATE) BETWEEN ? AND ?
                      AND ((? = 0) OR (TBMOVESTOQUE.MATERIAL_ID = ?))
                      AND ((? = 'A') OR (TBMOVESTOQUE.TIPO = ?))
                      ORDER BY TBMOVESTOQUE.DATA";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $data_ini, PDO::PARAM_STR);
            $sql->bindValue(2, $data_fin, PDO::PARAM_STR);
            $sql->bindValue(3, $material_id, PDO::PARAM_INT);
            $sql->bindValue(4, $material_id, PDO::PARAM_INT);
            $sql->bindValue(5, $tipo, PDO::PARAM_STR);
            $sql->bindValue(6, $tipo, PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }		
        
        
        public function buscarMovEstoque() {
          
            $query = "SELECT *
                      FROM TBMOVESTOQUE
                      WHERE MOVESTOQUE_ID = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getMovEstoqueId(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
    
?>