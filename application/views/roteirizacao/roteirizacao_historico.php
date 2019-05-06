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
                    Hist&oacute;rico de Roteiriza&ccedil;&otilde;es
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./roteirizacao/historico') ?>"><i class="fa fa-map" aria-hidden="true"></i> Roteiriza&ccedil;&atilde;o</a>
                    </li>
                    <li class="active">Hist&o&oacute;rico</li>
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
                    url: '<?=base_url('./roteirizacao/historicoRoteirizacao')?>',
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
