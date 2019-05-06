<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Fornecedor -->
    <link rel="stylesheet" href="<?=base_url('assets/css/fornecedor.css')?>">

    <!-- JS Fornecedor -->
    <script src="<?=base_url('scripts/js/fornecedor.js?cache=').time()?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Fornecedor
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./fornecedor') ?>"><i class="fa fa-building" aria-hidden="true"></i> Fornecedores</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-fornec">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>
                            
                            <form role="form" name="frm_cad_fornec_vt" id="frm_cad_fornec_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="nome_fornecedor">Fornecedor<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" placeholder="Fornecedor" maxlength="250" required="true" autofocus="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="status">Status<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" checked> <div class="radio-position">Ativo</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="2"> <div class="radio-position">Inativo</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_fornec_vt" name="btn_cad_fornec_vt" class="btn btn-success">Cadastrar</button>
                                    <button type="reset" id="limpar" name="limpar" class="btn btn-primary">Limpar</button>
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