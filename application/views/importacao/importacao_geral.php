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
                    Importa&ccedil;&atilde;o de Arquivo
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-upload"></i> Importa&ccedil;&atilde;o</li>
                    <li class="active">Importa&ccedil;&atilde;o de Arquivo</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-import">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_import_vt" id="frm_cad_import_vt" enctype="multipart/form-data">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="arq_import">Selecione um Arquivo CSV<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="file" class="form-control" id="arq_import" name="arq_import" placeholder="Selecione..." required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_import_vt" name="btn_cad_import_vt" class="btn btn-success">Importar</button>
                                    <button type="reset" id="btn_back" name="limpar" class="btn btn-primary">Cancelar</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>