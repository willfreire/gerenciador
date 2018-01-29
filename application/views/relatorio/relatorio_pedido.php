<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Relatorio -->
    <link rel="stylesheet" href="<?= base_url('assets/css/relatorio.css') ?>">

    <!-- JS Relatorio -->
    <script src="<?= base_url('scripts/js/relatorio.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Relat&oacute;rio de Pedidos
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-database"></i> Relat&oacute;rio</li>
                    <li class="active">Relat&oacute;rio de Pedidos</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-import">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com sele&ccedil;&atilde;o obrigat&oacute;ria
                            </div>

                            <form role="form" name="frm_rel_ped" id="frm_rel_ped">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                <label for="id_pedido">Pedido<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="id_pedido" id="id_pedido">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($pedidos)):
                                                            foreach ($pedidos as $value):
                                                                echo "<option value='$value->id_pedido_pk'>$value->id_pedido_pk</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_rel_ped" name="btn_rel_ped" class="btn btn-success">Exportar</button>
                                    <button type="reset" id="btn_reset" name="limpar" class="btn btn-primary">Limpar</button>
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