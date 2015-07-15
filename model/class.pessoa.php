<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once('class.dao.php');

    class PessoaModel {
      
        private $pessoa_id;
        private $nome;
        private $endereco;
        private $bairro;
        private $cep;
        private $cidade_id;
        private $cpf;
        private $telefone;
        private $celular;
        private $email;
        private $nivel;
        private $login;
        private $senha;
        private $ultimo_acesso;
        private $data_nascimento;
        private $sexo;
        private $ativo;
        
        public function __construct() { }
        
        //setters
        public function setPessoaId($pessoa_id) {
          $this->pessoa_id = $pessoa_id;
        }
        public function setNome($nome) {
          $this->nome = $nome;
        }
        public function setEndereco($endereco) {
          $this->endereco = $endereco;
        }
        public function setBairro($bairro) {
          $this->bairro = $bairro;
        }
        public function setCep($cep) {
          $this->cep = $cep;
        }
        public function setCidadeId($cidade_id) {
          $this->cidade_id = $cidade_id;
        }
        public function setCpf($cpf) {
          $this->cpf = $cpf;
        }
        public function setTelefone($telefone) {
          $this->telefone = $telefone;
        }
        public function setCelular($celular) {
          $this->celular = $celular;
        }
        public function setEmail($email) {
          $this->email = $email;
        }
        public function setNivel($nivel) {
          $this->nivel = $nivel;
        }
        public function setUltimoAcesso($ultimo_acesso) {
          $this->ultimo_acesso = $ultimo_acesso;
        }
        public function setDataNascimento($data_nascimento) {
          $this->data_nascimento = $data_nascimento;
        }
        public function setSexo($sexo) {
          $this->sexo = $sexo;
        }
        public function setAtivo($ativo) {
          $this->ativo = $ativo;
        }
        public function setLogin($login) {
          $this->login = $login;
        }
        public function setSenha($senha) {
          $this->senha = $senha;
        }
        
        //getters
        public function getPessoaId() {
          return $this->pessoa_id;
        }
        public function getNome() {
          return $this->nome;
        }
        public function getEndereco() {
          return $this->endereco;
        }
        public function getBairro() {
          return $this->bairro;
        }
        public function getCep() {
          return $this->cep;
        }
        public function getCidadeId() {
          return $this->cidade_id;
        }
        public function getCpf() {
          return $this->cpf;
        }
        public function getTelefone() {
          return $this->telefone;
        }
        public function getCelular() {
          return $this->celular;
        }
        public function getEmail() {
          return $this->email;
        }
        public function getNivel() {
          return $this->nivel;
        }
        public function getUltimoAcesso() {
          return $this->ultimo_acesso;
        }
        public function getDataNascimento() {
          return $this->data_nascimento;
        }
        public function getSexo() {
          return $this->sexo;
        }
        public function getAtivo() {
          return $this->ativo;
        }
        public function getLogin() {
          return $this->login;
        }
        public function getSenha() {
          return $this->senha;
        }
        
        public function incluiPessoa() {
        
            try {
        
                $query = "INSERT INTO tbpessoa(nome, endereco, bairro, cep, cpf, dt_nascimento, sexo, cidade_id, nivel, telefone, celular, email, login, ativo)
                          VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              
                $db = Dao::abreConexao();

                $sql = $db->prepare($query);

                $sql->bindValue(1,  $this->getNome(), PDO::PARAM_STR);
                $sql->bindValue(2,  $this->getEndereco(), PDO::PARAM_STR);
                $sql->bindValue(3,  $this->getBairro(), PDO::PARAM_STR);
                $sql->bindValue(4,  $this->getCep(), PDO::PARAM_STR);
                $sql->bindValue(5,  $this->getCpf(), PDO::PARAM_STR);
                $sql->bindValue(6,  $this->getDataNascimento(), PDO::PARAM_STR);
                $sql->bindValue(7,  $this->getSexo(), PDO::PARAM_STR);
                $sql->bindValue(8,  $this->getCidadeId(), PDO::PARAM_INT);
                $sql->bindValue(9,  $this->getNivel(), PDO::PARAM_INT);
                $sql->bindValue(10, $this->getTelefone(), PDO::PARAM_STR);
                $sql->bindValue(11, $this->getCelular(), PDO::PARAM_STR);
                $sql->bindValue(12, $this->getEmail(), PDO::PARAM_STR);
                $sql->bindValue(13, $this->getLogin(), PDO::PARAM_STR);
                $sql->bindValue(14, $this->getAtivo(), PDO::PARAM_STR);

                $retorno = $sql->execute();

                $this->setPessoaId($db->lastInsertId());
          
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }        
        
        public function alterarPessoa() {
          
            $query = "UPDATE tbpessoa SET 
                      nome = ?,
                      endereco = ?,
                      bairro = ?,
                      cep = ?,
                      cpf = ?,
                      dt_nascimento = ?,
                      sexo = ?,
                      cidade_id = ?,
                      nivel = ?,
                      telefone = ?,
                      celular = ?,
                      email = ?,
                      login = ?,
                      ativo = ?
                      WHERE pessoa_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1,  $this->getNome(), PDO::PARAM_STR);
            $sql->bindValue(2,  $this->getEndereco(), PDO::PARAM_STR);
            $sql->bindValue(3,  $this->getBairro(), PDO::PARAM_STR);
            $sql->bindValue(4,  $this->getCep(), PDO::PARAM_STR);
            $sql->bindValue(5,  $this->getCpf(), PDO::PARAM_STR);
            $sql->bindValue(6,  $this->getDataNascimento(), PDO::PARAM_STR);
            $sql->bindValue(7,  $this->getSexo(), PDO::PARAM_STR);
            $sql->bindValue(8,  $this->getCidadeId(), PDO::PARAM_INT);
            $sql->bindValue(9,  $this->getNivel(), PDO::PARAM_INT);
            $sql->bindValue(10, $this->getTelefone(), PDO::PARAM_STR);
            $sql->bindValue(11, $this->getCelular(), PDO::PARAM_STR);
            $sql->bindValue(12, $this->getEmail(), PDO::PARAM_STR);
            $sql->bindValue(13, $this->getLogin(), PDO::PARAM_STR);
            $sql->bindValue(14, $this->getAtivo(), PDO::PARAM_STR);
            $sql->bindValue(15, $this->getPessoaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function alterarSenha() {
          
            $query = "UPDATE tbpessoa SET 
                      senha = '".$this->getSenha()."'
                      WHERE pessoa_id = '".$this->getPessoaId()."'";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getSenha(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getPessoaId(), PDO::PARAM_INT);
            
            $retorno = $sql->execute();
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function excluirPessoa() {
        
            try {
          
                $query = "DELETE FROM tbpessoa 
                          WHERE pessoa_id = ?";
          
                $sql = Dao::abreConexao()->prepare($query);
                
                $sql->bindValue(1, $this->getPessoaId(), PDO::PARAM_INT);
                
                $retorno = $sql->execute();
            
            } catch(PDOException $e) {
            
                //echo $e->getMessage();
            
                $retorno = false;
            }
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function validaLogin() {
          
            $query = "SELECT pessoa_id 
                      FROM tbpessoa 
                      WHERE login = ?
                      AND senha = ?
                      AND ativo = 'S'";
                
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getLogin(), PDO::PARAM_STR);
            $sql->bindValue(2, $this->getSenha(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $dados_login = $sql->fetch(PDO::FETCH_ASSOC);
            
            if ($dados_login)
                $retorno = $dados_login["pessoa_id"];
            else
                $retorno = 0;
            
            Dao::fechaConexao();
            
            return $retorno;            
        }
        
        public function validaSenhaAtual() {

            $query = "SELECT PESSOA_ID 
                      FROM TBPESSOA
                      WHERE PESSOA_ID = ?
                      AND SENHA = ?";
                           
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getPessoaId(), PDO::PARAM_INT);
            $sql->bindValue(2, $this->getSenha(), PDO::PARAM_STR);
            
            $sql->execute();
            
            $dados_login = $sql->fetch(PDO::FETCH_ASSOC);
			
            if ($dados_login)
                $retorno = $dados_login["PESSOA_ID"];
            else
                $retorno = 0;
			
            Dao::fechaConexao();
            
            return ($retorno > 0);
        }        
        
        public function listarPessoas($campo, $valor, $nivel) {
          
            $query = "SELECT 
                      tbpessoa.pessoa_id, 
                      tbpessoa.nome,
                      tbpessoa.endereco,
                      tbpessoa.bairro,
                      tbpessoa.cep,
                      tbpessoa.cpf,
                      tbpessoa.sexo,
                      tbpessoa.dt_nascimento,
                      tbcidades.nome as cidade,
                      tbcidades.sigla_uf as uf,
                      tbpessoa.telefone,
                      tbpessoa.celular,
                      tbpessoa.email,
                      tbpessoa.login,
                      tbpessoa.senha,
                      tbpessoa.ativo,
                      case tbpessoa.nivel
                        when 1 then 'Dentista'
                        when 2 then 'Secretária'
                        when 3 then 'Peciente'
                      end as nivel					  
                      FROM tbpessoa 
                      JOIN tbcidades on (tbcidades.cidade_id = tbpessoa.cidade_id)
                      WHERE tbpessoa.? LIKE ?
                      AND ((? = 0) OR (tbpessoa.nivel = ?))
                      ORDER BY tbpessoa.nome";
               
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $campo, PDO::PARAM_STR);
            $sql->bindValue(2, '%'. $valor .'%', PDO::PARAM_STR);
            $sql->bindValue(3, $nivel, PDO::PARAM_INT);
            $sql->bindValue(4, $nivel, PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
        public function buscaPessoa() {
          
            $query = "SELECT * FROM tbpessoa 
                      WHERE pessoa_id = ?";
          
            $sql = Dao::abreConexao()->prepare($query);
            
            $sql->bindValue(1, $this->getPessoaId(), PDO::PARAM_INT);
            
            $sql->execute();
            
            $retorno = $sql->fetch(PDO::FETCH_ASSOC);
            
            Dao::fechaConexao();
            
            return $retorno;
        }
        
    }

?>