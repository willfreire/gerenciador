<?php
# Dados do Roteirizacao
$id               = isset($roteiriza[0]->id_roteirizacao_pk) ? $roteiriza[0]->id_roteirizacao_pk : "";
$cnpj             = isset($roteiriza[0]->cnpj) ? $roteiriza[0]->cnpj : "";
$nome_razao       = isset($roteiriza[0]->nome_razao) ? $roteiriza[0]->nome_razao : "";
$status           = isset($roteiriza[0]->status_roteiriza) ? $roteiriza[0]->status_roteiriza : "";
$cep_empr         = isset($roteiriza[0]->cep_empr) ? $roteiriza[0]->cep_empr : "";
$logradouro_empr  = isset($roteiriza[0]->logradouro_empr) ? $roteiriza[0]->logradouro_empr : "";
$numero_empr      = isset($roteiriza[0]->numero_empr) ? $roteiriza[0]->numero_empr : "";
$complemento_empr = isset($roteiriza[0]->complemento_empr) ? $roteiriza[0]->complemento_empr : "";
$bairro_empr      = isset($roteiriza[0]->bairro_empr) ? $roteiriza[0]->bairro_empr : "";
$estado_empr      = isset($roteiriza[0]->estado_empr) ? $roteiriza[0]->estado_empr : "";
$cidade_empr      = isset($roteiriza[0]->cidade_empr) ? $roteiriza[0]->cidade_empr : "";
$cpf              = isset($roteiriza[0]->cpf) ? $roteiriza[0]->cpf : "";
$nome             = isset($roteiriza[0]->nome) ? $roteiriza[0]->nome : "";
$cep              = isset($roteiriza[0]->nome) ? $roteiriza[0]->cep : "";
$logradouro       = isset($roteiriza[0]->logradouro) ? $roteiriza[0]->logradouro : "";
$numero           = isset($roteiriza[0]->numero) ? $roteiriza[0]->numero : "";
$complemento      = isset($roteiriza[0]->complemento) ? $roteiriza[0]->complemento : "";
$bairro           = isset($roteiriza[0]->bairro) ? $roteiriza[0]->bairro : "";
$estado           = isset($roteiriza[0]->estado) ? $roteiriza[0]->estado : "";
$cidade           = isset($roteiriza[0]->cidade) ? $roteiriza[0]->cidade : "";
$dt_hr            = isset($roteiriza[0]->dt_hr) ? $roteiriza[0]->dt_hr : "";
$arquivo          = isset($roteiriza[0]->dt_hr) ? $roteiriza[0]->arquivo : "";
$arquivo          = isset($roteiriza[0]->dt_hr) ? $roteiriza[0]->arquivo : "";
$dt_hr_usuario    = isset($roteiriza[0]->dt_hr_usuario) ? $roteiriza[0]->dt_hr_usuario : "";
?>

<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Roteirizacao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/roteirizacao.css') ?>">

    <!-- JS Roteirizacao -->
    <script src="<?= base_url('scripts/js/roteirizacao.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Roteiriza&ccedil;&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./roteirizacao/historico') ?>"><i class="fa fa-map" aria-hidden="true"></i> Roteiriza&ccedil;&atilde;o</a>
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-90">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>N&ordm; da Roteiriza&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$id?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status da Roteiriza&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$status?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Solicita&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dt_hr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Resposta</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dt_hr_usuario?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Carta de Roteiriza&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">
                                        <?php if ($arquivo != ""): ?>
                                        <a href="<?=base_url("./assets/roteirizacao/$arquivo")?>" target="_blank">Ver Carta</a>
                                        <?php else: ?>
                                        Sem Anexo
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; font-size: 18px; font-weight: bold"><div style="background-color: #CCC">Dados do Cliente</div></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CNPJ</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cnpj?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cliente</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome_razao?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CEP</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cep_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$logradouro_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>N&uacute;mero</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$numero_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Complemento</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$complemento_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Bairro</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$bairro_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Estado</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$estado_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cidade</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cidade_empr?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; font-size: 18px; font-weight: bold"><div style="background-color: #CCC">Dados do Funcion&aacute;rio</div></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CPF</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cpf?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Funcion&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CEP</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cep?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$logradouro?></div>
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
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Estado</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$estado?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cidade</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cidade?></div>
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
