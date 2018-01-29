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
                    Visualiza&ccedil;&atilde;o de Boletos
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-money" aria-hidden="true"></i> Financeiro</li>
                    <li class="active">Boletos</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_boleto_vt" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID do Pedido</th>
                                            <th>CNPJ</th>
                                            <th>Cliente</th>
                                            <th>Valor</th>
                                            <th>Dt. Vencimento</th>
                                            <th>Dt. Pagamento</th>
                                            <th>Status</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID do Pedido</th>
                                            <th>CNPJ</th>
                                            <th>Cliente</th>
                                            <th>Valor</th>
                                            <th>Dt. Vencimento</th>
                                            <th>Dt. Pagamento</th>
                                            <th>Status</th>
                                            <th>Ver</th>
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
            $('#tbl_boleto_vt').DataTable({
                "columns": [
                    {data: "id_pedido_fk"},
                    {data: "sacado_cnpj_cpf"},
                    {data: "sacado_nome"},
                    {data: "valor"},
                    {data: "dt_vencimento"},
                    {data: "dt_pgto"},
                    {data: "status_boleto"},
                    {data: "ver", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                "retrieve"       : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./financeiro/buscarBoleto')?>',
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