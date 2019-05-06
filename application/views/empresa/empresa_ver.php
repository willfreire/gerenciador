<?php
# Dados do empresa
$id              = isset($empresa[0]->id_empresa_pk) ? $empresa[0]->id_empresa_pk : "";
$plano           = isset($empresa[0]->plano) ? $empresa[0]->plano : "";
$id_tp_empresa   = isset($empresa[0]->id_tipo_empresa_fk) ? $empresa[0]->id_tipo_empresa_fk : "";
$tp_empresa      = isset($empresa[0]->tipo_empresa) ? $empresa[0]->tipo_empresa : "";
$cnpj            = isset($empresa[0]->cnpj) ? $empresa[0]->cnpj : "";
$nome_razao      = isset($empresa[0]->nome_razao) ? $empresa[0]->nome_razao : "";
$nome_fantasia   = isset($empresa[0]->nome_fantasia) ? $empresa[0]->nome_fantasia : "";
$inscr_estadual  = isset($empresa[0]->inscr_estadual) ? $empresa[0]->inscr_estadual : "";
$inscr_municipal = isset($empresa[0]->inscr_municipal) ? $empresa[0]->inscr_municipal : "";
$id_atividade    = isset($empresa[0]->id_atividade_fk) ? $empresa[0]->id_atividade_fk : "";
$ramo_atividade  = isset($empresa[0]->ramo_atividade) ? $empresa[0]->ramo_atividade : "";
$email           = isset($empresa[0]->email) ? $empresa[0]->email : "";
$email_adc       = isset($empresa[0]->email_adicional) ? $empresa[0]->email_adicional : "";
$tel             = isset($empresa[0]->telefone) ? $empresa[0]->telefone : "";
$email_pri       = isset($empresa[0]->email_primario) ? $empresa[0]->email_primario : "";
$email_sec       = isset($empresa[0]->email_secundario) ? $empresa[0]->email_secundario : "";
$id_filial_pk    = isset($empresa[0]->id_empresa_filial_pk) ? $empresa[0]->id_empresa_filial_pk : "";
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
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

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
                    Visualiza&ccedil;&atilde;o dos Dados Cadastrais
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-building" aria-hidden="true"></i> Dados Cadastrais
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="nav-tabs-custom box-wrapper-90">

                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#empresa" data-toggle="tab"><strong>Dados do Empresa</strong></a></li>
                                <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o da Empresa</strong></a></li>
                                <li><a href="#contato" data-toggle="tab"><strong>Contato na Empresa</strong></a></li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="empresa">
                                    <div class="box box-wrapper-90">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Plano Contratado</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$plano?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Tipo de Empresa</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$tp_empresa?></div>
                                            </div>
                                            <div class="row" <?=$id_tp_empresa == "2" ? "" : "hidden"?>>
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Matriz</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$razao_matriz?> - CNPJ: <?=$cnpj_matriz?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CNPJ</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cnpj?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Raz&atilde;o Social</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome_razao?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome Fantasia</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome_fantasia?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Inscri&ccedil;&atilde;o Estadual</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$inscr_estadual?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Inscri&ccedil;&atilde;o Municipal</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$inscr_municipal?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Ramo de Atividade</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$ramo_atividade?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail Adicional</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email_adc?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Telefone</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$tel?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail Prim&aacute;rio</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email_pri?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail Segund&aacute;rio</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email_sec?></div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="ender">
                                    <div class="box box-wrapper-90">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Tipo de Endere&ccedil;o</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$tipo_endereco?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CEP</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cep?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$logradouro?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>N&uacute;mero</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$numero?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Complemento</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$compl?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Bairro</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$bairro?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Estado</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$estado?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cidade</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cidade?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Respons&aacute;vel pelo Recebimento</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$resp_receb?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="contato">
                                    <div class="box box-wrapper-90">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome do Contato</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Departamento</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$depto?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Cargo</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cargo?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Sexo</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=($sexo == "f" ? "Feminino" : "Masculino")?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Nascimento</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=is_array($dt_nasc) ? $dt_nasc[2].'/'.$dt_nasc[1].'/'.$dt_nasc[0] : ''?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Respons&aacute;vel pela Compra?</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=($resp_compra == "1" ? "Sim" : "N&atilde;o")?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail Principal</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email_princ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail Segund&aacute;rio</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email_adc_cont?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 text-center" style="padding: 0px;">
                                    <div class="box-footer">
                                        <button type="button" id="btn_back" name="btn_back" class="btn btn-primary">Voltar</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>