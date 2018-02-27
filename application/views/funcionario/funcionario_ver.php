<?php
# Dados do Funcionario
$id           = isset($funcionario[0]->id_funcionario_pk) ? $funcionario[0]->id_funcionario_pk : "";
$cpf          = isset($funcionario[0]->cpf) ? $funcionario[0]->cpf : "";
$nome         = isset($funcionario[0]->nome) ? $funcionario[0]->nome : "";
$dt_nasc      = isset($funcionario[0]->dt_nasc) ? explode("-", $funcionario[0]->dt_nasc) : "";
$sexo         = isset($funcionario[0]->sexo) ? $funcionario[0]->sexo : "";
$est_civil    = isset($funcionario[0]->estado_civil) ? $funcionario[0]->estado_civil : "";
$rg           = isset($funcionario[0]->rg) ? $funcionario[0]->rg : "";
$dt_exp       = isset($funcionario[0]->dt_expedicao) ? explode("-", $funcionario[0]->dt_expedicao) : "";
$orgao        = isset($funcionario[0]->orgao_expedidor) ? $funcionario[0]->orgao_expedidor : "";
$uf_exp       = isset($funcionario[0]->sigla_exp) ? $funcionario[0]->sigla_exp : "";
$nome_mae     = isset($funcionario[0]->nome_mae) ? $funcionario[0]->nome_mae : "";
$nome_pai     = isset($funcionario[0]->nome_pai) ? $funcionario[0]->nome_pai : "";
$id_status    = isset($funcionario[0]->id_status_fk) ? $funcionario[0]->id_status_fk : "";
$cep          = isset($funcionario[0]->cep) ? $funcionario[0]->cep : "";
$logradouro   = isset($funcionario[0]->logradouro) ? $funcionario[0]->logradouro : "";
$numero       = isset($funcionario[0]->numero) ? $funcionario[0]->numero : "";
$compl        = isset($funcionario[0]->complemento) ? $funcionario[0]->complemento : "";
$bairro       = isset($funcionario[0]->bairro) ? $funcionario[0]->bairro : "";
$cidade       = isset($funcionario[0]->cidade) ? $funcionario[0]->cidade : "";
$estado       = isset($funcionario[0]->estado_end) ? $funcionario[0]->estado_end : "";
$matricula    = isset($funcionario[0]->matricula) ? $funcionario[0]->matricula : "";
$depto        = isset($funcionario[0]->departamento) ? $funcionario[0]->departamento : "";
$cargo        = isset($funcionario[0]->cargo) ? $funcionario[0]->cargo : "";
$periodo      = isset($funcionario[0]->periodo) ? $funcionario[0]->periodo : "";
$email        = isset($funcionario[0]->email) ? $funcionario[0]->email : "";
$end_empr_cep = isset($funcionario[0]->cep_empr) ? $funcionario[0]->cep_empr : "";
$end_empr_log = isset($funcionario[0]->logradouro_empr) ? $funcionario[0]->logradouro_empr : "";
$end_empr_num = isset($funcionario[0]->numero_empr) ? $funcionario[0]->numero_empr : "";
$end_empr_bai = isset($funcionario[0]->bairro_empr) ? $funcionario[0]->bairro_empr : "";
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

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
                    Visualiza&ccedil;&atilde;o de Funcion&aacute;rio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./funcionario') ?>"><i class="fa fa-users" aria-hidden="true"></i> Funcion&aacute;rios</a>
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
                                <li class="active"><a href="#func" data-toggle="tab"><strong>Dados do Funcion&aacute;rio</strong></a></li>
                                <li><a href="#dados" data-toggle="tab"><strong>Dados Profissionais</strong></a></li>
                                <li><a href="#benef" data-toggle="tab"><strong>Benef&iacute;cios do Funcion&aacute;rio</strong></a></li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="func">
                                    <div class="box box-wrapper-80">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CPF</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cpf?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Nascimento</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=is_array($dt_nasc) ? $dt_nasc[2].'/'.$dt_nasc[1].'/'.$dt_nasc[0] : ''?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Sexo</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=($sexo == "f" ? "Feminino" : "Masculino")?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Estado Civil</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$est_civil?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>RG</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$rg?></div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Expedi&ccedil;&atilde;o</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=is_array($dt_exp) ? $dt_exp[2].'/'.$dt_exp[1].'/'.$dt_exp[0] : ''?></div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>&Oacute;rg&atilde;o de Expedidor</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$orgao?></div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>UF do Expedidor</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$uf_exp?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome da M&atilde;e</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome_mae?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome do Pai</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$nome_pai?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=($id_status == "1" ? "Ativo" : "Inativo")?></div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="dados">
                                    <div class="box box-wrapper-80">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Matr&iacute;cula</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$matricula?></div>
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
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Per&iacute;odo</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$periodo?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>E-mail</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$email?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o da Empresa</strong></div>
                                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$end_empr_log.', nº '.$end_empr_num.', '.$end_empr_bai?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="benef">
                                    <div class="box box-wrapper-80">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr class="info">
                                                            <th class="col-xs-6 col-sm-6 col-md-8 col-lg-8">Benef&iacute;cio</th>
                                                            <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-center">Valor Unit&aacute;rio</th>
                                                            <th class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-center">Qtde Di&aacute;ria</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($benef)): ?>
                                                            <?php foreach ($benef as $value): ?>
                                                                <tr>
                                                                    <td><?=$value->descricao?></td>
                                                                    <td class="text-center"><?=isset($value->vl_unitario) ? "R$ ".number_format($value->vl_unitario, 2, ',', '.') : "R$ 0,00"?></td>
                                                                    <td class="text-center"><?=$value->qtd_diaria?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="3">Nenhum Benef&iacute;cio Adicionado</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
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
