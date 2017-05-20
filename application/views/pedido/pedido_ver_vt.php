<?php
# Dados do Pedido
$cnpj       = isset($pedido[0]->cnpj) ? $pedido[0]->cnpj : "";
$nome_razao = isset($pedido[0]->nome_razao) ? $pedido[0]->nome_razao : "";
$cep        = isset($pedido[0]->cep) ? " - CEP: ".$pedido[0]->cep : "";
$logradouro = isset($pedido[0]->logradouro) ? $pedido[0]->logradouro : "";
$numero     = isset($pedido[0]->numero) ? ", nº ".$pedido[0]->numero : "";
$compl      = isset($pedido[0]->complemento) ? ", ".$pedido[0]->complemento : "";
$bairro     = isset($pedido[0]->bairro) ? ", ".$pedido[0]->bairro : "";
$respons    = isset($pedido[0]->resp_recebimento) ? $pedido[0]->resp_recebimento : "";
$dt_pago    = isset($pedido[0]->dt_pago) ? $pedido[0]->dt_pago : "";
$periodo    = isset($pedido[0]->periodo) ? $pedido[0]->periodo : "";
$vl_total   = isset($pedido[0]->vl_total) ? number_format($pedido[0]->vl_total, 2, ',', '.') : "0,00";
$status     = isset($pedido[0]->status_pedido) ? $pedido[0]->status_pedido : "";
$boleto     = isset($pedido[0]->boleto) ? $pedido[0]->boleto : "";
$dt_solic   = isset($pedido[0]->dt_solic) ? $pedido[0]->dt_solic : "";
?>
<style>
    .box-footer {
        background-color: transparent;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Pedido -->
    <link rel="stylesheet" href="<?= base_url('assets/css/pedido.css') ?>">

    <!-- JS Pedido -->
    <script src="<?= base_url('scripts/js/pedido.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Visualiza&ccedil;&atilde;o de Pedido
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./pedido/gerenciar') ?>"><i class="fa fa-list" aria-hidden="true"></i> Pedidos</a>
                    </li>
                    <li class="active">Visualizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box box-wrapper-80">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>CPNJ - Raz&atilde;o Social</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$cnpj?> - <?=$nome_razao?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Endere&ccedil;o para Entrega</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$logradouro.$numero.$compl.$bairro.$cep?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Nome do Respons&aacute;vel</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$respons?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Pagamento</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dt_pago?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Per&iacute;odo do Benef&iacute;cio</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$periodo?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Benefici&aacute;rios</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>CPF</th>
                                                    <th>Funcion&aacute;rio</th>
                                                    <th>Benef&iacute;cio</th>
                                                </tr>
                                                <?php
                                                    if (is_array($benefs)):
                                                        foreach ($benefs as $value):
                                                ?>
                                                        <tr>
                                                            <td class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><?=$value->cpf?></td>
                                                            <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><?=$value->nome?></td>
                                                            <td class="col-xs-5 col-sm-5 col-md-6 col-lg-6">
                                                            <?php
                                                                if (is_array($itemben)):
                                                                    foreach ($itemben as $vl):
                                                                        if ($value->id_funcionario_fk == $vl->id_funcionario_fk) {
                                                                            $vl_un = isset($vl->vl_unitario) ? number_format($vl->vl_unitario, 2, ',', '.') : "0,00";
                                                                            echo $vl->descricao." - <strong>R$ $vl_un</strong> <br>";
                                                                        }
                                                                    endforeach;
                                                                endif;
                                                            ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Boleto Emitido</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$boleto?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data de Solicita&ccedil;&atilde;o</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$dt_solic?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Status</strong></div>
                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10"><?=$status?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center" style="padding: 0px;">
                                        <div class="box-footer">
                                            <button type="button" id="btn_back_vt" name="btn_back_vt" class="btn btn-primary">Voltar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>

                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php require_once(APPPATH . '/views/main_footer.php'); ?>

    </div>