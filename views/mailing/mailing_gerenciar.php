<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Mailing -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mailing.css') ?>">

    <!-- JS Mailing -->
    <script src="<?= base_url('scripts/js/mailing.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gerenciamento de Mailings
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Mailings</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box-wrapper-btn">
                            <button class="btn btn-success" id="btn_cad_mail">Cadastrar Mailing</button>
                        </div>

                        <div class="box box-wrapper-80">

                            <div class="box-body">

                                <table id="tbl_mail_vt" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>CNPJ</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Telefone</th>
                                            <th>E-mail</th>
                                            <th>Data de Prospec&ccedil;&atilde;o</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>CNPJ</th>
                                            <th>Raz&atilde;o Social</th>
                                            <th>Telefone</th>
                                            <th>E-mail</th>
                                            <th>Data de Prospec&ccedil;&atilde;o</th>
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

        <div class="modal fade" id="modal_prospec">
            <div class="modal-dialog" id="modal-dialog-prospec">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="title_modal_prospec"></h4>
                    </div>
                    <div class="modal-body">
                        <iframe name="frme_prospec" id="frme_prospec" src=""></iframe>
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
            $('#tbl_mail_vt').DataTable({
                "order": [[5, "asc"]],
                "columns": [
                    {data: "id_mailing_pk"},
                    {data: "cnpj"},
                    {data: "razao_social"},
                    {data: "telefone"},
                    {data: "email"},
                    {data: "dt_atende"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "iDisplayLength": 50,
                "stripeClasses": ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?= base_url('./mailing/buscarMailing') ?>',
                    type: 'POST'
                },
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ Resultados por Página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });

        });
    </script>