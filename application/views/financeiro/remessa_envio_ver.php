<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Financeiro -->
    <link rel="stylesheet" href="<?= base_url('assets/css/financeiro.css') ?>">

        <!-- JS Financeiro -->
    <script src="<?= base_url('scripts/js/financeiro.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Envio de Remessa
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-money" aria-hidden="true"></i> Financeiro</li>
                    <li class="active">Remessa</li>
                    <li class="active">Ver Envio</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_ver_rem" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Data Emiss&atilde;o</th>
                                            <th>Nome Arquivo</th>
                                            <th>Qtde Boletos</th>
                                            <th>Valor Total</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Data Emiss&atilde;o</th>
                                            <th>Nome Arquivo</th>
                                            <th>Qtde Boletos</th>
                                            <th>Valor Total</th>
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
        
        <div class="modal fade" id="modal_remessa">
            <div class="modal-dialog" id="modal-dialog-remessa">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="title_modal_remessa"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="list_bol_rem"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="box-footer text-center">
                                    <button type="button" id="btn_close" name="btn_close" class="btn btn-primary">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>

    <script>
        $(document).ready(function () {
            $('#tbl_ver_rem').DataTable({
                "columns": [
                    {data: "dt_emissao"},
                    {data: "arquivo"},
                    {data: "qtde_linha_arq"},
                    {data: "vl_total_titulo"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                "retrieve"       : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./remessa/buscarRemEnvio')?>',
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