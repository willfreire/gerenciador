<?php
# Dados do beneficio
$id          = isset($beneficio[0]->id_item_beneficio_pk) ? $beneficio[0]->id_item_beneficio_pk : "";
$grupo       = isset($beneficio[0]->grupo) ? $beneficio[0]->grupo : "";
$descricao   = isset($beneficio[0]->descricao) ? $beneficio[0]->descricao : "";
$vl_unitario = isset($beneficio[0]->vl_unitario) ? number_format($beneficio[0]->vl_unitario, 2, ',', '.') : "0,00";
$modalidade  = isset($beneficio[0]->modalidade) ? $beneficio[0]->modalidade : "";
$vl_repasse  = isset($beneficio[0]->vl_repasse) ? $beneficio[0]->vl_repasse : "0.00";
$vl_rep_func = isset($beneficio[0]->vl_rep_func) ? number_format($beneficio[0]->vl_rep_func, 2, ',', '.') : "0,00";
$status      = isset($beneficio[0]->status) ? $beneficio[0]->status : "";
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Beneficio -->
    <link rel="stylesheet" href="<?= base_url('assets/css/beneficio.css') ?>">

    <!-- JS Beneficio -->
    <script src="<?= base_url('scripts/js/beneficio.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Benef&iacute;cio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./beneficio') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Benef&iacute;cios</a>
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>C&oacute;digo</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$id?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Grupo</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$grupo?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Descri&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$descricao?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Valor Unit&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">R$ <?=$vl_unitario?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Modalidade</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$modalidade?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Valor de Repasse por Funcion&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">R$ <?=$vl_rep_func?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Valor de Repasse</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$vl_repasse?> %</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$status?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center" style="padding: 0px;">
                                        <div class="box-footer">
                                            <button type="button" id="btn_back" name="btn_back" class="btn btn-primary">Voltar</button>
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