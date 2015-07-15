<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    if (!isset($_SESSION)) {
        session_start();
    }
    
    session_destroy();    

    header("Location: login.php"); 
?>
