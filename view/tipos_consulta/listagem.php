<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once("../header.php");
    
    include_once("../../model/class.tipo_consulta.php");
    include_once("../../controller/class.tipo_consulta.php");

    $tipocons = new TipoConsulta();

    $tipos = $tipocons->listarTodos();

    $cont = count($tipos);

?>

    <script type="text/javascript" src="/view/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/view/js/jquery-DT-pagination.js"></script>
    
    <script type="text/javascript">
    /* Table initialisation */
    $(document).ready(function() {
      $('#listagem').dataTable( {
              "bSort": false,      // Disable sorting
        "iDisplayLength": 10,   //records per page
          "sDom": "t<'row'<'col-md-6'i><'col-md-6'p>>",
          "sPaginationType": "bootstrap"
        });
      });
    </script>
    
    <style>
    .pagination {
          margin:0 ! important;
    }</style> 

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <legend class="page-header">Listagem de Tipos de Consulta
    <div class="btn-group pull-right">
      <a class="btn btn-success" title="Novo registro" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
    </div>
  </legend>

  <?php if ($cont > 0){ ?>
    <p class="text-muted"><i>(Clique sobre o registro para editar/excluir)</i></p>
  <?php } ?>

  <div class="table">
    <table class="table table-striped table-condensed table-hover" id="listagem">
      <thead>
        <tr>
          <th class="col-sm-1">Código</th>
          <th class="col-sm-4">Descrição</th>
          <th class="col-sm-3">Valor</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tipos as $row) { ?>
          <tr title="Manutenção no registro" style="cursor:pointer" onClick="document.location.href='cadastro.php?id=<?php echo $row["TIPOCONSULTA_ID"];?>'">
            <td><?php echo $row["TIPOCONSULTA_ID"]; ?></td>
            <td><?php echo $row["DESCRICAO"]; ?></td>
            <td><?php echo number_format($row["VALOR"], 2, ',', '.'); ?></td>           
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div> <!-- /table --> 
  <div class="alert alert-success">
    <strong><?php echo "$cont Registro(s) encontrado(s)."; ?></strong>
  </div>
  <br />

</div> <!-- /main -->

<?php include_once("../footer.php"); ?>