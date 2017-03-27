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
$cep          = isset($funcionario[0]->cep) ? $funcionario[0]->cep : "";
$logradouro   = isset($funcionario[0]->logradouro) ? $funcionario[0]->logradouro : "";
$numero       = isset($funcionario[0]->numero) ? $funcionario[0]->numero : "";
$compl        = isset($funcionario[0]->complemento) ? $funcionario[0]->complemento : "";
$bairro       = isset($funcionario[0]->bairro) ? $funcionario[0]->bairro : "";
$id_cidade    = isset($funcionario[0]->id_cidade_fk) ? $funcionario[0]->id_cidade_fk : "";
$id_estado    = isset($funcionario[0]->id_estado_fk) ? $funcionario[0]->id_estado_fk : "";
$matricula    = isset($funcionario[0]->matricula) ? $funcionario[0]->matricula : "";
$id_depto     = isset($funcionario[0]->id_departamento_fk) ? $funcionario[0]->id_departamento_fk : "";
$id_cargo     = isset($funcionario[0]->id_cargo_fk) ? $funcionario[0]->id_cargo_fk : "";
$id_periodo   = isset($funcionario[0]->id_periodo_pk) ? $funcionario[0]->id_periodo_pk : "";
$email        = isset($funcionario[0]->email) ? $funcionario[0]->email : "";
$id_end_empr  = isset($funcionario[0]->id_endereco_empresa_fk) ? $funcionario[0]->id_endereco_empresa_fk : "";
?>
<body class="hold-transition skin-blue sidebar-mini">

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
                                        <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o do Funcion&aacute;rio</strong></a></li>
                                        <li><a href="#dados" data-toggle="tab"><strong>Dados Profissionais</strong></a></li>
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

                                        <div class="tab-pane" id="ender">
                                            <div class="box-body">

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
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="endereco">Endere&ccedil;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endere&ccedil;o" maxlength="250" value="<?=$logradouro?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-7 col-sm-5 col-md-5 col-lg-4">
                                                            <label for="numero">N&uacute;mero<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="numero" name="numero" placeholder="N&uacute;mero" maxlength="15" value="<?=$numero?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="complemento">Complemento</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento" value="<?=$compl?>" maxlength="50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="bairro">Bairro<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?=$bairro?>" maxlength="25">
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
                                                                            $sel = $id_estado == $value->id_estado_pk ? "selected='selected'" : "";
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
                                                                            $sel = $id_cidade == $value->id_cidade_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_cidade_pk' $sel>$value->cidade</option>";
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

                                    </div>
                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_func" name="id_func" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_func" name="btn_edit_func" class="btn btn-primary">Alterar</button>
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