<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Pessoa extends PessoaModel {
    
        public function __construct() {
            
            date_default_timezone_set('America/Sao_Paulo');
        }
        
        public function validaNome($nome) {
        
            return $this->validaNomePessoa($nome);
        }
        
        public function login() {
          
            $this->setLogin($_POST["login"]);
            $this->setSenha(md5($_POST["senha"]));
            
            $id = $this->validaLogin();
            
            $retorno = ($id > 0);
            
            if ($retorno) {
            
                $this->buscar($id);
                
                if (!isset($_SESSION))
                   session_start();
              
                $_SESSION["usr_nome"] = $this->getNome();
                $_SESSION["usr_id"]   = $id;

                //seta o tempo limite de inatividade
                $_SESSION["registro"] = time(); // armazena o momento em que foi autenticado
                $_SESSION["limite"] = 900;  //limite para encerrar a sessão por inatividade (segundos)
            }
            
            return $retorno;
        }
        
        public function validaSenha(){
        
            $this->setPessoaId($_SESSION["usr_id"]);
            $this->setSenha(md5($_POST["senha_atual"]));
            
            return $this->validaSenhaAtual();
        }
        
        public function listarTodos($nivel){
        
            $buscar_por = (isset($_POST["buscar_por"]) ? $_POST["buscar_por"] : "pessoa_id");
            $busca = (isset($_POST["busca"]) ? $_POST["busca"] : "");
            
            return $this->listarPessoas($buscar_por, $busca, $nivel);
        }
        
        public function listarTodosAll(){
        
            return $this->listarTodos(0);
        }
        
        public function listarTodosAdministrador(){
        
            return $this->listarTodos(1);
        }
        
        public function listarTodosOperador(){
        
            return $this->listarTodos(2);
        }
        
        public function listarTodosUsuario(){
        
            return $this->listarTodos(3);
        }
        
        public function buscar($codigo) {
        
            $this->setPessoaId($codigo);
            
            $dados_pessoa = $this->buscaPessoa();
            
            $this->setNome($dados_pessoa["NOME"]);
            $this->setEndereco($dados_pessoa["ENDERECO"]);
            $this->setBairro($dados_pessoa["BAIRRO"]);
            $this->setCep($dados_pessoa["CEP"]);
            $this->setCidadeId($dados_pessoa["CIDADE_ID"]);
            $this->setTelefone($dados_pessoa["TELEFONE"]);
            $this->setCelular($dados_pessoa["CELULAR"]);
            $this->setEmail($dados_pessoa["EMAIL"]);
            $this->setNivel($dados_pessoa["NIVEL"]);
            $this->setAtivo($dados_pessoa["ATIVO"]);
            $this->setCpf($dados_pessoa["CPF"]);	
            $this->setDataNascimento($dados_pessoa["DT_NASCIMENTO"]);
            $this->setSexo($dados_pessoa["SEXO"]);
            $this->setLogin($dados_pessoa["LOGIN"]);
            $this->setSenha($dados_pessoa["SENHA"]);
            
            return ($ret_consulta['pessoa_id'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setNome($_POST["nome"]);
            $this->setEndereco($_POST["endereco"]);
            $this->setBairro($_POST["bairro"]);
            $this->setCep($_POST["cep"]);
            $this->setCidadeId($_POST["cidade_id"]);
            $this->setTelefone($_POST["telefone"]);
            $this->setCelular($_POST["celular"]);
            $this->setEmail($_POST["email"]);
            $this->setCpf($_POST["cpf"]);
            $this->setDataNascimento(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setSexo($_POST["sexo"]);
            $this->setNivel($_POST["nivel"]);
            $this->setLogin($_POST["login"]);
            
            $resultado = $this->incluiPessoa();
            
            return $resultado;
        }
        
        public function alteraSenha() {
        
            $this->setPessoaId($_SESSION["usr_id"]);
            $this->setSenha(md5($_POST["nova_senha"]));
            
            return $this->alterarSenha();
        }
        
        public function alterar() {
          
            $this->setPessoaId($_POST["pessoa_id"]);
            $this->setNome($_POST["nome"]);
            $this->setEndereco($_POST["endereco"]);
            $this->setBairro($_POST["bairro"]);
            $this->setCep($_POST["cep"]);
            $this->setCidadeId($_POST["cidade_id"]);
            $this->setTelefone($_POST["telefone"]);
            $this->setCelular($_POST["celular"]);
            $this->setEmail($_POST["email"]);
            $this->setCpf($_POST["cpf"]);
            $this->setDataNascimento(implode("-", array_reverse(explode("/", $_POST["data_1"]))));
            $this->setSexo($_POST["sexo"]);
            $this->setNivel($_POST["nivel"]);
            $this->setAtivo($_POST["ativo"]);
            $this->setLogin($_POST["login"]);
            
            return $this->alterarPessoa();
        }
        
        public function excluir($codigo){
          
            $this->setPessoaId($codigo);
            
            return $this->excluirPessoa();
        }
        
    }
    
?>