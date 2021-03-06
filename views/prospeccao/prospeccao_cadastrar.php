<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Prospeccao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/prospeccao.css') ?>">

    <!-- JS Prospeccao -->
    <script src="<?= base_url('scripts/js/prospeccao.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Prospec&ccedil;&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./prospeccao') ?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Prospec&ccedil;&otilde;es</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-prospec">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_prospec_vt" id="frm_cad_prospec_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="time">Tempo de Atendimento</label>
                                                <div class="controls">
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-9 col-md-5 col-lg-5">
                                                            <input type="text" class="form-control" name="time" id="time" value="" maxlength="8" readonly>
                                                        </div>
                                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                            <div class="btn btn-success" id="btn_start" title="Continuar"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></div>
                                                            <div class="btn btn-danger" id="btn_stop" title="Pausar"><span class="glyphicon glyphicon-pause" aria-hidden="true"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="mailing">Empresa (Mailing)<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="mailing" id="mailing" required="true" autofocus="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($mailing)):
                                                            foreach ($mailing as $value):
                                                                echo "<option value='$value->id_mailing_pk'>$value->id_mailing_pk - $value->razao_social</option>";
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
                                                <label for="item_beneficio">Benef&iacute;cios<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="item_beneficio" id="item_beneficio" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($item_beneficio)):
                                                            foreach ($item_beneficio as $value):
                                                                echo "<option value='$value->id_item_beneficio_pk'>$value->id_item_beneficio_pk - $value->descricao</option>";
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
                                                <label for="fornecedor">Fornecedor<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="fornecedor" id="fornecedor" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($fornecedor)):
                                                            foreach ($fornecedor as $value):
                                                                echo "<option value='$value->id_fornecedor_pk'>$value->fornecedor</option>";
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
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="meio_social">Como Conheceu a VTCARDS?<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <?php
                                                    if (is_array($meio_social)):
                                                        foreach ($meio_social as $value):
                                                            echo "<label class='radio-inline'>
                                                                    <input type='radio' name='meio_social' id='meio_social' value='{$value->id_meio_social_pk}'> <div class='radio-position'>{$value->meio_social}</div>
                                                                </label>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                <label for="dist_beneficio">Distribui&ccedil;&atilde;o do Benef&iacute;cio</label>
                                                <div class="controls">
                                                    <select class="form-control" name="dist_beneficio" id="dist_beneficio">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($dist_beneficio)):
                                                            foreach ($dist_beneficio as $value):
                                                                echo "<option value='$value->id_dist_beneficio_pk'>$value->dist_beneficio</option>";
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
                                                <label for="atividade">Ramo de Atividade<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="atividade" id="atividade" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($atividade)):
                                                            foreach ($atividade as $value):
                                                                echo "<option value='$value->id_ramo_atividade_pk'>$value->ramo_atividade</option>";
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
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="muda_fornecedor">Mudaria de Fornecedor?</label>
                                                <div class="controls">
                                                    <?php
                                                    if (is_array($muda_fornecedor)):
                                                        foreach ($muda_fornecedor as $value):
                                                            echo "<label class='radio-inline'>
                                                                    <input type='radio' name='muda_fornecedor' id='muda_fornecedor_{$value->id_muda_fornec_pk}' value='{$value->id_muda_fornec_pk}'> <div class='radio-position'>{$value->mudaria_fornecedor}</div>
                                                                </label>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group hidden" id="row_muda_fornec">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="muda_fornec_outro">Outros Motivos para Mudan&ccedil;a de Fornecedor</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="muda_fornec_outro" name="muda_fornec_outro" placeholder="Outros Motivos" maxlength="250">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="nao_interesse">Motivo N&atilde;o Interesse</label>
                                                <div class="controls">
                                                    <?php
                                                    if (is_array($nao_interesse)):
                                                        foreach ($nao_interesse as $value):
                                                            echo "<label class='radio-inline'>
                                                                    <input type='radio' name='nao_interesse' id='nao_interesse_{$value->id_nao_interesse_pk}' value='{$value->id_nao_interesse_pk}'> <div class='radio-position'>{$value->nao_interesse}</div>
                                                                </label>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group hidden" id="row_nao_interesse">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="nao_interesse_outro">Outros Motivos do N&atilde;o Interesse</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nao_interesse_outro" name="nao_interesse_outro" placeholder="Outros Motivos do N&atilde;o Interesse" maxlength="250">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="contato">Contato<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="contato" name="contato" placeholder="Contato" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">
                                                <label for="taxa_adm">Taxa Negociada</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control vl_percent" id="taxa_adm" name="taxa_adm" placeholder="0.00" maxlength="6" value="0.00">
                                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                                <label for="aceitou_proposta">Proposta Aceita?<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="s"> <div class="radio-position">Sim</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="n"> <div class="radio-position">N&atilde;o</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="e"> <div class="radio-position">Em Negocia&ccedil;&atilde;o</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="i"> <div class="radio-position">Empresa Inexistente</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
                                                <label for="dt_retorno">Data de Retorno</label>
                                                <div class="controls">
                                                    <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_retorno" id="dt_retorno" placeholder="dd/mm/aaaa" value="" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="obs">Observa&ccedil;&atilde;o</label>
                                                <div class="controls">
                                                    <textarea class="form-control" id="obs" name="obs" placeholder="Observa&ccedil;&atilde;o" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_prospec_vt" name="btn_cad_prospec_vt" class="btn btn-success">Cadastrar</button>
                                    <button type="reset" id="limpar" name="limpar" class="btn btn-primary">Limpar</button>
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