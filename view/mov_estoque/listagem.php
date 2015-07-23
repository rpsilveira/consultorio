<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once("../header.php");
    
    include_once("../../model/class.mov_estoque.php");
    include_once("../../controller/class.mov_estoque.php");

    $mov = new MovEstoque();

    $movtos = $mov->buscar();

    $cont = count($movtos);

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

  <legend class="page-header">Listagem de Movimentação de Estoque
    <div class="btn-group pull-right">
      <a class="btn btn-success" title="Nova movimentação" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
      <a class="btn btn-info" title="Nova busca" href="busca.php"><span class="glyphicon glyphicon-search"></span> Buscar</a>
    </div>
  </legend>

  <?php if ($cont > 0){ ?>
    <p>
      <strong class="text-success"><?php echo "$cont Registro(s) encontrado(s)."; ?></strong>
      <i class="text-muted">(Clique sobre o registro para visualizar os detalhes)</i>
    </p>
  <?php } else { ?>
    <strong class="text-danger">Nenhum registro encontrado.</strong>
  <?php } ?>

  <div class="table">
    <table class="table table-condensed table-hover" id="listagem">
      <thead>
        <tr>
          <th class="col-sm-2">Data</th>
          <th class="col-sm-4">Material</th>
          <th class="col-sm-2">Quantidade</th>
          <th class="col-sm-2">Tipo</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($movtos as $row) { ?>
          <tr class="<?php echo $row["TIPO"] == 'Entrada' ? 'success' : 'danger'; ?>" title="Visualizar detalhes" style="cursor:pointer" onClick="document.location.href='cadastro.php?id=<?php echo $row["MOVESTOQUE_ID"];?>'">
            <td><?php echo date("d/m/Y H:i:s", strtotime($row["DATA"])); ?></td>
            <td><?php echo $row["MATERIAL"]; ?></td>
            <td><?php echo number_format($row["QUANTIDADE"], 2, ',', '.'); ?></td>
            <td><?php echo utf8_encode($row["TIPO"]); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div> <!-- /table --> 

</div> <!-- /main -->

<?php include_once("../footer.php"); ?>