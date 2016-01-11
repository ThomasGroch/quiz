<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Resultados</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                  Lista de Respostas de cada sessão
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <div class="dataTable_wrapper">

                    <?php echo $table; ?>

                  </div>
                  <!-- /.table-responsive -->
                  <?php /*
                  <div class="well">
                      <h4>Exportação dos dados</h4>
                      <p>text text</p>
                      <a class="btn btn-default btn-lg btn-block" target="_blank" href="#">link</a>
                  </div>
                  */?>
              </div>
              <!-- /.panel-body -->
          </div>
          <!-- /.panel -->


      </div>
    </div>

</div>
<!-- /#page-wrapper -->

<script>
    $(document).ready(function() {
        var table = $('#dataTables-example').DataTable({
            responsive: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/Portuguese-Brasil.json"
            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
        });

  });
</script>
