<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Beneficio/Cartao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/beneficio_cartao.css') ?>">

    <!-- JS Beneficio/Cartao -->
    <script src="<?= base_url('scripts/js/beneficio_cartao.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Benef&iacute;cio - Cart&atilde;o
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./beneficiocartao/gerenciar') ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Benef&iacute;cios - Cart&otilde;es</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-bencard">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_bencard" id="frm_cad_bencard">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="func">Funcion&aacute;rio<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="func" id="func" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($funcs)):
                                                            foreach ($funcs as $value):
                                                                echo "<option value='$value->id_funcionario_pk'>$value->nome</option>";
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
                                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                                <label for="beneficio">Benef&iacute;cio<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control select2" name="beneficio" id="beneficio" required="true">
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
                                            <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">
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
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
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
                                                <div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
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
                                                <div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
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
                                    <button type="submit" id="btn_cad_bencard" name="btn_cad_bencard" class="btn btn-success">Cadastrar</button>
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