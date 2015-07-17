<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consult�rio m�dico/odontol�gico  */
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
          
            $this->setLogin(filter_input(INPUT_POST, "login"));
            $this->setSenha(md5(filter_input(INPUT_POST, "senha")));
            
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
                $_SESSION["limite"] = 900;  //limite para encerrar a sess�o por inatividade (segundos)
            }
            
            return $retorno;
        }
        
        public function validaSenha(){
        
            $this->setPessoaId($_SESSION["usr_id"]);
            $this->setSenha(md5(filter_input(INPUT_POST, "senha_atual")));
            
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
            
            $ret_consulta = $this->buscaPessoa();
            
            $this->setNome($ret_consulta["NOME"]);
            $this->setEndereco($ret_consulta["ENDERECO"]);
            $this->setBairro($ret_consulta["BAIRRO"]);
            $this->setCep($ret_consulta["CEP"]);
            $this->setCidadeId($ret_consulta["CIDADE_ID"]);
            $this->setTelefone($ret_consulta["TELEFONE"]);
            $this->setCelular($ret_consulta["CELULAR"]);
            $this->setEmail($ret_consulta["EMAIL"]);
            $this->setNivel($ret_consulta["NIVEL"]);
            $this->setAtivo($ret_consulta["ATIVO"]);
            $this->setCpf($ret_consulta["CPF"]);	
            $this->setDataNascimento($ret_consulta["DT_NASCIMENTO"]);
            $this->setSexo($ret_consulta["SEXO"]);
            $this->setLogin($ret_consulta["LOGIN"]);
            $this->setSenha($ret_consulta["SENHA"]);
            
            return ($ret_consulta['pessoa_id'] == $codigo);
        }
        
        public function incluir() {
          
            $this->setNome(trim(strip_tags(filter_input(INPUT_POST, "nome"))));
            $this->setEndereco(trim(strip_tags(filter_input(INPUT_POST, "endereco"))));
            $this->setBairro(trim(strip_tags(filter_input(INPUT_POST, "bairro"))));
            $this->setCep(trim(strip_tags(filter_input(INPUT_POST, "cep"))));
            $this->setCidadeId(trim(strip_tags(filter_input(INPUT_POST, "cidade_id"))));
            $this->setTelefone(trim(strip_tags(filter_input(INPUT_POST, "telefone"))));
            $this->setCelular(trim(strip_tags(filter_input(INPUT_POST, "celular"))));
            $this->setEmail(trim(strip_tags(filter_input(INPUT_POST, "email"))));
            $this->setCpf(trim(strip_tags(filter_input(INPUT_POST, "cpf"))));
            $this->setDataNascimento(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setSexo(trim(strip_tags(filter_input(INPUT_POST, "sexo"))));
            $this->setNivel(trim(strip_tags(filter_input(INPUT_POST, "nivel"))));
            $this->setLogin(trim(strip_tags(filter_input(INPUT_POST, "login"))));
            
            $resultado = $this->incluiPessoa();
            
            return $resultado;
        }
        
        public function alteraSenha() {
        
            $this->setPessoaId($_SESSION["usr_id"]);
            $this->setSenha(md5(filter_input(INPUT_POST, "nova_senha")));
            
            return $this->alterarSenha();
        }
        
        public function alterar($codigo) {
          
            $this->setPessoaId($codigo);
            $this->setNome(trim(strip_tags(filter_input(INPUT_POST, "nome"))));
            $this->setEndereco(trim(strip_tags(filter_input(INPUT_POST, "endereco"))));
            $this->setBairro(trim(strip_tags(filter_input(INPUT_POST, "bairro"))));
            $this->setCep(trim(strip_tags(filter_input(INPUT_POST, "cep"))));
            $this->setCidadeId(trim(strip_tags(filter_input(INPUT_POST, "cidade_id"))));
            $this->setTelefone(trim(strip_tags(filter_input(INPUT_POST, "telefone"))));
            $this->setCelular(trim(strip_tags(filter_input(INPUT_POST, "celular"))));
            $this->setEmail(trim(strip_tags(filter_input(INPUT_POST, "email"))));
            $this->setCpf(trim(strip_tags(filter_input(INPUT_POST, "cpf"))));
            $this->setDataNascimento(implode("-", array_reverse(explode("/", filter_input(INPUT_POST, "data_1")))));
            $this->setSexo(trim(strip_tags(filter_input(INPUT_POST, "sexo"))));
            $this->setNivel(trim(strip_tags(filter_input(INPUT_POST, "nivel"))));
            $this->setAtivo(trim(strip_tags(filter_input(INPUT_POST, "ativo"))));
            $this->setLogin(trim(strip_tags(filter_input(INPUT_POST, "login"))));
            
            return $this->alterarPessoa();
        }
        
        public function excluir($codigo){
          
            $this->setPessoaId($codigo);
            
            return $this->excluirPessoa();
        }
        
    }
    
?>