<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Pedido -->
    <link rel="stylesheet" href="<?= base_url('assets/css/pedido.css') ?>">

    <!-- JS Pedido -->
    <script src="<?= base_url('scripts/js/pedido.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Acompanhamento de Pedidos
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-list" aria-hidden="true"></i> Pedidos</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_pedido" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>CNPJ</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Data de Pagamento</th>
                                            <th>Per&iacute;odo</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>CNPJ</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Data de Pagamento</th>
                                            <th>Per&iacute;odo</th>
                                            <th>Valor</th>
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
            $('#tbl_pedido').DataTable({
                "order": [[ 2, "desc" ]],
                "columns": [
                    {data: "cnpj"},
                    {data: "nome_razao"},
                    {data: "dt_pgto"},
                    {data: "periodo", searchable: false, orderable: false},
                    {data: "vl_total"},
                    {data: "status_pedido"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                "retrieve"       : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./pedido/buscarPedidoAcompanha')?>',
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