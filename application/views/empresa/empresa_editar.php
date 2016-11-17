<?php
# Dados do empresa
$id              = isset($empresa[0]->id_empresa_pk) ? $empresa[0]->id_empresa_pk : "";
$id_tp_empresa   = isset($empresa[0]->id_tipo_empresa_fk) ? $empresa[0]->id_tipo_empresa_fk : "";
$cnpj            = isset($empresa[0]->cnpj) ? $empresa[0]->cnpj : "";
$nome_razao      = isset($empresa[0]->nome_razao) ? $empresa[0]->nome_razao : "";
$nome_fantasia   = isset($empresa[0]->nome_fantasia) ? $empresa[0]->nome_fantasia : "";
$inscr_estadual  = isset($empresa[0]->inscr_estadual) ? $empresa[0]->inscr_estadual : "";
$inscr_municipal = isset($empresa[0]->inscr_municipal) ? $empresa[0]->inscr_municipal : "";
$id_atividade    = isset($empresa[0]->id_atividade_fk) ? $empresa[0]->id_atividade_fk : "";
$email           = isset($empresa[0]->email) ? $empresa[0]->email : "";
$email_adc       = isset($empresa[0]->email_adicional) ? $empresa[0]->email_adicional : "";
$tel             = isset($empresa[0]->telefone) ? $empresa[0]->telefone : "";
$email_pri       = isset($empresa[0]->email_primario) ? $empresa[0]->email_primario : "";
$email_sec       = isset($empresa[0]->email_secundario) ? $empresa[0]->email_secundario : "";
$id_status       = isset($empresa[0]->id_status_fk) ? $empresa[0]->id_status_fk : "";
$id_matriz       = isset($empresa[0]->id_empresa_matriz_fk) ? $empresa[0]->id_empresa_matriz_fk : "";
$cnpj_matriz     = isset($empresa[0]->cnpj_matriz) ? $empresa[0]->cnpj_matriz : "";
$razao_matriz    = isset($empresa[0]->razao_matriz) ? $empresa[0]->razao_matriz : "";
$id_tp_endereco  = isset($empresa[0]->id_tipo_endereco_fk) ? $empresa[0]->id_tipo_endereco_fk : "";
$cep             = isset($empresa[0]->cep) ? $empresa[0]->cep : "";
$logradouro      = isset($empresa[0]->logradouro) ? $empresa[0]->logradouro : "";
$numero          = isset($empresa[0]->numero) ? $empresa[0]->numero : "";
$compl           = isset($empresa[0]->complemento) ? $empresa[0]->complemento : "";
$bairro          = isset($empresa[0]->bairro) ? $empresa[0]->bairro : "";
$id_cidade       = isset($empresa[0]->id_cidade_fk) ? $empresa[0]->id_cidade_fk : "";
$id_estado       = isset($empresa[0]->id_estado_fk) ? $empresa[0]->id_estado_fk : "";
$resp_receb      = isset($empresa[0]->resp_recebimento) ? $empresa[0]->resp_recebimento : "";
$tipo_endereco   = isset($empresa[0]->tipo_endereco) ? $empresa[0]->tipo_endereco : "";
$cidade          = isset($empresa[0]->cidade) ? $empresa[0]->cidade : "";
$estado          = isset($empresa[0]->estado) ? $empresa[0]->estado : "";
$nome            = isset($empresa[0]->nome) ? $empresa[0]->nome : "";
$id_depto        = isset($empresa[0]->id_departamento_fk) ? $empresa[0]->id_departamento_fk : "";
$id_cargo        = isset($empresa[0]->id_cargo_fk) ? $empresa[0]->id_cargo_fk : "";
$sexo            = isset($empresa[0]->sexo) ? $empresa[0]->sexo : "";
$dt_nasc         = isset($empresa[0]->dt_nasc) ? explode("-", $empresa[0]->dt_nasc) : "";
$resp_compra     = isset($empresa[0]->resp_compra) ? $empresa[0]->resp_compra : "";
$email_princ     = isset($empresa[0]->email_principal) ? $empresa[0]->email_principal : "";
$email_adc_cont  = isset($empresa[0]->email_adc_contato) ? $empresa[0]->email_adc_contato : "";
$depto           = isset($empresa[0]->departamento) ? $empresa[0]->departamento : "";
$cargo           = isset($empresa[0]->cargo) ? $empresa[0]->cargo : "";
$id_cond_com_pk  = isset($empresa[0]->id_cond_comercial_pk) ? $empresa[0]->id_cond_comercial_pk : "";
$taxa_adm        = isset($empresa[0]->taxa_adm) ? $empresa[0]->taxa_adm : "0.00";
$taxa_entrega    = isset($empresa[0]->taxa_entrega) ? number_format($empresa[0]->taxa_entrega, 2, ',', '.') : "0,00";
?>
<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Empresa -->
    <link rel="stylesheet" href="<?= base_url('assets/css/empresa.css') ?>">

    <!-- JS Empresa -->
    <script src="<?= base_url('scripts/js/empresa.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edi&ccedil;&atilde;o dos Dados Cadastrais
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-building" aria-hidden="true"></i> Dados Cadastrais
                    </li>
                    <li class="active">Editar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-client">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_client_vt" id="frm_edit_client_vt">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#empresa" data-toggle="tab"><strong>Dados do Empresa</strong></a></li>
                                        <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o da Empresa</strong></a></li>
                                        <li><a href="#contato" data-toggle="tab"><strong>Contato na Empresa</strong></a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="empresa">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="tp_empresa">Tipo de Empresa</label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="1" <?=$id_tp_empresa == "1" ? "checked='checked'" : ""?> disabled="disabled"> <div class="radio-position">Matriz</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="2" <?=$id_tp_empresa == "2" ? "checked='checked'" : ""?> disabled="disabled"> <div class="radio-position">Filial</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group <?=$id_tp_empresa == "2" ? "" : "hidden"?>" id="div_matriz">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="matriz">Matriz</label>
                                                            <div class="controls">
                                                                <?=$razao_matriz?> - CNPJ: <?=$cnpj_matriz?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="cnpj">CNPJ</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" maxlength="18" value="<?=$cnpj?>" disabled="disabled" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="razao_social">Raz&atilde;o Social<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Raz&atilde;o Social" maxlength="250" required="true" value="<?=$nome_razao?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="nome_fantasia">Nome Fantasia</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="Nome Fantasia" maxlength="250" value="<?=$nome_fantasia?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="insc_estadual">Inscri&ccedil;&atilde;o Estadual</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="insc_estadual" name="insc_estadual" placeholder="Inscri&ccedil;&atilde;o Estadual" maxlength="20" value="<?=$inscr_estadual?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="inscr_municipal">Inscri&ccedil;&atilde;o Municipal</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="inscr_municipal" name="inscr_municipal" placeholder="Inscri&ccedil;&atilde;o Municipal" maxlength="20" value="<?=$inscr_municipal?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="atividade">Ramo de Atividade<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="atividade" id="atividade" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($atividades)):
                                                                        foreach ($atividades as $value):
                                                                            $sel = $id_atividade == $value->id_ramo_atividade_pk ? "selected='selected'" : "";
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
                                                            <label for="email_adicional">E-mail Adicional</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_adicional" name="email_adicional" placeholder="E-mail Adicional" maxlength="250" value="<?=$email_adc?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
                                                            <label for="tel">Telefone<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="tel" name="tel" placeholder="(ddd) + n&uacute;mero" maxlength="15" required="true" value="<?=$tel?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_primario">E-mail Prim&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_primario" name="email_primario" placeholder="E-mail Prim&aacute;rio" maxlength="250" value="<?=$email_pri?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_secundario">E-mail Segund&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_secundario" name="email_secundario" placeholder="E-mail Segund&aacute;rio" maxlength="250" value="<?=$email_sec?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="alt_senha">Alterar Senha?</label>
                                                            <div class="controls">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" name="alt_senha" id="alt_senha" value="1"> Sim
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="senha_empresa">Senha</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="senha_empresa" name="senha_empresa" placeholder="Senha" maxlength="50" required="true" disabled autocomplete="off">
                                                                <input type="button" class="btn btn-primary hidden" id="gen_pwd" name="gen_pwd" value="Gerar Senha">
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
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="tp_endereco">Tipo de Endere&ccedil;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_endereco" id="tp_endereco" value="1" <?=$id_tp_endereco == "1" ? "checked='checked'" : ""?>> <div class="radio-position">Entrega</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_endereco" id="tp_endereco" value="2" <?=$id_tp_endereco == "2" ? "checked='checked'" : ""?>> <div class="radio-position">Faturamento</div>
                                                                </label>
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
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="endereco">Endere&ccedil;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endere&ccedil;o" maxlength="250" required="true" value="<?=$logradouro?>">
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
                                                                <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento" maxlength="50" value="<?=$compl?>">
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
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="estado">Estado<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="estado" id="estado" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($estados)):
                                                                        foreach ($estados as $value):
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
                                                                    if (is_array($cidades)):
                                                                        foreach ($cidades as $value):
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

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="resp_receb">Respons&aacute;vel pelo Recebimento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="resp_receb" name="resp_receb" placeholder="Respons&aacute;vel pelo Recebimento" maxlength="250" required="true" value="<?=$resp_receb?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="contato">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="nome_contato">Nome do Contato<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_contato" name="nome_contato" placeholder="Nome do Contato" maxlength="250" required="true" value="<?=$nome?>">
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
                                                                    if (is_array($dptos)):
                                                                        foreach ($dptos as $value):
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
                                                                    if (is_array($cargos)):
                                                                        foreach ($cargos as $value):
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
                                                            <label for="resp_compra">Respons&aacute;vel pela Compra?<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="resp_compra" id="resp_compra" value="s" <?=$resp_compra == "s" ? "checked='checked'" : ""?>> <div class="radio-position">Sim</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="resp_compra" id="resp_compra" value="n" <?=$resp_compra == "n" ? "checked='checked'" : ""?>> <div class="radio-position">N&atilde;o</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_pri_contato">E-mail Principal<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_pri_contato" name="email_pri_contato" placeholder="E-mail Principal" maxlength="250" value="<?=$email_princ?>" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_sec_contato">E-mail Segund&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_sec_contato" name="email_sec_contato" placeholder="E-mail Segund&aacute;rio" maxlength="250" value="<?=$email_adc_cont?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_empresa" name="id_empresa" value="<?=$id?>">
                                    <button type="submit" id="btn_edit_client_vt" name="btn_edit_client_vt" class="btn btn-primary">Alterar</button>
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