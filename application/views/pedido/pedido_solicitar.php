<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Pedido -->
    <link rel="stylesheet" href="<?= base_url('assets/css/pedido.css') ?>">

    <!-- JS Pedido -->
    <script src="<?= base_url('scripts/js/pedido.js?cache=').time() ?>"></script>

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
                    Gerar Pedidos
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./pedido') ?>"><i class="fa fa-list" aria-hidden="true"></i> Pedidos</a>
                    </li>
                    <li class="active">Solicitar</li>
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

                            <form role="form" name="frm_cad_pedido" id="frm_cad_pedido">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="id_empresa">CNPJ - Raz&atilde;o Social<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="id_empresa" id="id_empresa" required="true">
                                                        <?php
                                                        if (is_array($empresa)):
                                                            foreach ($empresa as $value):
                                                                echo "<option value='$value->id_empresa_pk'>$value->cnpj - $value->nome_razao</option>";
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
                                                <label for="id_end_entrega">Endere&ccedil;o para Entrega<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="id_end_entrega" id="id_end_entrega" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($end_entrega)):
                                                            foreach ($end_entrega as $value):
                                                                echo "<option value='$value->id_endereco_empresa_pk' selected='selected'>$value->logradouro, nº $value->numero, $value->bairro - CEP: $value->cep</option>";
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
                                                <label for="nome_resp">Nome do Respons&aacute;vel<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_resp" name="nome_resp" placeholder="Nome do Respons&aacute;vel" maxlength="250" value="<?= isset($empresa[0]->resp_recebimento) ? $empresa[0]->resp_recebimento : '' ?>" required="true">
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
                                                        <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_pgto" id="dt_pgto" placeholder="dd/mm/aaaa" value="" maxlength="10" readonly required="true">
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
                                                        <input type="text" class="form-control" name="periodo" id="periodo" placeholder="dd/mm/aaaa - dd/mm/aaaa" value="" maxlength="23" readonly required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_pedido" name="btn_cad_pedido" class="btn btn-success">Prosseguir</button>
                                    <button type="reset" id="limpar" name="limpar" class="btn btn-primary">Limpar</button>
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
