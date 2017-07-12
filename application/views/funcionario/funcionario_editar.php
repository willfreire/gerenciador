<?php
# Dados do Funcionario
$id           = isset($funcionario[0]->id_funcionario_pk) ? $funcionario[0]->id_funcionario_pk : "";
$cpf          = isset($funcionario[0]->cpf) ? $funcionario[0]->cpf : "";
$nome         = isset($funcionario[0]->nome) ? $funcionario[0]->nome : "";
$dt_nasc      = isset($funcionario[0]->dt_nasc) ? explode("-", $funcionario[0]->dt_nasc) : "";
$sexo         = isset($funcionario[0]->sexo) ? $funcionario[0]->sexo : "";
$id_est_civil = isset($funcionario[0]->id_estado_civil_fk) ? $funcionario[0]->id_estado_civil_fk : "";
$rg           = isset($funcionario[0]->rg) ? $funcionario[0]->rg : "";
$dt_exp       = isset($funcionario[0]->dt_expedicao) ? explode("-", $funcionario[0]->dt_expedicao) : "";
$orgao        = isset($funcionario[0]->orgao_expedidor) ? $funcionario[0]->orgao_expedidor : "";
$uf_exp       = isset($funcionario[0]->id_estado_expedidor_fk) ? $funcionario[0]->id_estado_expedidor_fk : "";
$nome_mae     = isset($funcionario[0]->nome_mae) ? $funcionario[0]->nome_mae : "";
$nome_pai     = isset($funcionario[0]->nome_pai) ? $funcionario[0]->nome_pai : "";
$id_status    = isset($funcionario[0]->id_status_fk) ? $funcionario[0]->id_status_fk : "";
$matricula    = isset($funcionario[0]->matricula) ? $funcionario[0]->matricula : "";
$id_depto     = isset($funcionario[0]->id_departamento_fk) ? $funcionario[0]->id_departamento_fk : "";
$id_cargo     = isset($funcionario[0]->id_cargo_fk) ? $funcionario[0]->id_cargo_fk : "";
$id_periodo   = isset($funcionario[0]->id_periodo_pk) ? $funcionario[0]->id_periodo_pk : "";
$email        = isset($funcionario[0]->email) ? $funcionario[0]->email : "";
$id_end_empr  = isset($funcionario[0]->id_endereco_empresa_fk) ? $funcionario[0]->id_endereco_empresa_fk : "";
?>
<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Beneficio/Cartao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/beneficio_cartao.css') ?>">

    <!-- JS Beneficio/Cartao -->
    <script src="<?= base_url('scripts/js/beneficio_cartao.js') ?>"></script>

    <!-- CSS Funcionario -->
    <link rel="stylesheet" href="<?= base_url('assets/css/funcionario.css') ?>">

    <!-- JS Funcionario -->
    <script src="<?= base_url('scripts/js/funcionario.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edi&ccedil;&atilde;o de Funcion&aacute;rio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./funcionario') ?>"><i class="fa fa-users" aria-hidden="true"></i> Funcion&aacute;rios</a>
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-func">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_func" id="frm_edit_func">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#func" data-toggle="tab"><strong>Dados do Funcion&aacute;rio</strong></a></li>
                                        <li><a href="#dados" data-toggle="tab"><strong>Dados Profissionais</strong></a></li>
                                        <li><a href="#benef" data-toggle="tab"><strong>Benef&iacute;cios do Funcion&aacute;rio</strong></a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="func">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="cpf">CPF<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" maxlength="14" value="<?=$cpf?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                            <label for="nome_func">Nome<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_func" name="nome_func" placeholder="Nome" maxlength="250" value="<?=$nome?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
                                                            <label for="dt_nasc">Data de Nascimento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_nasc" id="dt_nasc" placeholder="dd/mm/aaaa" value="<?=is_array($dt_nasc) ? $dt_nasc[2].'/'.$dt_nasc[1].'/'.$dt_nasc[0] : ''?>" maxlength="10" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="sexo">Sexo<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="sexo" id="sexo" value="m" <?=$sexo == "m" ? "checked='checked'" : ""?>> <div class="radio-position">Masculino</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="sexo" id="sexo" value="f" <?=$sexo == "f" ? "checked='checked'" : ""?>> <div class="radio-position">Feminino</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="estado_civil">Estado Civil<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="estado_civil" id="estado_civil" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($estado_civil)):
                                                                        foreach ($estado_civil as $value):
                                                                            $sel = $id_est_civil == $value->id_estado_civil_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_estado_civil_pk' $sel>$value->estado_civil</option>";
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
                                                        <div class="col-xs-10 col-sm-4 col-md-3 col-lg-4">
                                                            <label for="rg">RG<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="rg" name="rg" placeholder="RG" maxlength="15" value="<?=$rg?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-3 col-lg-4" style="margin-bottom: 15px;">
                                                            <label for="dt_exped">Data de Expedi&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" id="dt_exped" name="dt_exped" placeholder="dd/mm/aaaa" maxlength="15" value="<?=is_array($dt_exp) ? $dt_exp[2].'/'.$dt_exp[1].'/'.$dt_exp[0] : ''?>" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-10 col-sm-6 col-md-3 col-lg-3" style="margin-bottom: 15px;">
                                                            <label for="orgao_exped">&Oacute;rg&atilde;o Expedidor<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="orgao_exped" name="orgao_exped" placeholder="&Oacute;rg&atilde;o" maxlength="5" value="<?=$orgao?>" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
                                                            <label for="uf_exped">UF<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="uf_exped" id="uf_exped" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($estado)):
                                                                        foreach ($estado as $value):
                                                                            $sel = $uf_exp == $value->id_estado_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_estado_pk' $sel>$value->sigla</option>";
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
                                                            <label for="nome_mae">Nome da M&atilde;e<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_mae" name="nome_mae" placeholder="Nome da M&atilde;e" maxlength="250" value="<?=$nome_mae?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                            <label for="nome_pai">Nome do Pai</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_pai" name="nome_pai" placeholder="Nome do Pai" maxlength="250" value="<?=$nome_pai?>">
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
                                        </div>

                                        <div class="tab-pane" id="dados">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="matricula">Matr&iacute;cula<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matr&iacute;cula" maxlength="20" value="<?=$matricula?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="depto">Departamento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="depto" id="depto" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($dpto)):
                                                                        foreach ($dpto as $value):
                                                                            $sel = $id_depto == $value->id_departamento_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_departamento_pk' $sel>$value->departamento</option>";
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
                                                            <label for="cargo">Cargo<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="cargo" id="cargo" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($cargo)):
                                                                        foreach ($cargo as $value):
                                                                            $sel = $id_cargo == $value->id_cargo_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_cargo_pk' $sel>$value->cargo</option>";
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
                                                            <label for="periodo">Per&iacute;odo<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="periodo" id="periodo" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($periodo)):
                                                                        foreach ($periodo as $value):
                                                                            $sel = $id_periodo == $value->id_periodo_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_periodo_pk' $sel>$value->periodo</option>";
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
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_func">E-mail</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_func" name="email_func" placeholder="E-mail" maxlength="250" value="<?=$email?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                                            <label for="ender_empresa">Endere&ccedil;o da Empresa<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="ender_empresa" id="ender_empresa" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($end_empresa)):
                                                                        foreach ($end_empresa as $value):
                                                                            $sel = $id_end_empr == $value->id_endereco_empresa_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_endereco_empresa_pk' $sel>$value->logradouro, nº $value->numero, $value->bairro </option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="benef">
                                            <div class="box-body">

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12col-lg-12">
                                                        <button type="button" id="btn_add_benedit" name="btn_add_benedit" class="btn btn-primary">Adicionar Benef&iacute;cio</button>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr class="info">
                                                                        <th class="col-xs-4 col-sm-4 col-md-6 col-lg-6">Benef&iacute;cio</th>
                                                                        <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-center">Valor Unit&aacute;rio</th>
                                                                        <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-center">Qtde Dias</th>
                                                                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">A&ccedil;&atilde;o</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="list_benef_edit">
                                                                    <tr>
                                                                        <td colspan="4">Nenhum Benef&iacute;cio Adicionado</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_func" name="id_func" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_func" name="btn_edit_func" class="btn btn-success">Alterar</button>
                                    <button type="button" id="btn_back" name="btn_back" class="btn btn-primary">Voltar</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </section>

            <div class="modal fade" id="modal_benedit">
                <div class="modal-dialog" id="modal-dialog-benedit">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                            <h4 class="modal-title">Adicionar Benef&iacute;cio</h4>
                        </div>
                        <div class="modal-body">

                            <div class="container-fluid box box-primary" id="box-frm-bencard-func">

                                <div class="box-header with-border">
                                    <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                                </div>

                                <form role="form" name="frm_cad_benfunc_edit" id="frm_cad_benfunc_edit">

                                    <div class="box-body">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                    <label for="grp">Grupo<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select class="form-control" name="grp" id="grp" required="true">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            if (is_array($grps)):
                                                                foreach ($grps as $value):
                                                                    $sel = $value->id_grupo_pk == 1 ? "selected='selected'" : "";
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
                                                    <label for="beneficio">Benef&iacute;cio<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select class="form-control" name="beneficio" id="beneficio" required="true">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            if (is_array($itens_benef)):
                                                                foreach ($itens_benef as $value):
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
                                                <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                    <label for="vl_unitario">Valor Unit&aacute;rio<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">R$</span>
                                                            <input type="text" class="form-control" id="vl_unitario" name="vl_unitario" placeholder="0,00" maxlength="7" value="0,00" required="true">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                    <label for="qtd_dia">Quantidade de Dias<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" id="qtd_dia" name="qtd_dia" placeholder="0" maxlength="2" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                    <label for="cartao">Possui Cart&atilde;o?<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="cartao" id="cartao" value="1"> <div class="radio-position">Sim</div>
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="cartao" id="cartao" value="2"> <div class="radio-position">N&atilde;o</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_cartao" class="hidden">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
                                                        <label for="num_cartao">N&ordm; do Cart&atilde;o<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="num_cartao" name="num_cartao" placeholder="N&ordm; do Cart&atilde;o" maxlength="50" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
                                                        <label for="status_card">Status do Cart&atilde;o<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select class="form-control" name="status_card" id="status_card">
                                                                <option value="">Selecione</option>
                                                                <?php
                                                                if (is_array($sts_card)):
                                                                    foreach ($sts_card as $value):
                                                                        echo "<option value='$value->id_status_cartao_pk'>$value->status_cartao</option>";
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="box-footer">
                                        <input type="hidden" id="id_func" name="id_func" value="<?=$id?>">
                                        <button type="submit" id="btn_cad_bencard" name="btn_cad_bencard" class="btn btn-success">Cadastrar</button>
                                        <button type="reset" id="cancel_benedit" name="cancel_benedit" class="btn btn-primary">Cancelar</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_benedit_func">
                <div class="modal-dialog" id="modal-dialog-benedit_func">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                            <h4 class="modal-title">Editar Benef&iacute;cio</h4>
                        </div>
                        <div class="modal-body">

                            <div class="container-fluid box box-primary" id="box-frm-bencard-func">

                                <div class="box-header with-border">
                                    <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                                </div>

                                <form role="form" name="frm_cad_benef_edit_func" id="frm_cad_benef_edit_func">

                                    <div class="box-body">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                    <label for="grp_edit">Grupo<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select class="form-control" name="grp_edit" id="grp_edit" required="true">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            if (is_array($grps)):
                                                                foreach ($grps as $value):
                                                                    echo "<option value='$value->id_grupo_pk'>$value->grupo</option>";
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
                                                    <label for="beneficio_edit">Benef&iacute;cio<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select class="form-control" name="beneficio_edit" id="beneficio_edit" required="true">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            if (is_array($ibenef_geral)):
                                                                foreach ($ibenef_geral as $value):
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
                                                <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                    <label for="vl_unitario_edit">Valor Unit&aacute;rio<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">R$</span>
                                                            <input type="text" class="form-control" id="vl_unitario_edit" name="vl_unitario_edit" placeholder="0,00" maxlength="7" value="0,00" required="true">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                    <label for="qtd_dia_edit">Quantidade de Dias<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" id="qtd_dia_edit" name="qtd_dia_edit" placeholder="0" maxlength="2" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                    <label for="cartao_edit">Possui Cart&atilde;o?<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        <select class="form-control" name="cartao_edit" id="cartao_edit" required="true">
                                                            <option value="1">Sim</option>
                                                            <option value="2">N&atilde;o</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_cartao_edit" class="hidden">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
                                                        <label for="num_cartao_edit">N&ordm; do Cart&atilde;o<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="num_cartao_edit" name="num_cartao_edit" placeholder="N&ordm; do Cart&atilde;o" maxlength="50" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
                                                        <label for="status_card_edit">Status do Cart&atilde;o<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            <select class="form-control" name="status_card_edit" id="status_card_edit">
                                                                <option value="">Selecione</option>
                                                                <?php
                                                                if (is_array($sts_card)):
                                                                    foreach ($sts_card as $value):
                                                                        echo "<option value='$value->id_status_cartao_pk'>$value->status_cartao</option>";
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="box-footer">
                                        <input type="hidden" id="id_func" name="id_func" value="<?=$id?>">
                                        <input type="text" id="id_benef" name="id_benef" value="">
                                        <button type="submit" id="btn_edit_bencard" name="btn_edit_bencard" class="btn btn-success">Alterar</button>
                                        <button type="reset" id="cancel_benedit_func" name="cancel_benedit_func" class="btn btn-primary">Cancelar</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>