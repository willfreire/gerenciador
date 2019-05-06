<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Funcionario -->
    <link rel="stylesheet" href="<?= base_url('assets/css/funcionario.css') ?>">

    <!-- JS Funcionario -->
    <script src="<?= base_url('scripts/js/funcionario.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gerenciamento de Funcion&aacute;rios
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Funcion&aacute;rios</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box-wrapper-btn">
                            <button class="btn btn-success" id="btn_cad_func_ger">Cadastrar Funcion&aacute;rio</button>
                        </div>
                        
                        <div class="box box-wrapper-100">

                            <div class="box-body">

                                <table id="tbl_func" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-2">
                                                Benef&iacute;cio Ativo<br>
                                                <a href="javascript:void(0)" onclick="Funcionario.statusFuncAll('<?=$this->session->userdata('id_client')?>', '1')">(Todos)</a> | 
                                                <a href="javascript:void(0)" onclick="Funcionario.statusFuncAll('<?=$this->session->userdata('id_client')?>', '2')">(Nenhum)</a>
                                            </th>
                                            <th>CPF</th>
                                            <th>Nome</th>
                                            <th>RG</th>
                                            <th>Matr&iacute;cula</th>
                                            <th>
                                                Per&iacute;odo<br>
                                                <?=$sel_periodo?>
                                            </th>
                                            <th>Status</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="col-lg-2">
                                                Benef&iacute;cio Ativo<br> 
                                                <a href="javascript:void(0)" onclick="Funcionario.statusFuncAll('<?=$this->session->userdata('id_client')?>', '1')">(Todos)</a> | 
                                                <a href="javascript:void(0)" onclick="Funcionario.statusFuncAll('<?=$this->session->userdata('id_client')?>', '2')">(Nenhum)</a>
                                            </th>
                                            <th>CPF</th>
                                            <th>Nome</th>
                                            <th>RG</th>
                                            <th>Matr&iacute;cula</th>
                                            <th>
                                                Per&iacute;odo<br>
                                                <?=$sel_periodo?>
                                            </th>
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
            $('#tbl_func').DataTable({
                "order": [[2, "asc"]],
                "columns": [
                    {data: "at_in", searchable: false, orderable: false},
                    {data: "cpf"},
                    {data: "nome"},
                    {data: "rg"},
                    {data: "matricula"},
                    {data: "periodo", searchable: false, orderable: false},
                    {data: "status"},
                    {data: "acao", searchable: false, orderable: false}
                ],
                "processing"     : true,
                "serverSide"     : true,
                "retrieve"       : true,
                "iDisplayLength" : 50,
                "stripeClasses"  : ['strip_grid_none', 'strip_grid'],
                "ajax": {
                    url  : '<?=base_url('./funcionario/buscarFuncionario')?>',
                    type : 'POST'
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
