<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Perguntas</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">

<?php echo form_open('/'); ?>
<?php foreach ( $questions as $question ): ?>

  <!-- Pergunta -->
  <?php echo $question['label'];?>
  <br />

  <!-- Respostas -->
  <?php if($question['type'] == 0):?>

    <?php foreach ( $question['choices'] as $choice ): ?>
      <?php
      $data = array(
      'name'        => 'answers[' . $question['id'] . '][choice]',
      'id'          => 'answers[' . $question['id'] . '][choice]',
      'value'       => $choice['id'],
      //'checked'     => TRUE,
      //'style'       => 'margin:10px',
      ); ?>
      <?php echo form_radio($data) . $choice['label'];;?>
      <br />
    <?php endforeach; ?>

  <?php elseif($question['type'] == 1):?>
    <?php
    $data = array(
              'name'        => 'answers[' . $question['id'] . '][answer]',
              'id'          => 'answers[' . $question['id'] . '][answer]',
              //'value'       => '',
              //'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );?>
    <?php echo form_textarea($data); ?><br />

  <?php endif; ?>

  <!-- Botões -->
  <?php echo form_button('', 'próximo'); ?>
  <br />
  <br />

<?php endforeach; ?>


<?php echo form_submit('ok', 'Finalizar'); ?>
<?php echo form_close(); ?>


  </div>
</div>
