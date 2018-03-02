<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Aviso -->
    <link rel="stylesheet" href="<?= base_url('assets/css/aviso.css') ?>">

    <!-- JS Aviso -->
    <script src="<?= base_url('scripts/js/aviso.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Todos Avisos
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./aviso/gerenciar') ?>"><i class="fa fa-warning" aria-hidden="true"></i> Avisos</a>
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-info box-wrapper-80">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2">Data</th>
                                                <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">T&iacute;tulo</th>
                                                <th class="col-xs-5 col-sm-5 col-md-6 col-lg-6">Descri&ccedil;&atilde;o</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($avisos)): ?>
                                                <?php foreach ($avisos as $value): ?>
                                                    <tr>
                                                        <td><?=$value->dt_cadastro?></td>
                                                        <td><?=$value->titulo?></td>
                                                        <td><?=$value->descricao?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3">Nenhum Aviso Cadastrado</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center" style="padding: 0px;">
                                        <div class="box-footer">
                                            <button type="button" id="btn_back_aviso" name="btn_back_aviso" class="btn btn-primary">Voltar</button>
                                        </div>
                                    </div>
                                </div>
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