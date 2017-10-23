<?php
# Dados do beneficio
$id            = isset($beneficio[0]->id_item_beneficio_pk) ? $beneficio[0]->id_item_beneficio_pk : "";
$id_grupo      = isset($beneficio[0]->id_grupo_fk) ? $beneficio[0]->id_grupo_fk : "";
$descricao     = isset($beneficio[0]->descricao) ? $beneficio[0]->descricao : "";
$vl_unitario   = isset($beneficio[0]->vl_unitario) ? number_format($beneficio[0]->vl_unitario, 2, ',', '.') : "0,00";
$id_modalidade = isset($beneficio[0]->id_modalidade_fk) ? $beneficio[0]->id_modalidade_fk : "";
$vl_rep_func   = isset($beneficio[0]->vl_rep_func) ? number_format($beneficio[0]->vl_rep_func, 2, ',', '.') : "0,00";
$vl_repasse    = isset($beneficio[0]->vl_repasse) ? $beneficio[0]->vl_repasse : "0.00";
$id_status     = isset($beneficio[0]->id_status_fk) ? $beneficio[0]->id_status_fk : "";
?>
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
                    Edi&ccedil;&atilde;o de Benef&iacute;cio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./beneficio') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Benef&iacute;cios</a>
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-benef">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_benef_vt" id="frm_edit_benef_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                                <label for="cod_benef">C&oacute;digo</label>
                                                <div class="controls">
                                                    <input type="text" id="cod_benef" name="cod_benef" value="<?=$id?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="grupo">Grupo<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="grupo" id="grupo" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($grupo)):
                                                            foreach ($grupo as $value):
                                                                $sel = $value->id_grupo_pk == $id_grupo ? 'selected="selected"' : '';
                                                                echo "<option value='$value->id_grupo_pk' $sel>$value->grupo</option>";
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
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="descricao">Descri&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descri&ccedil;&atilde;o" maxlength="250" required="true" autofocus="true" value="<?=$descricao?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-4">
                                                <label for="vl_unitario">Valor Unit&aacute;rio</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">R$</span>
                                                        <input type="text" class="form-control" id="vl_unitario" name="vl_unitario" placeholder="0,00" maxlength="10" value="<?=$vl_unitario?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                <label for="modalidade">Modalidade<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="modalidade" id="modalidade" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($modalidade)):
                                                            foreach ($modalidade as $value):
                                                                $sel = $value->id_modalidade_pk == $id_modalidade ? 'selected="selected"' : '';
                                                                echo "<option value='$value->id_modalidade_pk' $sel>$value->modalidade</option>";
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
                                            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-4">
                                                <label for="vl_repasse_func">Valor Repasse por Funcion&aacute;rio</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>R$</strong></span>
                                                        <input type="text" class="form-control" id="vl_repasse_func" name="vl_repasse_func" placeholder="0,00" maxlength="7" value="<?=$vl_rep_func?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">
                                                <label for="vl_repasse">Valor de Repasse</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="vl_repasse" name="vl_repasse" placeholder="0.00" maxlength="6" value="<?=$vl_repasse?>">
                                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="status">Status<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" <?=$id_status == "1" ? "checked='checked'" : ""?>> <div class="radio-position">Ativo</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="2" <?=$id_status == "2" ? "checked='checked'" : ""?>> <div class="radio-position">Inativo</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_beneficio" name="id_beneficio" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_benef_vt" name="btn_edit_benef_vt" class="btn btn-success">Alterar</button>
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