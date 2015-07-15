<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    require "verifica.php";

    //retorna o diretório atual    
    $path = explode('/', dirname($_SERVER['PHP_SELF']));
    $dir = end($path);
    
    
    include_once($_SERVER['DOCUMENT_ROOT']."/model/class.pessoa.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/controller/class.pessoa.php");


    if ($_POST){
    
        if (isset($_POST["nova_senha"])) {

            $pessoa = new Pessoa();

            if ($pessoa->validaSenha()) {

                if ($_POST["nova_senha"] == $_POST["conf_senha"]) {

                    if ($pessoa->alteraSenha()) {

                        echo("
                            <script>
                                alert('Senha alterada com sucesso! Por favor, faça o login novamente');
                                location.href = '/view/logout.php';
                            </script>
                        ");
                    }
                    else
                        echo("<script>alert('Erro ao alterar a senha. Por favor, tente novamente.');</script>");

                }
                else {
                    echo("
                        <script>
                            alert('A senha informada não confere. Favor verificar!');
                        </script>
                    ");
                }
            }
            else {
                echo("
                    <script>
                        alert('Senha atual não confere! Favor verificar');
                    </script>
                ");
            }
        
        }
    }    
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="/view/imagens/icon.ico">

  <title>Consultório</title>

  <!-- Bootstrap core CSS -->
  <link href="/view/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="/view/templates/dashboard.css" rel="stylesheet">
  
  <!-- responsive layout -->
  <script type="text/javascript" language="javascript" src="/view/js/jquery.min.js"></script>
  
  <link rel="stylesheet" href="/view/css/bootstrapValidator.min.css"/>
  
  <script src="/view/js/bootstrapValidator.min.js"></script>

  <script>
  $(document).ready(function() {
      $('#form_senha')
          .bootstrapValidator({
              // Only disabled elements are excluded
              // The invisible elements belonging to inactive tabs must be validated
              excluded: [':disabled'],
              feedbackIcons: {
                  valid: 'glyphicon glyphicon-ok',
                  invalid: 'glyphicon glyphicon-remove',
                  validating: 'glyphicon glyphicon-refresh'
              }
          });
  });
  </script>   
</head>
<body>
  <!-- TOOLBAR TOP -->
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="/view/main.php" title="Página principal"><img src="/view/imagens/logo-mini.png" height="50px" class="img-responsive center-block"></a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav visible-xs">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pencil"></span> Cadastros<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/view/agenda/busca.php">Agenda</a></li>
              <li><a href="/view/consultas/busca.php">Consulta</a></li>
              <li><a href="/view/contas_receber/busca.php">Contas a Receber</a></li>
              <li><a href="/view/materiais/busca.php">Materiais</a></li>
              <li><a href="/view/mov_estoque/busca.php">Mov. Estoque</a></li>
              <li><a href="/view/pessoas/busca.php">Pessoas</a></li>
              <li><a href="/view/salas/busca.php">Salas</a></li>
              <li><a href="/view/servicos/busca.php">Serviços</a></li>
              <li><a href="/view/tipos_atendimento/busca.php">Tipo Atendimento</a></li>
              <li><a href="/view/tipos_consulta/busca.php">Tipo Consulta</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["usr_nome"]; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="" data-toggle="modal" data-target="#modalAlteraSenha" title="Alterar senha de acesso"><span class="glyphicon glyphicon-cog"></span> Alterar Senha</a></li>
              <li><a href="/view/logout.php" title="Desconectar-se"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <!-- Modal - altera senha -->
  <div class="modal fade bs-example-modal-sm" id="modalAlteraSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="form_senha" class="form" role="form" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Alterar senha de acesso</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-lg-12">
                <span>Senha Atual:</span>
                <input type="password" name="senha_atual" class="form-control" placeholder="informe a senha atual" maxlength="20" required autofocus
                
                data-bv-different="true"
                data-bv-different-field="nova_senha"
                data-bv-different-message="A nova senha deve ser diferente da senha atual" />
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-12">
                <span>Nova Senha:</span>
                <input type="password" name="nova_senha" class="form-control" placeholder="informe a nova senha" maxlength="20" required 
                data-bv-stringlength="true"
                data-bv-stringlength-min="4"
                data-bv-stringlength-message="A senha deve ter no mínimo 4 caracteres"
              
                data-bv-identical="true"
                data-bv-identical-field="conf_senha"
                data-bv-identical-message="A senha e a confirmação de senha devem ser iguais" 
                
                data-bv-different="true"
                data-bv-different-field="senha_atual"
                data-bv-different-message="A nova senha deve ser diferente da senha atual" />
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-12">
                <span>Confirme a Nova Senha:</span>
                <input type="password" name="conf_senha" class="form-control" placeholder="confirme a nova senha" maxlength="20" required 
                data-bv-stringlength="true"
                data-bv-stringlength-min="4"
                data-bv-stringlength-message="A senha deve ter no mínimo 4 caracteres"
              
                data-bv-identical="true"
                data-bv-identical-field="nova_senha"
                data-bv-identical-message="A senha e a confirmação de senha devem ser iguais" 
                
                data-bv-different="true"
                data-bv-different-field="senha_atual"
                data-bv-different-message="A nova senha deve ser diferente da senha atual" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Alterar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /altera senha -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <li><div class="span text-center"><h2>Menu</h2></div></li>
          <li <?php if($dir=='agenda'){ ?> class="active" <?php } ?> ><a href="/view/agenda/busca.php">Agenda</a></li>
          <li <?php if($dir=='consultas'){ ?> class="active" <?php } ?> ><a href="/view/consultas/busca.php">Consultas</a></li>
          <li <?php if($dir=='contas_receber'){ ?> class="active" <?php } ?> ><a href="/view/contas_receber/busca.php">Contas a Receber</a></li>
          <li <?php if($dir=='materiais'){ ?> class="active" <?php } ?> ><a href="/view/materiais/busca.php">Materiais</a></li>
          <li <?php if($dir=='mov_estoque'){ ?> class="active" <?php } ?> ><a href="/view/mov_estoque/busca.php">Movimentação de Estoque</a></li>
          <li <?php if($dir=='pessoas'){ ?> class="active" <?php } ?> ><a href="/view/pessoas/busca.php">Pessoas</a></li>
          <li <?php if($dir=='salas'){ ?> class="active" <?php } ?> ><a href="/view/salas/busca.php">Salas</a></li>
          <li <?php if($dir=='servicos'){ ?> class="active" <?php } ?> ><a href="/view/servicos/busca.php">Serviços</a></li>
          <li <?php if($dir=='tipos_atendimento'){ ?> class="active" <?php } ?> ><a href="/view/tipos_atendimento/busca.php">Tipo de Atendimento</a></li>
          <li <?php if($dir=='tipos_consulta'){ ?> class="active" <?php } ?> ><a href="/view/tipos_consulta/busca.php">Tipo de Consulta</a></li>
        </ul>
      </div> <!-- /sidebar -->
