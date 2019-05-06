<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Fornecedor -->
    <link rel="stylesheet" href="<?= base_url('assets/css/fornecedor.css') ?>">

    <!-- JS Fornecedor -->
    <script src="<?= base_url('scripts/js/fornecedor.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gerenciamento de Fornecedores
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-building" aria-hidden="true"></i> Fornecedores</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box-wrapper-btn">
                            <button class="btn btn-success" id="btn_cad_forn">Cadastrar Fornecedor</button>
                        </div>

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_fornec_vt" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Fornecedor</th>
                                            <th class="col-xs-2">Status</th>
                                            <th class="col-xs-2">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Fornecedor</th>
                                            <th class="col-xs-2">Status</th>
                                            <th class="col-xs-2">A&ccedil;&atilde;o</th>
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
            $('#tbl_fornec_vt').DataTable({
                "columns": [
                    {data: "fornecedor"},
                    {data: "status"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                retrieve         : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./fornecedor/buscarFornecedor')?>',
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