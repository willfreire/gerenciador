<?php
# Dados do prospeccao
$id                  = isset($prospeccao[0]->id_prospeccao_pk) ? $prospeccao[0]->id_prospeccao_pk : "";
$mailing_razao       = isset($mailing[0]->razao_social) ? $mailing[0]->razao_social : "";
$beneficio           = isset($item_beneficio[0]->descricao) ? $item_beneficio[0]->descricao : "";
$fornec              = isset($fornecedor[0]->fornecedor) ? $fornecedor[0]->fornecedor : "";
$meio_soc            = isset($meio_social[0]->meio_social) ? $meio_social[0]->meio_social : "";
$dist_benef          = isset($dist_beneficio[0]->dist_beneficio) ? $dist_beneficio[0]->dist_beneficio : "";
$ativ                = isset($atividade[0]->ramo_atividade) ? $atividade[0]->ramo_atividade : "";
$id_muda_fornec      = isset($prospeccao[0]->id_muda_fornec_fk) ? $prospeccao[0]->id_muda_fornec_fk : "";
$muda_fornec         = isset($muda_fornecedor[0]->mudaria_fornecedor) ? $muda_fornecedor[0]->mudaria_fornecedor : "";
$muda_fornec_outro   = isset($prospeccao[0]->muda_fornec_outro) ? $prospeccao[0]->muda_fornec_outro : "";
$id_nao_interesse    = isset($prospeccao[0]->id_nao_interesse_fk) ? $prospeccao[0]->id_nao_interesse_fk : "";
$nao_inter           = isset($nao_interesse[0]->nao_interesse) ? $nao_interesse[0]->nao_interesse : "";
$nao_interesse_outro = isset($prospeccao[0]->nao_interesse_outro) ? $prospeccao[0]->nao_interesse_outro : "";
$contato             = isset($prospeccao[0]->contato) ? $prospeccao[0]->contato : "";
$taxa                = isset($prospeccao[0]->taxa) ? $prospeccao[0]->taxa : "0.00";
$aceitou_proposta    = isset($prospeccao[0]->aceitou_proposta) && $prospeccao[0]->aceitou_proposta === "s" ? "Sim" : ($prospeccao[0]->aceitou_proposta === "e" ? "Em Negocia&ccedil;&atilde;o" : "N&atilde;o");
$observacao          = isset($prospeccao[0]->observacao) ? $prospeccao[0]->observacao : "";
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
                    Visualiza&ccedil;&atilde;o de Prospec&ccedil;&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./prospeccao') ?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Prospec&ccedil;&otilde;es</a>
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
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Empresa (Mailing)</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$mailing_razao?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Benef&iacute;cio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$beneficio?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Fornecedor</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$fornec?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Como Conheceu a VTCARDS?</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$meio_soc?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Distribui&ccedil;&atilde;o do Benef&iacute;cio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dist_benef?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Ramo de Atividade</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$ativ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Mudaria de Fornecedor?</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$muda_fornec?></div>
                                </div>
                                <?php if ($id_muda_fornec == "4"): ?>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Outros Motivos para Mudan&ccedil;a de Fornecedor</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$muda_fornec_outro?></div>
                                </div>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Motivo N&atilde;o Interesse</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nao_inter?></div>
                                </div>
                                <?php if ($id_nao_interesse == "6"): ?>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Outros Motivos do N&atilde;o Interesse</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nao_interesse_outro?></div>
                                </div>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Contato</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$contato?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Taxa Negociada</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$taxa?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Proposta Aceita?</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$aceitou_proposta?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Observa&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$observacao?></div>
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