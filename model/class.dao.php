<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    define('HOST', 'localhost');
    define('DB', 'db_consultorio');
    define('USER', 'root');
    define('PASS', '');

    class Dao {

        private $conn;

        static public function abreConexao() {

            $conexao = 'mysql:host='.HOST.';dbname='.DB;

            try{
                $conn = new PDO($conexao, USER, PASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;

            }catch (PDOexception $error_conecta){

                $conn = null;

                //echo 'Erro ao conectar, favor entrar em contato com o suporte';
                echo 'Erro ao conectar no banco de dados: '.$error_conecta->getMessage();

                exit();
            }

        }
        

        static public function fechaConexao() {

            $conn = null;
        }
        
    }
?>
