<?php
# Dados do aviso
$id        = isset($aviso[0]->id_quadro_aviso_pk) ? $aviso[0]->id_quadro_aviso_pk : "";
$titulo    = isset($aviso[0]->titulo) ? $aviso[0]->titulo : "";
$descricao = isset($aviso[0]->descricao) ? $aviso[0]->descricao : "";
?>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Aviso -->
    <link rel="stylesheet" href="<?=base_url('assets/css/aviso.css')?>">

    <!-- JS Aviso -->
    <script src="<?=base_url('scripts/js/aviso.js')?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edi&ccedil;&atilde;o de Aviso
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./aviso/gerenciar') ?>"><i class="fa fa-warning" aria-hidden="true"></i> Avisos</a>
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-aviso">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_aviso" id="frm_edit_aviso">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="titulo">T&iacute;tulo<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="T&iacute;tulo" maxlength="250" required="true" autofocus="true" value="<?=$titulo?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="descricao">Descri&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descri&ccedil;&atilde;o" rows="4" required="true"><?=$descricao?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_aviso" name="id_aviso" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_aviso" name="btn_edit_aviso" class="btn btn-success">Alterar</button>
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