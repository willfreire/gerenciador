<?php
# Dados do Ocorrencia
$codigo        = isset($ocorr[0]->id_ocorrencia_pk) ? $ocorr[0]->id_ocorrencia_pk : "";
$nome          = isset($ocorr[0]->nome) ? $ocorr[0]->nome : "";
$cpf           = isset($ocorr[0]->cpf) ? $ocorr[0]->cpf : "";
$ocorr_motivo  = isset($ocorr[0]->ocorr_motivo) ? $ocorr[0]->ocorr_motivo : "";
$descricao     = isset($ocorr[0]->descricao) ? $ocorr[0]->descricao : "";
$email_retorno = isset($ocorr[0]->email_retorno) ? $ocorr[0]->email_retorno : "";
$ocorr_status  = isset($ocorr[0]->ocorr_status) ? $ocorr[0]->ocorr_status : "";
$dt_hr_cad     = isset($ocorr[0]->dt_hr_cad) ? date('d/m/Y', strtotime($ocorr[0]->dt_hr_cad)) : "";
?>

<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<script>
    $(document).ready(function(){
        // Buscar as respostas
        Ocorrencia.getRespostas();
    });
</script>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Ocorrencia -->
    <link rel="stylesheet" href="<?= base_url('assets/css/ocorrencia.css') ?>">

    <!-- JS Ocorrencia -->
    <script src="<?= base_url('scripts/js/ocorrencia.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Ocorr&ecirc;ncias
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./ocorrencia') ?>"><i class="fa fa-support" aria-hidden="true"></i> Ocorr&ecirc;ncias</a>
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
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$codigo?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Dt. Solicita&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dt_hr_cad?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Funcion&aacute;rio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Motivo</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$ocorr_motivo?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Descri&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$descricao?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail para Retorno</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><a href="mailto:<?=$email_retorno?>"><?=$email_retorno?></a></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$ocorr_status?></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-primary box-wrapper-resp" style="background-color: #3c8dbc; padding: 0 5px 5px 5px; color: #FFF;">
                                        <h4><strong>Respostas</strong></h4>
                                    </div>
                                </div>
                            </div>

                            <div id="resp_ocorrencias"></div>

                            <div class="row">
                                <div class="col-xs-12 text-center" style="padding: 0px;">
                                    <div class="box-footer">
                                        <input type="hidden" name="id_ocorrencia" id="id_ocorrencia" value="<?=$codigo?>">
                                        <button type="button" id="btn_add_comment" name="btn_add_comment" class="btn btn-success">Enviar Mensagem</button>
                                        <button type="button" id="btn_back_vt" name="btn_back_vt" class="btn btn-primary">Voltar</button>
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

        <div class="modal fade" id="modal_resp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="title_modal_resp"></h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="frm_resp" name="frm_resp">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="resposta">Resposta<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <textarea class="form-control" id="resposta" name="resposta" placeholder="Resposta" maxlength="1000" rows="5" required="true"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group align_center">
                                        <input type="hidden" name="cod_ocorrencia" id="cod_ocorrencia" value="<?=$codigo?>">
                                        <button type="submit" class="btn btn-success" name="cad_resp" id="alt_status">Salvar</button>
                                        <button type="reset" id="limpar" name="limpar" class="btn btn-primary" data-dismiss="modal" style="margin-left: 5px;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>