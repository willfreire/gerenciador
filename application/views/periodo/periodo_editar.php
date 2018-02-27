<?php
# Dados do Periodo
$id      = isset($periodo[0]->id_periodo_pk) ? $periodo[0]->id_periodo_pk : "";
$period  = isset($periodo[0]->periodo) ? $periodo[0]->periodo : "";
$qtd_dia = isset($periodo[0]->qtd_dia) ? $periodo[0]->qtd_dia : "";
?>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Periodo -->
    <link rel="stylesheet" href="<?=base_url('assets/css/periodo.css')?>">

    <!-- JS Periodo -->
    <script src="<?=base_url('scripts/js/periodo.js')?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edi&ccedil;&atilde;o de Per&iacute;odo
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./periodo') ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Per&iacute;odos</a>
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-period">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>
                            
                            <form role="form" name="frm_edit_period" id="frm_edit_period">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                <label for="nome_periodo">Per&iacute;odo<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_periodo" name="nome_periodo" placeholder="Per&iacute;odo" maxlength="20" required="true" autofocus="true" value="<?=$period?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                                                <label for="qtd_dia">Quantidade Di&aacute;ria<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="qtd_dia" name="qtd_dia" placeholder="0" maxlength="2" required="true" value="<?=$qtd_dia?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_periodo" name="id_periodo" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_period" name="btn_edit_period" class="btn btn-success">Alterar</button>
                                    <button type="button" id="btn_back" name="btn_back" class="btn btn-primary">Voltar</button>
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