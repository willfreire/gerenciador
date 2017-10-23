<?php
# Dados do Pedido
$id           = isset($pedido[0]->id_pedido_pk) ? $pedido[0]->id_pedido_pk : "";
$id_cliente   = isset($pedido[0]->id_empresa_fk) ? $pedido[0]->id_empresa_fk : "";
$cnpj         = isset($empresa[0]->cnpj) ? $empresa[0]->cnpj : "";
$razao_social = isset($empresa[0]->nome_razao) ? $empresa[0]->nome_razao : "";
$taxa_adm     = isset($empresa[0]->taxa_adm) ? $empresa[0]->taxa_adm : "";
$taxa_entrega = isset($empresa[0]->taxa_entrega) ? $empresa[0]->taxa_entrega : "";
$taxa_fx_perc = isset($empresa[0]->taxa_fixa_perc) ? $empresa[0]->taxa_fixa_perc : "";
$taxa_fx_real = isset($empresa[0]->taxa_fixa_real) ? $empresa[0]->taxa_fixa_real : "";
$logradouro   = isset($end_entrega[0]->logradouro) ? $end_entrega[0]->logradouro : "";
$numero       = isset($end_entrega[0]->numero) ? $end_entrega[0]->numero : "";
$bairro       = isset($end_entrega[0]->bairro) ? $end_entrega[0]->bairro : "";
$cep          = isset($end_entrega[0]->cep) ? $end_entrega[0]->cep : "";
$nome_resp    = isset($end_entrega[0]->resp_recebimento) ? $end_entrega[0]->resp_recebimento : "";
$dt_pgto      = isset($pedido[0]->dt_pgto) ? explode("-", $pedido[0]->dt_pgto) : "";
$periodo_ini  = isset($pedido[0]->dt_ini_beneficio) ? explode("-", $pedido[0]->dt_ini_beneficio) : "";
$dt_per_ini   = is_array($periodo_ini) ? $periodo_ini[2] . '/' . $periodo_ini[1] . '/' . $periodo_ini[0] : '';
$periodo_fin  = isset($pedido[0]->dt_fin_beneficio) ? explode("-", $pedido[0]->dt_fin_beneficio) : "";
$dt_per_fin   = is_array($periodo_fin) ? $periodo_fin[2] . '/' . $periodo_fin[1] . '/' . $periodo_fin[0] : '';
$valor_itens  = isset($vl_itens) && $vl_itens != "" ? "R$ ".number_format($vl_itens, 2, ',', '.') : "R$ 0,00";
$valor_taxa   = isset($vl_taxa) && $vl_taxa != "" ? "R$ ".number_format($vl_taxa, 2, ',', '.') : "R$ 0,00";
$valor_repass = isset($vl_repasse) && $vl_repasse != "" ? "R$ ".number_format($vl_repasse, 2, ',', '.') : "R$ 0,00";
$valor_repas  = isset($vl_repasse) && $vl_repasse != "" ? $vl_repasse : "0.00";
$valor_total  = isset($vl_total) && $vl_total != "" ? "R$ ".number_format($vl_total, 2, ',', '.') : "R$ 0,00";
?>
<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Pedido -->
    <link rel="stylesheet" href="<?= base_url('assets/css/pedido.css') ?>">

    <!-- JS Pedido -->
    <script src="<?= base_url('scripts/js/pedido.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php if ($this->session->userdata('user_vt')): ?>
            <?php require_once(APPPATH . '/views/menu_vt.php'); ?>
        <?php else: ?>
            <?php require_once(APPPATH . '/views/menu_client.php'); ?>
        <?php endif; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Finaliza&ccedil;&atilde;o de Pedido
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./pedido') ?>"><i class="fa fa-list" aria-hidden="true"></i> Pedidos</a>
                    </li>
                    <li class="active">Finalizar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-pedido">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_edit_pedido" id="frm_edit_pedido">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="id_empresa">CNPJ - Raz&atilde;o Social</label>
                                                <div class="controls">
                                                    <?= $cnpj ?> - <?= $razao_social ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="id_end_entrega">Endere&ccedil;o para Entrega</label>
                                                <div class="controls">
                                                    <?= $logradouro ?>,  nº <?= $numero ?>, <?= $bairro ?> - CEP: <?= $cep ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="nome_resp">Nome do Respons&aacute;vel</label>
                                                <div class="controls">
                                                    <?= $nome_resp ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
                                                <label for="dt_pgto">Data de Pagamento<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_pgto" id="dt_pgto" placeholder="dd/mm/aaaa" value="<?= is_array($dt_pgto) ? $dt_pgto[2] . '/' . $dt_pgto[1] . '/' . $dt_pgto[0] : '' ?>" maxlength="10" readonly required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                                                <label for="periodo">Per&iacute;odo de Utiliza&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" name="periodo" id="periodo" placeholder="dd/mm/aaaa - dd/mm/aaaa" value="<?= ($dt_per_ini != "" && $dt_per_fin != "" ) ? $dt_per_ini . ' - ' . $dt_per_fin : '' ?>" maxlength="23" readonly required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th class="danger col-xs-4 col-sm-4 col-md-2 col-lg-2">VALOR BENEF&Iacute;CIOS</th>
                                                        <td class="col-xs-8 col-sm-8 col-md-10 col-lg-10"><strong><?=$valor_itens?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="danger col-xs-4 col-sm-4 col-md-2 col-lg-2">VALOR TAXAS</th>
                                                        <td class="col-xs-8 col-sm-8 col-md-10 col-lg-10"><strong><?=$valor_taxa?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="danger col-xs-4 col-sm-4 col-md-2 col-lg-2">VALOR DE REPASSE</th>
                                                        <td class="col-xs-8 col-sm-8 col-md-10 col-lg-10"><strong><?=$valor_repass?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="danger col-xs-4 col-sm-4 col-md-2 col-lg-2">VALOR TOTAL</th>
                                                        <td class="col-xs-8 col-sm-8 col-md-10 col-lg-10"><strong><?=$valor_total?></strong></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (is_array($beneficiario)):
                                        foreach ($beneficiario as $value):
                                    ?>
                                        <input type="hidden" name="id_funcionario[]" id="id_funcionario_<?=$value->id_funcionario_pk?>" value="<?=$value->id_funcionario_pk?>">
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_pedido" name="id_pedido" value="<?=$id?>">
                                    <input type="hidden" id="taxa_adm" name="taxa_adm" value="<?=$taxa_adm?>">
                                    <input type="hidden" id="taxa_entrega" name="taxa_entrega" value="<?=$taxa_entrega?>">
                                    <input type="hidden" id="taxa_repasse" name="taxa_repasse" value="<?=$valor_repas?>">
                                    <input type="hidden" id="taxa_fixa_perc" name="taxa_fixa_perc" value="<?=$taxa_fx_perc?>">
                                    <input type="hidden" id="taxa_fixa_real" name="taxa_fixa_real" value="<?=$taxa_fx_real?>">
                                    <input type="hidden" id="id_cliente" name="id_cliente" value="<?=$id_cliente?>">
                                    <button type="submit" id="btn_edit_pedido" name="btn_edit_pedido" class="btn btn-success">Finalizar</button>
                                    <button type="button" id="btn_cancel" name="btn_cancel" class="btn btn-primary" onclick="Pedido.delBtnCancel('<?=$id?>')">Cancelar</button>
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