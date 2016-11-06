<?php
# Dados do mailing
$id           = isset($mailing[0]->id_mailing_pk) ? $mailing[0]->id_mailing_pk : "";
$cnpj         = isset($mailing[0]->cnpj) ? $mailing[0]->cnpj : "";
$razao_social = isset($mailing[0]->razao_social) ? $mailing[0]->razao_social : "";
$endereco     = isset($mailing[0]->endereco) ? $mailing[0]->endereco : "";
$numero       = isset($mailing[0]->numero) ? $mailing[0]->numero : "";
$complemento  = isset($mailing[0]->complemento) ? $mailing[0]->complemento : "";
$bairro       = isset($mailing[0]->bairro) ? $mailing[0]->bairro : "";
$cep          = isset($mailing[0]->cep) ? $mailing[0]->cep : "";
$id_cidade    = isset($mailing[0]->id_cidade_fk) ? $mailing[0]->id_cidade_fk : "";
$id_estado    = isset($mailing[0]->id_estado_fk) ? $mailing[0]->id_estado_fk : "";
$telefone     = isset($mailing[0]->telefone) ? $mailing[0]->telefone : "";
$email        = isset($mailing[0]->email) ? $mailing[0]->email : "";
$site         = isset($mailing[0]->site) ? $mailing[0]->site : "";
?>

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
                    Edi&ccedil;&atilde;o de Mailing
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./mailing') ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Mailings</a>
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-mail">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_mail_vt" id="frm_edit_mail_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="cnpj">CNPJ<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" maxlength="18" value="<?=$cnpj?>" required="true" autofocus="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="razao_social">Raz&atilde;o Social<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Raz&atilde;o Social" maxlength="250" required="true" value="<?=$razao_social?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="endereco">Endere&ccedil;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endere&ccedil;o" maxlength="250" required="true" value="<?=$endereco?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7 col-sm-5 col-md-5 col-lg-4">
                                                <label for="numero">N&uacute;mero<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="N&uacute;mero" maxlength="15" required="true" value="<?=$numero?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="complemento">Complemento</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento" maxlength="50" value="<?=$complemento?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="bairro">Bairro<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" maxlength="25" value="<?=$bairro?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7 col-sm-5 col-md-5 col-lg-4">
                                                <label for="cep">CEP<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" maxlength="9" required="true" value="<?=$cep?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                <label for="estado">Estado<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="estado" id="estado" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($estado)):
                                                            foreach ($estado as $value):
                                                                $sel = $value->id_estado_pk == $id_estado ? "selected='selected'" : "";
                                                                echo "<option value='$value->id_estado_pk' $sel>$value->estado</option>";
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
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                <label for="cidade">Cidade<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="cidade" id="cidade" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($cidade)):
                                                            foreach ($cidade as $value):
                                                                $sel = $value->id_cidade_pk == $id_cidade ? "selected='selected'" : "";
                                                                echo "<option value='$value->id_cidade_pk' $sel>$value->cidade</option>";
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
                                            <div class="col-xs-8 col-sm-5 col-md-5 col-lg-4">
                                                <label for="tel">Telefone<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="(ddd) + n&uacute;mero" maxlength="15" required="true" value="<?=$telefone?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="email">E-mail<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" maxlength="250" required="true" value="<?=$email?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="site">Site</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">http://</span>
                                                        <input type="text" class="form-control" id="site" name="site" placeholder="www.teste.com.br" maxlength="100" value="<?=$site?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_mailing" name="id_mailing" value="<?= $id ?>">
                                    <button type="submit" id="btn_edit_mail_vt" name="btn_edit_mail_vt" class="btn btn-primary">Alterar</button>
                                    <button type="button" id="btn_back" name="btn_back" class="btn btn-danger">Voltar</button>
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