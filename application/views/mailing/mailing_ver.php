<?php
# Dados do mailing
$cnpj         = isset($mailing[0]->cnpj) ? $mailing[0]->cnpj : "";
$razao_social = isset($mailing[0]->razao_social) ? $mailing[0]->razao_social : "";
$endereco     = isset($mailing[0]->endereco) ? $mailing[0]->endereco : "";
$numero       = isset($mailing[0]->numero) ? $mailing[0]->numero : "";
$complemento  = isset($mailing[0]->complemento) ? $mailing[0]->complemento : "";
$bairro       = isset($mailing[0]->bairro) ? $mailing[0]->bairro : "";
$cep          = isset($mailing[0]->cep) ? $mailing[0]->cep : "";
$cidade       = isset($cidade[0]->cidade) ? $cidade[0]->cidade : "";
$estado       = isset($estado[0]->estado) ? $estado[0]->estado : "";
$telefone     = isset($mailing[0]->telefone) ? $mailing[0]->telefone : "";
$email        = isset($mailing[0]->email) ? $mailing[0]->email : "";
$site         = isset($mailing[0]->site) ? "<a href='http://{$mailing[0]->site}' target='_blank'>{$mailing[0]->site}</a>" : "";
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Mailing -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mailing.css') ?>">

    <!-- JS Mailing -->
    <script src="<?= base_url('scripts/js/mailing.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Mailing
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./mailing') ?>"><i class="fa fa-user" aria-hidden="true"></i> Mailings</a>
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
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CNPJ</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cnpj?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Raz&atilde;o Social</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$razao_social?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$endereco?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>N&uacute;mero</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$numero?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Complemento</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$complemento?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Bairro</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$bairro?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CEP</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cep?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Estado</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$estado?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cidade</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cidade?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Telefone</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$telefone?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Site</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$site?></div>
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