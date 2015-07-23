<?php

    include_once("../header.php");
    
    include_once("../../model/class.materiais.php");
    include_once("../../controller/class.materiais.php");
    
    include_once("../../model/class.mov_estoque.php");
    include_once("../../controller/class.mov_estoque.php");
    
    include_once("../../model/class.pessoa.php");
    include_once("../../controller/class.pessoa.php");
    
    $movto = new MovEstoque();
    $material = new Material();
    $pessoa = new Pessoa();
    
    $materiais = $material->listarTodos();
    
    $codigo = isset($_GET["id"]) ? $_GET["id"] : 0;
    
    if ($codigo > 0) {
    
        if (! $movto->buscarPorCodigo($codigo)) {
            echo("<script>
                    alert('Registro não encontrado!');
                    window.location = 'listagem.php';
                  </script>");
            exit();
        }
        
        $pessoa->buscarPorCodigo($movto->getPessoaId());
    }
    elseif (($_POST)&&($codigo == 0)) {

      if ($movto->incluir()) {
          $_SESSION["busca1"] = date("d/m/Y");
          $_SESSION["busca2"] = date("d/m/Y");
          $_SESSION["busca3"] = $_POST["material_id"];
          $_SESSION["busca4"] = $_POST["tipo"];
        
          echo "<script>window.location = 'listagem.php';</script>";
      }
      else
          echo "<script>alert('Erro ao incluir!')</script>";
  }

?>

  <link rel="stylesheet" href="/view/css/bootstrapValidator.min.css"/>
  
  <script>
  $(document).ready(function() {
      $('#form_cad')
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

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <legend class="page-header">Movimentação de estoque
      <div class="btn-group pull-right">
        <a class="btn btn-success" title="Nova movimentação" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
        <a class="btn btn-info" title="Nova busca" href="busca.php"><span class="glyphicon glyphicon-search"></span> Buscar</a>
      </div>
    </legend>
  </div>

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-med">

    <form id="form_cad" class="form" role="form" method="post">

      <div class="row">
        <div class="form-group col-lg-9">
          <span>Material:</span>
          <select class="form-control" name="material_id" <?php echo ($codigo == 0) ? "required" : "readonly"; ?> >
            <?php foreach($materiais as $row) { ?>
              <option <?php if ($movto->getMaterialId() == $row["MATERIAL_ID"]){echo 'selected';} ?> value="<?php echo $row['MATERIAL_ID']; ?>"><?php echo $row["DESCRICAO"]; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-3">
          <span>Quantidade:</span>
          <input type="text" name="quantidade" class="form-control" maxlength="10" value="<?php echo number_format($movto->getQuantidade(), 2, ',', ''); ?>" 
          <?php echo ($codigo == 0) ? "required" : "readonly"; ?> />
        </div>

        <div class="form-group col-lg-6">
          <span>Tipo:</span>
          <select class="form-control" name="tipo" <?php echo ($codigo == 0) ? "required" : "readonly"; ?> >
            <option <?php if ($movto->getTipo() == 'E'){echo 'selected';} ?> value="E">Entrada</option>
            <option <?php if ($movto->getTipo() == 'S'){echo 'selected';} ?> value="S">Saída</option>
          </select>
        </div>
      </div>
      
      <div class="row">
        <div class="form-group col-lg-9">
          <span>Observação:</span>
          <textarea name="observacao" class="form-control" rows="3" maxlength="200" <?php if ($codigo > 0){echo "readonly"; } ?> ><?php echo $movto->getObservacao(); ?></textarea>
        </div>
      </div>
      
      <?php if ($codigo > 0) { ?>
        <div class="row">
          <div class="form-group col-lg-4">
            <span>Data:</span>
            <input type="text" name="data" class="form-control" value="<?php echo date("d/m/Y H:i:s", strtotime($movto->getData())); ?>" readonly/>
          </div>
          
          <div class="form-group col-lg-5">
            <span>Usuário:</span>
            <input type="text" name="usuario" class="form-control" value="<?php echo $pessoa->getNome(); ?>" readonly/>
          </div>
        </div>
      <?php } ?>
      
      <div class="btn-group">
        <?php if ($codigo == 0){ ?>
          <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok"></span> Gravar</button>
          <a class="btn btn-warning" href="listagem.php"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
        <?php } else { ?>
          <a class="btn btn-default" href="listagem.php"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
        <?php } ?>
      </div>      
    </form>

  </div> <!-- /main -->
  
  <script src="/view/js/bootstrapValidator.min.js"></script>

<?php include_once("../footer.php") ?>