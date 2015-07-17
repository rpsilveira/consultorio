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
        
        public function incluiMovEstoque() {
          
            try {
        
                $query = "INSERT INTO tbmovestoque(data, material_id, quantidade, pessoa_id, tipo)
                          VALUES(?, ?, ?, ?, ?)";
                
                $db = Dao::abreConexao();

                $sql = $db->prepare($query);

                $sql->bindValue(1, $this->getData(), PDO::PARAM_STR);
                $sql->bindValue(2, $this->getMaterialId(), PDO::PARAM_INT);
                $sql->bindValue(3, $this->getQuantidade(), PDO::PARAM_STR);
                $sql->bindValue(4, $_SESSION["pessoa_id"], PDO::PARAM_INR);
                $sql->bindValue(5, $this->getTipo(), PDO::PARAM_STR);

                $retorno = $sql->execute();

                $this->setMovEstoqueId($db->lastInsertId());
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        
        public function listarMovEstoque($campo, $valor) {
        
            $query = "SELECT 
                      tbmovestoque.movestoque_id,
                      CAST(tbmovestoque.data as date) AS data,
                      tbmateriais.nome,
                      tbmovestoque.quantidade,
                      tbmovestoque.tipo,
                      tbpessoa.nome as usuario
                      FROM tbmovestoque
                      LEFT JOIN tbmateriais ON (tbmovestoque.material_id = tbmateriais.material_id)
                      LEFT JOIN tbpessoa ON (tbmovestoque.pessoa_id = .tbpessoa.pessoa_id)
                      WHERE tbmovestoque.". $campo ." LIKE ?
                      ORDER BY tbmovestoque.data";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }		
        
        
        public function buscarMovEstoque() {
          
            $query = "SELECT 
                      tbmovestoque.movestoque_id,
                      cast(tbmovestoque.data as date) as data,
                      tbmovestoque.material_id,
                      tbmateriais.nome,
                      tbmovestoque.quantidade,
                      tbmovestoque.tipo
                      FROM tbmovestoque
                      JOIN tbmateriais on (tbmovestoque.material_id = tbmateriais.material_id)
                      WHERE movestoque_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getMovEstoqueId(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }
    
?>