<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once("../header.php");
?>

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <legend class="page-header">Busca de Serviços
      <div class="btn-group pull-right">
        <a class="btn btn-success" title="Novo registro" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
      </div>
    </legend>
  </div>

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-med">

    <form class="form" role="form" method="post" action="listagem.php">

      <div class="row">
        <div class="form-group col-lg-8">
          <span>Buscar por:</span>
          <select class="form-control" name="buscar_por">
            <option value="servico_id">Código</option>
            <option value="descricao" selected="selected">Descrição</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-8">
          <span>Busca:</span>
          <div class="input-group">
            <input type="text" class="form-control" name="busca" autofocus>
            <span class="input-group-btn">
            <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span> Buscar</button>
            </span>
          </div><!-- /input-group -->
        </div>
      </div>
      
      <p class="text-muted"><i>* Deixe a busca em branco para retornar todos os registros.</i></p>
    </form>

  </div> <!-- /main -->

<?php include_once("../footer.php"); ?>