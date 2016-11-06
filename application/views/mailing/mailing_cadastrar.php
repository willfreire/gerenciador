<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Mailing -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mailing.css') ?>">

    <!-- JS Mailing -->
    <script src="<?= base_url('scripts/js/mailing.js') ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Mailing
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./mailing') ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Mailings</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-mail">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_mail_vt" id="frm_cad_mail_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="cnpj">CNPJ<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" maxlength="18" value="" required="true" autofocus="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="razao_social">Raz&atilde;o Social<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Raz&atilde;o Social" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="endereco">Endere&ccedil;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endere&ccedil;o" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7 col-sm-5 col-md-5 col-lg-4">
                                                <label for="numero">N&uacute;mero<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="N&uacute;mero" maxlength="15" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="complemento">Complemento</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento" maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                                <label for="bairro">Bairro<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" maxlength="25">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7 col-sm-5 col-md-5 col-lg-4">
                                                <label for="cep">CEP<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" maxlength="9" required="true">
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
                                                                $sel = $value->id_estado_pk == 26 ? "selected='selected'" : "";
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
                                                                $sel = $value->id_cidade_pk == 5346 ? "selected='selected'" : "";
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
                                            <div class="col-xs-8 col-sm-5 col-md-5 col-lg-4">
                                                <label for="tel">Telefone<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="(ddd) + n&uacute;mero" maxlength="15" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="email">E-mail<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="site">Site</label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">http://</span>
                                                        <input type="text" class="form-control" id="site" name="site" placeholder="www.teste.com.br" maxlength="100" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_mail_vt" name="btn_cad_mail_vt" class="btn btn-primary">Cadastrar</button>
                                    <button type="reset" id="limpar" name="limpar" class="btn btn-danger">Limpar</button>
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