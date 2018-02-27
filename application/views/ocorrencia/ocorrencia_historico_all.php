<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Ocorrencia -->
    <link rel="stylesheet" href="<?= base_url('assets/css/ocorrencia.css') ?>">

    <!-- JS Ocorrencia -->
    <script src="<?= base_url('scripts/js/ocorrencia.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Hist&oacute;rico de Ocorr&ecirc;ncias
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-support" aria-hidden="true"></i> Ocorr&ecirc;ncias</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_ocorr" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>Dt. Solicita&ccedil;&atilde;o</th>
                                            <th>Empresa</th>
                                            <th>Funcion&aacute;rio</th>
                                            <th>Motivo</th>
                                            <th>E-mail para Retorno</th>
                                            <th>Status</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>Dt. Solicita&ccedil;&atilde;o</th>
                                            <th>Empresa</th>
                                            <th>Funcion&aacute;rio</th>
                                            <th>Motivo</th>
                                            <th>E-mail para Retorno</th>
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

        <div class="modal fade" id="modal_status">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="title_modal_status"></h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="frm_alter_status" name="frm_alter_status">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status" style="padding: 5px;">Status:</label>
                                        <input type="hidden" name="id_ocorrencia_fk" id="id_ocorrencia_fk" value="">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select class="form-control" name="status" id="status" required="true"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group align_center">
                                        <button type="submit" class="btn btn-success" name="alt_status" id="alt_status">Salvar</button>
                                        <button type="reset" id="limpar" name="limpar" class="btn btn-primary" data-dismiss="modal" style="margin-left: 5px;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>

    <script>
        $(document).ready(function () {
            $('#tbl_ocorr').DataTable({
                "order": [[0, "desc"]],
                "columns": [
                    {data: "id_ocorrencia_pk"},
                    {data: "dt_hr_cad"},
                    {data: "nome_razao"},
                    {data: "nome"},
                    {data: "ocorr_motivo"},
                    {data: "email_retorno"},
                    {data: "ocorr_status"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                retrieve         : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./ocorrencia/buscarOcorrenciaVt')?>',
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