<?php 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* Gerenciamento de consultório médico/odontológico  */
    /*       Desenvolvido por: Reinaldo Silveira         */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * */

    include_once("../header.php");
    
    include_once("../../model/class.materiais.php");
    include_once("../../controller/class.materiais.php");
    
    $material = new Material();
    
    $materiais = $material->listarTodos();
    
?>
  <link rel="stylesheet" href="/view/css/bootstrap-datetimepicker.min.css"/>

  <script src="/view/js/moment.js"></script>
  <script src="/view/js/bootstrap-datetimepicker.js"></script>
  <script src="/view/js/bootstrap-datepicker.pt-BR.js"></script>
  <script src="/view/js/jquery.mask.min.js"></script>  
  <script src="/view/js/bootstrapValidator.min.js"></script>  
  
  <script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            language: 'pt-br',
            pickTime: false
        }),
        $('#datetimepicker2').datetimepicker({
            language: 'pt-br',
            pickTime: false
        });
    });
      
    $(document).ready(function() {
        $('#form_busca').find('[name="data_ini"]').mask('99/99/9999');
        $('#form_busca').find('[name="data_fin"]').mask('99/99/9999');
    });
  </script>

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <legend class="page-header">Busca de Movimentação de Estoque
      <div class="btn-group pull-right">
        <a class="btn btn-success" title="Novo registro" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
      </div>
    </legend>
  </div>

  <div id="form_busca" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-med">

    <form class="form" role="form" method="post" action="listagem.php">

      <div class="row">
        <div class="form-group col-lg-8">
          <span>Material:</span>
          <select class="form-control" name="material_id" required>
            <option value="0">-- Todos --</option>
            <?php foreach($materiais as $row) { ?>
              <option value="<?php echo $row['MATERIAL_ID']; ?>"><?php echo $row["DESCRICAO"]; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-4">
          <span>Data inicial:</span>
          <div class="input-group">
            <div class='input-group date' id='datetimepicker1' data-date-format="DD/MM/YYYY">
              <input type='text' class="form-control" id="data_ini" name="data_ini" value="<?php echo date('d/m/Y'); ?>"/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
          
        <div class="form-group col-lg-4">
          <span>Data final:</span>
          <div class="input-group">
            <div class='input-group date' id='datetimepicker2' data-date-format="DD/MM/YYYY">
              <input type='text' class="form-control" id="data_fin" name="data_fin" value="<?php echo date("d/m/Y"); ?>"/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-8">
          <span>Movimentação:</span>
          <div class="input-group">
            <select class="form-control" name="tipo" required >
              <option value="A">-- Ambas --</option>
              <option value="E">Entrada</option>
              <option value="S">Saída</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span> Buscar</button>
            </span>
          </div><!-- /input-group -->
        </div>
      </div>
    </form>

  </div> <!-- /main -->

<?php include_once("../footer.php"); ?>