<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Perguntas
                <a  href="<?= base_url('admin/questions') ?>" class="btn btn-warning">Voltar para lista de perguntas</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Criar nova Pergunta
                </div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <form role="form" method="POST" action="<?=base_url('admin/questions/'.$action. (($action=='edit') ? '/'.$element->id :'' ))?>">

                              <fieldset>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Pergunta</label>
  <div class="col-md-12">
  <input id="textinput" name="label" type="text" placeholder="Qual é a pergunta?" class="form-control input-md" required="" value="<?php echo set_value('label', $element->label); ?>">
  <span class="help-block">Pergunta que irá aparecer para o cliente final</span>
  </div>
</div>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Tipo">Tipo</label>
  <div class="col-md-8">
  <div class="radio">
    <label for="Tipo-0">

      <?php $type = set_value('type', $element->type); ?>
      <input type="radio" name="type" id="Tipo-0" value="0" <?php echo ($type == 0) ? 'checked="checked"' : ''; ?>>
      <?php echo $this->config->item('questions_type')[0]; ?>
      <br />
      Múltipla escolha
    </label>
	</div>
  <div class="radio">
    <label for="Tipo-1">
      <input type="radio" name="type" id="Tipo-1" value="1" <?php echo ($type == 1) ? 'checked="checked"' : ''; ?>>
      <?php echo $this->config->item('questions_type')[1]; ?>
      <br />
      Dissertativa
    </label>
	</div>
  </div>
</div>

<!-- Text input-->
<div class="form-group" id="choices-fields">
    <label class="col-md-12 control-label" for="field1">Alternativas</label>
    <div class="col-md-12 controls">
      <?php //if (count($choice)): ?>
      <?php foreach($choice as $key => $c):?>
        <div class="entry input-group col-md-8">
            <input class="form-control" name="choice[<?php echo $c['id'] ;?>]" type="date" placeholder="Resposta" value="<?php echo $c['label'];?>" />
          <span class="input-group-btn">
                <button class="btn btn-success btn-add" type="button">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>
      <?php endforeach; ?>

    </div>
    <div class="col-md-12">
      <span class="help-block">Aperte <span class="glyphicon glyphicon-plus gs"></span> para adicionar um novo campo</span>
    </div>
</div>


<!-- Button -->
<div class="form-group">
  <label class="col-md-10 control-label" for="submit"></label>
  <div class="col-md-2">
    <button id="submit" name="submit" class="btn btn-success">Salvar</button>
  </div>
</div>

</fieldset>

                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<style type="text/css">
.entry:not(:first-of-type)
{
    margin-top: 10px;
}

.glyphicon
{
    font-size: 12px;
}
</style>
<script type="text/javascript">
$(function()
{
    // hide if it is a dissertative type
    if ( $('input[name=type]:checked', 'form').val() == 1 ){
      $('#choices-fields').hide();
    }

    $(document).on('click', '#Tipo-1', function(e)
    {
        $('#choices-fields').fadeOut( "slow" );
    });
    $(document).on('click', '#Tipo-0', function(e)
    {
        $('#choices-fields').fadeIn( "slow" );
    });
    $('.controls:first').find('.entry:not(:last) .btn-add')
        .removeClass('btn-add').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html('<span class="glyphicon glyphicon-minus"></span>');

    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var editing = <?php echo ($action=='edit') ? 'true' :'false'; ?>;

        var controlForm = $('.controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            clone = currentEntry.clone();
            full_name = clone.children().attr('name');
            field_name = full_name.substr(0, full_name.indexOf("[") );
            index = parseInt( full_name.substring(field_name.length+1, full_name.length-1 ) );

            if( editing ) {
              clone.children().attr('name', field_name + "[" + (index+1) + "]");
            }else{
              clone.children().attr('name', field_name + "["+Date.now() +"]");
            }
            newEntry = $(clone).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
      var full_name = $(this).parents('.entry:first').children().attr('name');
      var field_name = full_name.substr(0, full_name.indexOf("[") );
      var index = parseInt( full_name.substring(field_name.length+1, full_name.length-1 ) );

      $.ajax({
        cache: false,
         type: "GET",
         timeout: 5000,
         url: "<?php echo site_url('admin/choices/delete'); ?>/" + index,
      });
  	  $(this).parents('.entry:first').remove();


		e.preventDefault();
		return false;
	});
});

</script>
