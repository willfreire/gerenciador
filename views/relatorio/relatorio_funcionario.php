<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Relatorio -->
    <link rel="stylesheet" href="<?= base_url('assets/css/relatorio.css') ?>">

    <!-- JS Relatorio -->
    <script src="<?= base_url('scripts/js/relatorio.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Relat&oacute;rio de Funcion&aacute;rios
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active"><i class="fa fa-database"></i> Relat&oacute;rio</li>
                    <li class="active">Relat&oacute;rio de Funcion&aacute;rios</li>
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

                            <form role="form" name="frm_rel_func" id="frm_rel_func">

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

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                <label for="id_depto">Departamento</label>
                                                <div class="controls">
                                                    <select class="form-control" name="id_depto" id="id_depto">
                                                        <option value="">Todos</option>
                                                        <?php
                                                        if (is_array($deptos)):
                                                            foreach ($deptos as $value):
                                                                echo "<option value='$value->id_departamento_fk'>$value->departamento</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                <label for="periodo">Per&iacute;odo de Utiliza&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" name="periodo" id="periodo" placeholder="dd/mm/aaaa - dd/mm/aaaa" value="" maxlength="23" readonly required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_rel_func" name="btn_rel_func" class="btn btn-success">Exportar</button>
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