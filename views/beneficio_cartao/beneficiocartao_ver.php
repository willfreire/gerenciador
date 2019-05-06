<?php
# Dados
$id       = isset($benefcard[0]->id_beneficio_pk) ? $benefcard[0]->id_beneficio_pk : "";
$func     = isset($benefcard[0]->nome) ? $benefcard[0]->nome : "";
$grupo    = isset($benefcard[0]->grupo) ? $benefcard[0]->grupo : "";
$item     = isset($benefcard[0]->descricao) ? $benefcard[0]->descricao : "";
$id_benef = isset($benefcard[0]->id_item_beneficio_fk) ? $benefcard[0]->id_item_beneficio_fk : "";
$vl_unit  = isset($benefcard[0]->vl_unitario) ? number_format($benefcard[0]->vl_unitario, 2, ',', '.') : "0,00";
$qtd_dia  = isset($benefcard[0]->qtd_diaria) ? $benefcard[0]->qtd_diaria : "";
$num_card = isset($benefcard[0]->num_cartao) ? $benefcard[0]->num_cartao : "";
$status   = isset($benefcard[0]->status_cartao) ? $benefcard[0]->status_cartao : "";
?>

<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Beneficio/Cartao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/beneficio_cartao.css') ?>">

    <!-- JS Beneficio/Cartao -->
    <script src="<?= base_url('scripts/js/beneficio_cartao.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Benef&iacute;cio - Cart&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./beneficiocartao/gerenciar') ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Benef&iacute;cios - Cart&otilde;es</a>
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
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Funcion&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$func?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Grupo</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$grupo?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Benef&iacute;cio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$id_benef.' - '.$item?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Valor Unit&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">R$ <?=$vl_unit?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Quantidade de Dias</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$qtd_dia?></div>
                                </div>
                                <?php if ($num_card != ""): ?>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>N&ordm; do Cart&atilde;o</strong></div>
                                        <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$num_card?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status do Cart&atilde;o</strong></div>
                                        <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$status?></div>
                                    </div>
                                <?php endif; ?>
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