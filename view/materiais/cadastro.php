<?php

    include_once("../header.php");
    
    include_once("../../model/class.materiais.php");
    include_once("../../controller/class.materiais.php");
    
    $material = new Material();

    $acao   = isset($_GET["acao"]) ? $_GET["acao"] : "";
    $codigo = isset($_GET["id"]) ? $_GET["id"] : 0;
    
    if ($codigo > 0) {
      
        if (! $material->buscarPorCodigo($codigo)) {
            echo("<script>
                    alert('Registro não encontrado!');
                    window.location = 'listagem.php';
                  </script>");
            exit();
        }
    }

    if (($acao == "excluir")&&($codigo > 0)) {
    
        if ($material->excluir($codigo)) {
            echo "<script>window.location = 'listagem.php';</script>";
        }
        else {
            echo("<script>
                    alert('Erro ao excluir o cadastro. Verifique as dependências e tente novamente.');
                    window.location = 'listagem.php';
                  </script>");
        }
    }

  if ($_POST) {

    if ($codigo == 0) {
      if ($material->incluir()) {
        echo "<script>window.location = 'listagem.php';</script>";
      }
      else
        echo "<script>alert('Erro ao incluir!')</script>";
    }
    else {
      if ($material->alterar($codigo)) 
        echo "<script>window.location = 'listagem.php';</script>";
      else
        echo "<script>alert('Erro ao alterar!')</script>";
    }
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
    <legend class="page-header">Cadastro de Serviço - <?php echo ($codigo == 0) ? "incluir" : "editar" ?>
      <div class="btn-group pull-right">
        <a class="btn btn-success" title="Novo registro" href="cadastro.php"><span class="glyphicon glyphicon-file"></span> Novo</a>
        <?php if ($codigo > 0){ ?>
          <a class="btn btn-danger" title="Excluir registro" onclick="javascript: if(confirm('Confirma a exclusão do registro?')) location.href='cadastro.php?acao=excluir&id=<?php echo $codigo;?>'">
            <span class="glyphicon glyphicon-trash"></span> Excluir
          </a>
        <?php } ?>
      </div>
    </legend>
  </div>

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-med">

    <form id="form_cad" class="form" role="form" method="post">

      <div class="row">
        <div class="form-group col-lg-3">
          <span>Código:</span>
          <input type="text" name="material_id" class="form-control" value="<?php echo $material->getMaterialId(); ?>" disabled />
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-9">
          <span>Descrição:</span>
          <input type="text" name="descricao" class="form-control" maxlength="80" value="<?php echo $material->getDescricao(); ?>" required autofocus
          data-bv-stringlength="true"
          data-bv-stringlength-min="5"
          data-bv-stringlength-message="A descrição deve conter no mínimo 5 caracteres" />
        </div>
      </div>
      
      <div class="row">
        <div class="form-group col-lg-3">
          <span>Valor:</span>
          <input type="text" name="valor" class="form-control" maxlength="10" value="<?php echo number_format($material->getValor(), 2, ',', ''); ?>" required />
        </div>
        
        <div class="form-group col-lg-3">
          <span>Saldo mínimo:</span>
          <input type="text" name="saldo_minimo" class="form-control" maxlength="10" value="<?php echo number_format($material->getSaldoMin(), 2, ',', ''); ?>" required />
        </div>
        
        <div class="form-group col-lg-3">
          <span>Saldo atual:</span>
          <input type="text" name="saldo_atual" class="form-control" maxlength="10" value="<?php echo number_format($material->getSaldoAtual(), 2, ',', ''); ?>" disabled />
        </div>
      </div>      
      
      <div class="btn-group">
        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok"></span> Gravar</button>
        <a class="btn btn-warning" href="listagem.php"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
      </div>
    </form>

  </div> <!-- /main -->
  
  <script src="/view/js/bootstrapValidator.min.js"></script>

<?php include_once("../footer.php") ?>