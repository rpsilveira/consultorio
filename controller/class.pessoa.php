<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    class Pessoa extends PessoaModel {
    
        public function __construct() { }
        
        
        public function validaNome($nome) {
        
            return $this->validaNomePessoa($nome);
        }
        
        public function loginUsuario() {
          
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
        
        public function validaSenha($codigo, $senha){
        
            $senha = md5($senha);
            
            return $this->validaSenha($codigo, $senha);
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
            
            $this->setNome($dados_pessoa["nome"]);
            $this->setEndereco($dados_pessoa["endereco"]);
            $this->setBairro($dados_pessoa["bairro"]);
            $this->setCep($dados_pessoa["cep"]);
            $this->setCidadeId($dados_pessoa["cidade_id"]);
            $this->setTelefone($dados_pessoa["telefone"]);
            $this->setCelular($dados_pessoa["celular"]);
            $this->setEmail($dados_pessoa["email"]);
            $this->setNivel($dados_pessoa["nivel"]);
            $this->setAtivo($dados_pessoa["ativo"]);
            $this->setCpf($dados_pessoa["cpf"]);	
            $this->setDataNascimento($dados_pessoa["dt_nascimento"]);
            $this->setSexo($dados_pessoa["sexo"]);
            $this->setLogin($dados_pessoa["login"]);
            $this->setSenha($dados_pessoa["senha"]);
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
        
        public function alteraSenha($codigo) {
        
            $this->setPessoaId($codigo);
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