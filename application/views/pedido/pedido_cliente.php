<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Pedido -->
    <link rel="stylesheet" href="<?= base_url('assets/css/pedido.css') ?>">

    <!-- JS Pedido -->
    <script src="<?= base_url('scripts/js/pedido.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php if ($this->session->userdata('user_vt')): ?>
            <?php require_once(APPPATH . '/views/menu_vt.php'); ?>
        <?php else: ?>
            <?php require_once(APPPATH . '/views/menu_client.php'); ?>
        <?php endif; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Selecionar Cliente
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./pedido') ?>"><i class="fa fa-list" aria-hidden="true"></i> Pedidos</a>
                    </li>
                    <li class="active">Solicitar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-pedido">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_selcliente" id="frm_cad_selcliente">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="id_empresa">ID - CNPJ - Raz&atilde;o Social<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="id_empresa" id="id_empresa" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($empresas)):
                                                            foreach ($empresas as $value):
                                                                echo "<option value='$value->id_empresa_pk'>$value->id_empresa_pk - $value->cnpj - $value->nome_razao</option>";
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
                                    <button type="submit" id="btn_cad_pedido" name="btn_cad_pedido" class="btn btn-primary">Prosseguir</button>
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