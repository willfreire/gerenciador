<?php
# Dados do cliente
$id              = isset($cliente[0]->id_empresa_pk) ? $cliente[0]->id_empresa_pk : "";
$id_tp_empresa   = isset($cliente[0]->id_tipo_empresa_fk) ? $cliente[0]->id_tipo_empresa_fk : "";
$tp_empresa      = isset($cliente[0]->tipo_empresa) ? $cliente[0]->tipo_empresa : "";
$cnpj            = isset($cliente[0]->cnpj) ? $cliente[0]->cnpj : "";
$nome_razao      = isset($cliente[0]->nome_razao) ? $cliente[0]->nome_razao : "";
$nome_fantasia   = isset($cliente[0]->nome_fantasia) ? $cliente[0]->nome_fantasia : "";
$inscr_estadual  = isset($cliente[0]->inscr_estadual) ? $cliente[0]->inscr_estadual : "";
$inscr_municipal = isset($cliente[0]->inscr_municipal) ? $cliente[0]->inscr_municipal : "";
$id_atividade    = isset($cliente[0]->id_atividade_fk) ? $cliente[0]->id_atividade_fk : "";
$ramo_atividade  = isset($cliente[0]->ramo_atividade) ? $cliente[0]->ramo_atividade : "";
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
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

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
                    Visualiza&ccedil;&atilde;o de Cliente
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./cliente') ?>"><i class="fa fa-users" aria-hidden="true"></i> Clientes</a>
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="nav-tabs-custom box-wrapper-80">

                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#empresa" data-toggle="tab"><strong>Dados do Cliente</strong></a></li>
                                <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o da Empresa</strong></a></li>
                                <li><a href="#contato" data-toggle="tab"><strong>Contato na Empresa</strong></a></li>
                                <li><a href="#cond_comer" data-toggle="tab"><strong>Condi&ccedil;&atilde;o Comercial</strong></a></li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="empresa">
                                    <div class="box box-wrapper-80">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Tipo de Empresa</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$tp_empresa?></div>
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
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=($id_status == "1" ? "Ativo" : "Inativo")?></div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="ender">
                                    <div class="box box-wrapper-80">
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
                                    <div class="box box-wrapper-80">
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

                                <div class="tab-pane" id="cond_comer">
                                    <div class="box box-wrapper-80">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Taxa Administrativa</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$taxa_adm.'%'?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Taxa de Entrega</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?='R$ '.$taxa_entrega?></div>
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