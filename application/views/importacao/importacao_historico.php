<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Importacao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/importacao.css') ?>">

    <!-- JS Importacao -->
    <script src="<?= base_url('scripts/js/importacao.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Hist&oacute;rico de Importa&ccedil;&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Hist&oacute;rico de Importa&ccedil;&atilde;o</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-import">

                            <div class="box-header with-border">
                                Lista ordenada pelo &uacute;ltimo upload de arquivo
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="info">
                                            <th class="col-xs-7 col-sm-7 col-md-8 col-lg-8">Nome do Arquivo</th>
                                            <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">Data de Upload</th>
                                            <th class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-center">Baixar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($arqs)): ?>
                                            <?php foreach ($arqs as $value): ?>
                                                <tr>
                                                    <td><?=$value->arquivo?></td>
                                                    <td class="text-center"><?=isset($value->dt_hr_importacao) ? date('d/m/Y H:i\h', strtotime($value->dt_hr_importacao)) : "Sem Data"?></td>
                                                    <td class="text-center">
                                                        <a href="<?=base_url('/assets/uploads/importacao/'.$value->arquivo)?>" download>
                                                            <button type="button" id="btn_ver_arq" name="btn_ver_arq" class="btn btn-primary"><i class='glyphicon glyphicon-save' aria-hidden='true'></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">Nenhuma Importa&ccedil;&atilde;o Realiazada</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>