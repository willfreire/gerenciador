<?php
# Dados do prospeccao
$id                  = isset($prospeccao[0]->id_prospeccao_pk) ? $prospeccao[0]->id_prospeccao_pk : "";
$id_mailing          = isset($prospeccao[0]->id_mailing_fk) ? $prospeccao[0]->id_mailing_fk : $prospec_mail;
$id_item_beneficio   = isset($prospeccao[0]->id_item_beneficio_fk) ? $prospeccao[0]->id_item_beneficio_fk : "";
$id_fornecedor       = isset($prospeccao[0]->id_fornecedor_fk) ? $prospeccao[0]->id_fornecedor_fk : "";
$id_meio_social      = isset($prospeccao[0]->id_meio_social_fk) ? $prospeccao[0]->id_meio_social_fk : "";
$id_dist_beneficio   = isset($prospeccao[0]->id_dist_beneficio_fk) ? $prospeccao[0]->id_dist_beneficio_fk : "";
$id_ramo_atividade   = isset($prospeccao[0]->id_ramo_atividade_fk) ? $prospeccao[0]->id_ramo_atividade_fk : "";
$id_muda_fornec      = isset($prospeccao[0]->id_muda_fornec_fk) ? $prospeccao[0]->id_muda_fornec_fk : "";
$muda_fornec_outro   = isset($prospeccao[0]->muda_fornec_outro) ? $prospeccao[0]->muda_fornec_outro : "";
$id_nao_interesse    = isset($prospeccao[0]->id_nao_interesse_fk) ? $prospeccao[0]->id_nao_interesse_fk : "";
$nao_interesse_outro = isset($prospeccao[0]->nao_interesse_outro) ? $prospeccao[0]->nao_interesse_outro : "";
$contato             = isset($prospeccao[0]->contato) ? $prospeccao[0]->contato : "";
$taxa                = isset($prospeccao[0]->taxa) ? $prospeccao[0]->taxa : "0.00";
$aceitou_proposta    = isset($prospeccao[0]->aceitou_proposta) ? $prospeccao[0]->aceitou_proposta : "";
$dt_retorno          = isset($prospeccao[0]->dt_retorno) ? explode("-", $prospeccao[0]->dt_retorno) : "";
$observacao          = isset($prospeccao[0]->observacao) ? $prospeccao[0]->observacao : "";
?>
<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Prospeccao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/prospeccao.css') ?>">

    <!-- JS Prospeccao -->
    <script src="<?= base_url('scripts/js/prospeccao.js?cache=').time() ?>"></script>

    <div class="wrapper" style="background-color: #F8F8F8">

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-xs-12">

                    <div class="container-fluid box box-primary" id="box-frm-prospec">

                        <div class="box-header with-border">
                            <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                        </div>

                        <form role="form" name="frm_cadedit_prospec_vt" id="frm_cadedit_prospec_vt">

                            <div class="box-body">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                            <label for="time">Tempo de Atendimento</label>
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-xs-9 col-sm-9 col-md-4 col-lg-3">
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
                                            <input type="hidden" id="id_mailing" name="id_mailing" value="<?=$id_mailing?>">
                                            <div class="controls">
                                                <select class="form-control select2" name="mailing" id="mailing" required="true" autofocus="true">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    if (is_array($mailing)):
                                                        foreach ($mailing as $value):
                                                            $sel = $id_mailing == $value->id_mailing_pk ? "selected='selected'" : "";
                                                            echo "<option value='$value->id_mailing_pk' $sel>$value->id_mailing_pk - $value->razao_social</option>";
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
                                                            $sel = $id_item_beneficio == $value->id_item_beneficio_pk ? "selected='selected'" : "";
                                                            echo "<option value='$value->id_item_beneficio_pk' $sel>$value->id_item_beneficio_pk - $value->descricao</option>";
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
                                                            $sel = $id_fornecedor == $value->id_fornecedor_pk ? "selected='selected'" : "";
                                                            echo "<option value='$value->id_fornecedor_pk' $sel>$value->fornecedor</option>";
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
                                                        $check = $id_meio_social == $value->id_meio_social_pk ? "checked='checked'" : "";
                                                        echo "<label class='radio-inline'>
                                                                    <input type='radio' name='meio_social' id='meio_social' value='{$value->id_meio_social_pk}' $check> <div class='radio-position'>{$value->meio_social}</div>
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
                                                            $sel = $id_dist_beneficio == $value->id_dist_beneficio_pk ? "selected='selected'" : "";
                                                            echo "<option value='$value->id_dist_beneficio_pk' $sel>$value->dist_beneficio</option>";
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
                                                            $sel = $id_ramo_atividade == $value->id_ramo_atividade_pk ? "selected='selected'" : "";
                                                            echo "<option value='$value->id_ramo_atividade_pk' $sel>$value->ramo_atividade</option>";
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
                                                        $check = $id_muda_fornec == $value->id_muda_fornec_pk ? "checked='checked'" : "";
                                                        echo "<label class='radio-inline'>
                                                                    <input type='radio' name='muda_fornecedor' id='muda_fornecedor_{$value->id_muda_fornec_pk}' value='{$value->id_muda_fornec_pk}' $check> <div class='radio-position'>{$value->mudaria_fornecedor}</div>
                                                                </label>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group <?=$id_muda_fornec == "4" ? '' : 'hidden' ?>" id="row_muda_fornec">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <label for="muda_fornec_outro">Outros Motivos para Mudan&ccedil;a de Fornecedor</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="muda_fornec_outro" name="muda_fornec_outro" placeholder="Outros Motivos" maxlength="250" value="<?=$muda_fornec_outro?>">
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
                                                        $check = $id_nao_interesse == $value->id_nao_interesse_pk ? "checked='checked'" : "";
                                                        echo "<label class='radio-inline'>
                                                                    <input type='radio' name='nao_interesse' id='nao_interesse_{$value->id_nao_interesse_pk}' value='{$value->id_nao_interesse_pk}' $check> <div class='radio-position'>{$value->nao_interesse}</div>
                                                                </label>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group <?=$id_nao_interesse == "6" ? '' : 'hidden' ?>" id="row_nao_interesse">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <label for="nao_interesse_outro">Outros Motivos do N&atilde;o Interesse</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="nao_interesse_outro" name="nao_interesse_outro" placeholder="Outros Motivos do N&atilde;o Interesse" maxlength="250" value="<?=$nao_interesse_outro?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <label for="contato">Contato<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="contato" name="contato" placeholder="Contato" maxlength="250" required="true" value="<?=$contato?>">
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
                                                    <input type="text" class="form-control vl_percent" id="taxa_adm" name="taxa_adm" placeholder="0.00" maxlength="6" value="<?=$taxa?>">
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
                                                    <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="s" <?=$aceitou_proposta == "s" ? "checked='checked'" : ""?>> <div class="radio-position">Sim</div>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="n" <?=$aceitou_proposta == "n" ? "checked='checked'" : ""?>> <div class="radio-position">N&atilde;o</div>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="e" <?=$aceitou_proposta == "e" ? "checked='checked'" : ""?>> <div class="radio-position">Em Negocia&ccedil;&atilde;o</div>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="aceitou_proposta" id="aceitou_proposta" value="i" <?=$aceitou_proposta == "i" ? "checked='checked'" : ""?>> <div class="radio-position">Empresa Inexistente</div>
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
                                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_retorno" id="dt_retorno" placeholder="dd/mm/aaaa" value="<?=is_array($dt_retorno) ? $dt_retorno[2].'/'.$dt_retorno[1].'/'.$dt_retorno[0] : ''?>" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <label for="obs">Observa&ccedil;&atilde;o</label>
                                            <div class="controls">
                                                <textarea class="form-control" id="obs" name="obs" placeholder="Observa&ccedil;&atilde;o" rows="3"><?=$observacao?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <input type="hidden" id="id_prospec" name="id_prospec" value="<?=$id?>">
                                <button type="submit" id="btn_cad_prospec_vt" name="btn_cad_prospec_vt" class="btn btn-success">Salvar</button>
                                <button type="reset" id="btn_cancel" name="btn_cancel" class="btn btn-primary">Cancelar</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </section>

    </div>
    <!-- /.content-wrapper -->
