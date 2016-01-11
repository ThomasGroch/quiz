<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    Perguntas
                    <a  href="<?= base_url('admin/questions/create') ?>" class="btn btn-success">Adicionar</a>
                </h2>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de Perguntas
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th style="display:none">order_field</th>
                                    <th>Ordenar</th>
                                    <th>Pergunta</th>
                                    <th>Tipo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($questions)): ?>
                                    <?php foreach ($questions as $key => $list): ?>
                                        <tr class="odd gradeX" id="<?=$list['id']?>">
                                            <td style="display:none"><?=$list['order_field']?></td>
                                            <td><i class="fa fa-bars fa-2" style="font-size: x-large; cursor:grab"></i></td>
                                            <td><?=$list['label']?></td>
                                            <td><center><?=$list['type']?></center></td>
                                            <td>
                                                <a href="<?= base_url('admin/questions/edit/'.$list['id']) ?>" class="btn btn-info">editar</a>
                                                <a href="<?= base_url('admin/questions/delete/'.$list['id']) ?>" class="btn btn-danger">deletar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="even gradeC">
                                        <td>Nenhum registro</td>
                                        <td>Nenhum registro</td>
                                        <td>Nenhum registro</td>
                                        <td>Nenhum registro</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th>ID</th>
                                    <th>Pergunta</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
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
            // "createdRow": function(row, data, dataIndex){
            //    $(row).attr('id', 'row-' + dataIndex);
            // }
        });

        table.rowReordering({ sURL:"<?php echo site_url('admin/questions/sort'); ?>", sRequestType: "POST"});

  });
</script>
