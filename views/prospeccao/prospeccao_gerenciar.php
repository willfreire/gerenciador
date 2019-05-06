<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Prospeccao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/prospeccao.css') ?>">

        <!-- JS Prospeccao -->
    <script src="<?= base_url('scripts/js/prospeccao.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gerenciamento de Prospec&ccedil;&otilde;es
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-bar-chart" aria-hidden="true"></i> Prospec&ccedil;&otilde;es</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box-wrapper-btn">
                            <button class="btn btn-success" id="btn_cad_prosp">Cadastrar Prospec&ccedil;&atilde;o</button>
                        </div>

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_prospec_vt" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Benef&iacute;cio</th>
                                            <th>Contato</th>
                                            <th>Taxa</th>
                                            <th>Aceitou Proposta?</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Benef&iacute;cio</th>
                                            <th>Contato</th>
                                            <th>Taxa</th>
                                            <th>Aceitou Proposta?</th>
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
            $('#tbl_prospec_vt').DataTable({
                "columns": [
                    {data: "id_mailing_fk"},
                    {data: "razao_social"},
                    {data: "descricao"},
                    {data: "contato"},
                    {data: "taxa"},
                    {data: "aceitou_proposta"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                "retrieve"       : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?=base_url('./prospeccao/buscarProspeccao')?>',
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