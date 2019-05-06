<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Quadro de Avisos
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('./main/dashboard_client') ?>"><i class="fa fa-dashboard"></i> Quadro de Avisos</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                        
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">&Uacute;ltimos Avisos</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2">Data</th>
                                                <th class="col-xs-9 col-sm-9 col-md-10 col-lg-10">T&iacute;tulo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($avisos)): ?>
                                                <?php foreach ($avisos as $value): ?>
                                                    <tr>
                                                        <td><?=$value->dt_cadastro?></td>
                                                        <td><a href="javascript:void(0)" onclick="Main.verAviso('<?=$value->id_quadro_aviso_pk?>')"><?=$value->titulo?></a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2">Nenhum Aviso Cadastrado</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <a href="<?=base_url('./aviso/verTodos')?>" class="btn btn-sm btn-default btn-flat pull-right">Visualizar Todos Avisos</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>

                    </div>

                </div>

            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>