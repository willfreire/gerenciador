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
                    Gerar Remessa
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-money" aria-hidden="true"></i> Financeiro</li>
                    <li class="active">Remessa</li>
                    <li class="active">Gerar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <form role="form" name="frm_cad_remessa" id="frm_cad_remessa">

                            <div class="box box-primary box-wrapper-80">

                                <div class="box-body">

                                    <div class="row" id="txt_sel_boleto">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <h4>Selecionar Boleto</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-8 col-lg-6">
                                            <label for="add_boleto">Id do Pedido / CNPJ / Cliente / Valor</label>
                                            <input type="text" class="form-control" id="add_boleto" name="add_boleto" placeholder="Buscar Boleto" maxlength="250">
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-4 col-lg-6">
                                            <button type="button" id="btn_add_boleto" name="btn_add_boleto" class="btn btn-success">Adicionar</button>
                                        </div>
                                    </div>

                                    <div class="row" id="txt_boleto_add">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <h4>Boletos Adicionados</h4>
                                        </div>
                                    </div>

                                    <div class="row" id="tbl_lista_bol">
                                        <div class="col-xs-12">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 10%">ID do Pedido</th>
                                                    <th style="width: 30%">CNPJ</th>
                                                    <th style="width: 35%">Cliente</th>
                                                    <th class="text-center" style="width: 15%;">Valor</th>
                                                    <th class="text-center" style="width: 10%;">A&ccedil;&atilde;o</th>
                                                </tr>
                                                <tbody id="tbl_boletos">
                                                    <tr id="sem_boleto">
                                                        <td colspan="5">Nenhum Boleto Adicionado</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_proximo" name="btn_proximo" class="btn btn-success">Prosseguir</button>
                                    <button type="reset" id="cancel" name="cancel" class="btn btn-primary">Cancelar</button>
                                </div>
                                <!-- /.box-body -->
                            </div>

                        </form>

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
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "iDisplayLength": 50,
                "stripeClasses": ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url: '<?= base_url('./financeiro/buscarBoleto') ?>',
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