<?php
# Dados do cliente
$id              = isset($cliente[0]->id_empresa_pk) ? $cliente[0]->id_empresa_pk : "";
$id_tp_empresa   = isset($cliente[0]->id_tipo_empresa_fk) ? $cliente[0]->id_tipo_empresa_fk : "";
$cnpj            = isset($cliente[0]->cnpj) ? $cliente[0]->cnpj : "";
$nome_razao      = isset($cliente[0]->nome_razao) ? $cliente[0]->nome_razao : "";
$nome_fantasia   = isset($cliente[0]->nome_fantasia) ? $cliente[0]->nome_fantasia : "";
$inscr_estadual  = isset($cliente[0]->inscr_estadual) ? $cliente[0]->inscr_estadual : "";
$inscr_municipal = isset($cliente[0]->inscr_municipal) ? $cliente[0]->inscr_municipal : "";
$id_atividade    = isset($cliente[0]->id_atividade_fk) ? $cliente[0]->id_atividade_fk : "";
$email           = isset($cliente[0]->email) ? $cliente[0]->email : "";
$email_adc       = isset($cliente[0]->email_adicional) ? $cliente[0]->email_adicional : "";
$tel             = isset($cliente[0]->telefone) ? $cliente[0]->telefone : "";
$email_pri       = isset($cliente[0]->email_primario) ? $cliente[0]->email_primario : "";
$email_sec       = isset($cliente[0]->email_secundario) ? $cliente[0]->email_secundario : "";
$id_status       = isset($cliente[0]->id_status_fk) ? $cliente[0]->id_status_fk : "";
$id_filial_pk    = isset($cliente[0]->id_empresa_filial_pk) ? $cliente[0]->id_empresa_filial_pk : "";
$id_matriz       = isset($cliente[0]->id_empresa_matriz_fk) ? $cliente[0]->id_empresa_matriz_fk : "";
$cnpj_matriz     = isset($cliente[0]->cnpj_matriz) ? $cliente[0]->cnpj_matriz : "";
$razao_matriz    = isset($cliente[0]->razao_matriz) ? $cliente[0]->razao_matriz : "";
$id_tp_endereco  = isset($cliente[0]->id_tipo_endereco_fk) ? $cliente[0]->id_tipo_endereco_fk : "";
$cep             = isset($cliente[0]->cep) ? $cliente[0]->cep : "";
$logradouro      = isset($cliente[0]->logradouro) ? $cliente[0]->logradouro : "";
$numero          = isset($cliente[0]->numero) ? $cliente[0]->numero : "";
$compl           = isset($cliente[0]->complemento) ? $cliente[0]->complemento : "";
$bairro          = isset($cliente[0]->bairro) ? $cliente[0]->bairro : "";
$id_cidade       = isset($cliente[0]->id_cidade_fk) ? $cliente[0]->id_cidade_fk : "";
$id_estado       = isset($cliente[0]->id_estado_fk) ? $cliente[0]->id_estado_fk : "";
$resp_receb      = isset($cliente[0]->resp_recebimento) ? $cliente[0]->resp_recebimento : "";
$tipo_endereco   = isset($cliente[0]->tipo_endereco) ? $cliente[0]->tipo_endereco : "";
$cidade          = isset($cliente[0]->cidade) ? $cliente[0]->cidade : "";
$estado          = isset($cliente[0]->estado) ? $cliente[0]->estado : "";
$nome            = isset($cliente[0]->nome) ? $cliente[0]->nome : "";
$id_depto        = isset($cliente[0]->id_departamento_fk) ? $cliente[0]->id_departamento_fk : "";
$id_cargo        = isset($cliente[0]->id_cargo_fk) ? $cliente[0]->id_cargo_fk : "";
$sexo            = isset($cliente[0]->sexo) ? $cliente[0]->sexo : "";
$dt_nasc         = isset($cliente[0]->dt_nasc) ? explode("-", $cliente[0]->dt_nasc) : "";
$resp_compra     = isset($cliente[0]->resp_compra) ? $cliente[0]->resp_compra : "";
$email_princ     = isset($cliente[0]->email_principal) ? $cliente[0]->email_principal : "";
$email_adc_cont  = isset($cliente[0]->email_adc_contato) ? $cliente[0]->email_adc_contato : "";
$depto           = isset($cliente[0]->departamento) ? $cliente[0]->departamento : "";
$cargo           = isset($cliente[0]->cargo) ? $cliente[0]->cargo : "";
$id_cond_com_pk  = isset($cliente[0]->id_cond_comercial_pk) ? $cliente[0]->id_cond_comercial_pk : "";
$taxa_adm        = isset($cliente[0]->taxa_adm) ? $cliente[0]->taxa_adm : "0.00";
$taxa_entrega    = isset($cliente[0]->taxa_entrega) ? number_format($cliente[0]->taxa_entrega, 2, ',', '.') : "0,00";
$taxa_fixa_perc  = isset($cliente[0]->taxa_fixa_perc) ? $cliente[0]->taxa_fixa_perc : "0.00";
$taxa_fixa_real  = isset($cliente[0]->taxa_fixa_real) ? number_format($cliente[0]->taxa_fixa_real, 2, ',', '.') : "0,00";
$taxa_adm_cr     = isset($cliente[0]->taxa_adm_cr) ? $cliente[0]->taxa_adm_cr : "0.00";
$taxa_adm_ca     = isset($cliente[0]->taxa_adm_ca) ? $cliente[0]->taxa_adm_ca : "0.00";
$taxa_adm_cc     = isset($cliente[0]->taxa_adm_cc) ? $cliente[0]->taxa_adm_cc : "0.00";
?>
<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Cliente -->
    <link rel="stylesheet" href="<?= base_url('assets/css/cliente.css') ?>">

    <!-- JS Cliente -->
    <script src="<?= base_url('scripts/js/cliente.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edi&ccedil;&atilde;o de Cliente
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./cliente') ?>"><i class="fa fa-users" aria-hidden="true"></i> Clientes</a>
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
                                        <li class="active"><a href="#empresa" data-toggle="tab"><strong>Dados do Cliente</strong></a></li>
                                        <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o da Empresa</strong></a></li>
                                        <li><a href="#contato" data-toggle="tab"><strong>Contato na Empresa</strong></a></li>
                                        <li><a href="#cond_comer" data-toggle="tab"><strong>Condi&ccedil;&atilde;o Comercial</strong></a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="empresa">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="tp_empresa">Tipo de Empresa<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="1" <?=$id_tp_empresa == "1" ? "checked='checked'" : ""?>> <div class="radio-position">Matriz</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="2" <?=$id_tp_empresa == "2" ? "checked='checked'" : ""?>> <div class="radio-position">Filial</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group <?=$id_tp_empresa == "2" ? "" : "hidden"?>" id="div_matriz">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="matriz">Selecione a Matriz<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="matriz" id="matriz">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($matriz)):
                                                                        foreach ($matriz as $value):
                                                                            $sel = $id_matriz == $value->id_empresa_pk ? "selected='selected'" : "";
                                                                            echo "<option value='$value->id_empresa_pk' $sel>$value->nome_razao - $value->cnpj</option>";
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
                                                            <label for="cnpj">CNPJ<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" maxlength="18" value="<?=$cnpj?>" required="true">
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
                                                            <label for="senha_cliente">Senha</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="Senha" maxlength="50" required="true" disabled autocomplete="off">
                                                                <input type="button" class="btn btn-primary hidden" id="gen_pwd" name="gen_pwd" value="Gerar Senha">
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

                                        <div class="tab-pane" id="cond_comer">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title">Taxas - Vale Transporte</h4>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm">Taxa Administrativa</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm" name="taxa_adm" placeholder="0.00" maxlength="6" value="<?=$taxa_adm?>">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_entrega">Taxa de Entrega</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon text-bold">R$</span>
                                                                                <input type="text" class="form-control" id="taxa_entrega" name="taxa_entrega" placeholder="0,00" maxlength="9" value="<?=$taxa_entrega?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_fixa_perc">Taxa Fixa %</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_fixa_perc" name="taxa_fixa_perc" placeholder="0.00" maxlength="6" value="<?=$taxa_fixa_perc?>">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_fixa_real">Taxa Fixa R$</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon text-bold">R$</span>
                                                                                <input type="text" class="form-control" id="taxa_fixa_real" name="taxa_fixa_real" placeholder="0,00" maxlength="9" value="<?=$taxa_fixa_real?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title">Taxas - Outros Produtos</h4>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_cr">Taxa Administrativa - Cart&atilde;o Refei&ccedil;&atilde;o</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_cr" name="taxa_adm_cr" placeholder="0.00" maxlength="6" value="<?=$taxa_adm_cr?>">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_ca">Taxa Administrativa - Cart&atilde;o Alimenta&ccedil;&atilde;o</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_ca" name="taxa_adm_ca" placeholder="0.00" maxlength="6" value="<?=$taxa_adm_ca?>">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_cc">Taxa Administrativa - Cart&atilde;o Combust&iacute;vel</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_cc" name="taxa_adm_cc" placeholder="0.00" maxlength="6" value="<?=$taxa_adm_cc?>">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_cliente" name="id_cliente" value="<?=$id?>">
                                    <input type="hidden" id="id_filial" name="id_filial" value="<?=$id_filial_pk?>">
                                    <input type="hidden" id="id_cond_com" name="id_cond_com" value="<?=$id_cond_com_pk?>">
                                    <button type="submit" id="btn_edit_client_vt" name="btn_edit_client_vt" class="btn btn-success">Alterar</button>
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

