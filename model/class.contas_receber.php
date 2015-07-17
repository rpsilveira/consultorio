<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class ContasReceberModel {
      
        private $conta_id;
        private $paciente_id;
        private $dt_emissao;
        private $dt_vencimento;
        private $dt_baixa;
        private $valor;
        private $juros;
        private $desconto;
        private $valor_pago;
        
        public function __construct() { }
        
        //setters
        public function setContaId($conta_id) {
          $this->conta_id = $conta_id;
        }
        public function setPacienteId($paciente_id) {
          $this->paciente_id = $paciente_id;
        }
        public function setDtEmissao($dt_emissao) {
          $this->dt_emissao = $dt_emissao;
        }
        public function setDtVencimento($dt_vencimento) {
          $this->dt_vencimento = $dt_vencimento;
        }
        public function setDtBaixa($dt_baixa) {
          $this->dt_baixa = $dt_baixa;
        }
        public function setValor($valor) {
          $this->valor = $valor;
        }
        public function setJuros($juros) {
          $this->juros = $juros;
        }
        public function setDesconto($desconto) {
          $this->desconto = $desconto;
        }
        public function setValorPago($valor_pago) {
          $this->valor_pago = $valor_pago;
        }
        
        //getters
        public function getContaId() {
          return $this->conta_id;
        }
        public function getPacienteId() {
          return $this->paciente_id;
        }
        public function getDtEmissao() {
          return $this->dt_emissao;
        }
        public function getDtVencimento() {
          return $this->dt_vencimento;
        }
        public function getDtBaixa() {
          return $this->dt_baixa;
        }
        public function getValor() {
          return $this->valor;
        }
        public function getJuros() {
          return $this->juros;
        }
        public function getDesconto() {
          return $this->desconto;
        }
        public function getValorPago() {
          return $this->valor_pago;
        }
        
        public function incluirConta() {
        
            try {
        
                $query = "INSERT INTO tbcontasreceber(paciente_id, dt_emissao, dt_vencimento, valor, juros, desconto)
                          VALUES(?, ?, ?, ?, ?, ?)";
                
                $db = Dao::abreConexao();
                
                $sql = $db->prepare($query);
                
                $sql->bindValue(1, $this->getPacienteId(), PDO::PARAM_INT);
                $sql->bindValue(2, $this->getDtEmissao(), PDO::PARAM_STR);
                $sql->bindValue(3, $this->getDtVencimento(), PDO::PARAM_STR);
                $sql->bindValue(4, $this->getValor(), PDO::PARAM_STR);
                $sql->bindValue(5, $this->getJuros(), PDO::PARAM_STR);
                $sql->bindValue(6, $this->getDesconto(), PDO::PARAM_STR);
                
                $retorno = $sql->execute();
                
                $this->setContaId($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarConta() {
          
            $query = "UPDATE tbcontasreceber SET 
                     paciente_id = ?,
                     dt_emissao = ?,
                     dt_vencimento = ?,
                     valor = ?,
                     juros = ?,
                     desconto = ?
                     WHERE conta_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getPacienteId(), PDO::PARAM_INT);
            $sql->bindValue(2, $this->getDtEmissao(), PDO::PARAM_STR);
            $sql->bindValue(3, $this->getDtVencimento(), PDO::PARAM_STR);
            $sql->bindValue(4, $this->getValor(), PDO::PARAM_STR);
            $sql->bindValue(5, $this->getJuros(), PDO::PARAM_STR);
            $sql->bindValue(6, $this->getDesconto(), PDO::PARAM_STR);
            $sql->bindValue(7, $this->getContaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirConta() {
        
            try {
          
                $query = "DELETE FROM tbcontasreceber 
                          WHERE conta_id = ?";
                
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getContaId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function baixarConta() {
        
            $query = "UPDATE tbcontasreceber SET 
                      dt_baixa = ?,
                      valor_pago = ?
                      WHERE conta_id = ?";
      
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getDtBaixa(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getValorPago(), PDO::PARAM_STR);
            $sql->bindValue(3, $this->getContaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarContas($campo, $valor) {
        
            $query = "SELECT 
                      tbcontasreceber.conta_id,
                      tbcontasreceber.paciente_id,
                      cast(tbcontasreceber.dt_emissao as date) as dt_emissao,
                      cast(tbcontasreceber.dt_vencimento as date) as dt_vencimento,
                      cast(tbcontasreceber.dt_baixa as date) as dt_baixa,
                      tbcontasreceber.valor,
                      tbcontasreceber.juros,
                      tbcontasreceber.desconto,
                      tbcontasreceber.valor_pago,
                      tbpessoa.nome as paciente
                      FROM tbcontasreceber
                      JOIN tbpessoa on (tbpessoa.pessoa_id = tbcontasreceber.paciente_id)
                  WHERE tbcontasreceber.". $campo ." lIKE ?
                  ORDER BY dt_emissao";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, '%'. $valor .'%', PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarContasPaciente($paciente_id) {
        
            $query = "SELECT 
                            tbcontasreceber.conta_id,
                            tbcontasreceber.paciente_id,
                            cast(tbcontasreceber.dt_emissao as date) as dt_emissao,
                            cast(tbcontasreceber.dt_vencimento as date) as dt_vencimento,
                            cast(tbcontasreceber.dt_baixa as date) as dt_baixa,
                            tbcontasreceber.valor,
                            tbcontasreceber.juros,
                            tbcontasreceber.desconto,
                            tbcontasreceber.valor_pago,
                            tbpessoa.nome as paciente
                            FROM tbcontasreceber
                            JOIN tbpessoa on (tbpessoa.pessoa_id = tbcontasreceber.paciente_id)
                  WHERE tbcontasreceber.paciente_id = ?
                  ORDER BY dt_emissao";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $paciente_id, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function listarContasDia($data_atual) {
        
            $query = "SELECT 
                            tbcontasreceber.conta_id,
                            tbcontasreceber.paciente_id,
                            cast(tbcontasreceber.dt_emissao as date) as dt_emissao,
                            cast(tbcontasreceber.dt_vencimento as date) as dt_vencimento,
                            cast(tbcontasreceber.dt_baixa as date) as dt_baixa,
                            tbcontasreceber.valor,
                            tbcontasreceber.juros,
                            tbcontasreceber.desconto,
                            tbcontasreceber.valor_pago,
                            tbpessoa.nome as paciente
                            FROM tbcontasreceber
                            JOIN tbpessoa on (tbpessoa.pessoa_id = tbcontasreceber.paciente_id)
                  WHERE tbcontasreceber.dt_vencimento = ?
                  ORDER BY dt_emissao";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $data_atual, PDO::PARAM_STR);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscarConta() {
          
            $query = "SELECT 
                            tbcontasreceber.conta_id,
                            tbcontasreceber.paciente_id,
                            cast(tbcontasreceber.dt_emissao as date) as dt_emissao,
                            cast(tbcontasreceber.dt_vencimento as date) as dt_vencimento,
                            cast(tbcontasreceber.dt_baixa as date) as dt_baixa,
                            tbcontasreceber.valor,
                            tbcontasreceber.juros,
                            tbcontasreceber.desconto,
                            tbcontasreceber.valor_pago,
                            tbpessoa.nome as paciente
                            FROM tbcontasreceber
                            JOIN tbpessoa on (tbpessoa.pessoa_id = tbcontasreceber.paciente_id)
                  WHERE conta_id = ?";
                  
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getContaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }

    }
?>