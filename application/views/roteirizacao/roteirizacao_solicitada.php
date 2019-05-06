<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Roteirizacao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/roteirizacao.css') ?>">

    <!-- JS Roteirizacao -->
    <script src="<?= base_url('scripts/js/roteirizacao.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Roteiriza&ccedil;&otilde;es Solicitadas
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./roteirizacao/historico') ?>"><i class="fa fa-map" aria-hidden="true"></i> Roteiriza&ccedil;&atilde;o</a>
                    </li>
                    <li class="active">Consultar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-90">

                            <div class="box-body">

                                <table id="tbl_roteiriza" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>N&ordm; da Roteiriza&ccedil;&atilde;o</th>
                                            <th>CNPJ</th>
                                            <th>Cliente</th>
                                            <th>Data da Solicita&ccedil;&atilde;o</th>
                                            <th>Data de Resposta</th>
                                            <th>Status</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>N&ordm; da Roteiriza&ccedil;&atilde;o</th>
                                            <th>CNPJ</th>
                                            <th>Cliente</th>
                                            <th>Data da Solicita&ccedil;&atilde;o</th>
                                            <th>Data de Resposta</th>
                                            <th>Status</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>

                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Modal Editar Status -->
        <div class="modal fade" id="modal_status">
            <div class="modal-dialog" id="modal-dialog-status">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title">Editar Status</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid box box-primary" id="box-frm-bencard-func">
                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>
                            <form role="form" name="frm_edit_status" id="frm_edit_status">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
                                                <label for="id_status">Status<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="id_status" id="id_status" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($status)):
                                                            foreach ($status as $value):
                                                                echo "<option value='$value->id_status_roteiriza_pk'>$value->status_roteiriza</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="div_anexo">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="anexo">Selecione a Carta de Roteiriza&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="file" class="form-control" id="anexo" name="anexo" placeholder="Selecione..." accept=".pdf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <input type="hidden" id="id_roteiriza" name="id_roteiriza" value="">
                                    <button type="submit" id="btn_edit_status" name="btn_edit_status" class="btn btn-success">Alterar</button>
                                    <button type="reset" id="cancel_status" name="cancel_status" class="btn btn-primary">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>

    <script>
        $(document).ready(function () {
            $('#tbl_roteiriza').DataTable({
                "columns": [
                    {data: "id_roteirizacao_pk"},
                    {data: "cnpj"},
                    {data: "nome_razao"},
                    {data: "dt_hr"},
                    {data: "dt_hr_usuario"},
                    {data: "status_roteiriza"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                retrieve         : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./roteirizacao/solicitadaRoteirizacao')?>',
                    type: 'POST'
                },
                "language": {
                    "sEmptyTable"     : "Nenhum registro encontrado",
                    "sInfo"           : "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty"      : "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered"   : "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix"    : "",
                    "sInfoThousands"  : ".",
                    "sLengthMenu"     : "_MENU_ Resultados por Página",
                    "sLoadingRecords" : "Carregando...",
                    "sProcessing"     : "Processando...",
                    "sZeroRecords"    : "Nenhum registro encontrado",
                    "sSearch"         : "Pesquisar",
                    "oPaginate": {
                        "sNext"     : "Próximo",
                        "sPrevious" : "Anterior",
                        "sFirst"    : "Primeiro",
                        "sLast"     : "Último"
                    },
                    "oAria": {
                        "sSortAscending"  : ": Ordenar colunas de forma ascendente",
                        "sSortDescending" : ": Ordenar colunas de forma descendente"
                    }
                }
            });

        });
    </script>
