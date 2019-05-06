<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Roteirizacao -->
    <link rel="stylesheet" href="<?= base_url('assets/css/roteirizacao.css') ?>">

    <!-- JS Roteirizacao -->
    <script src="<?= base_url('scripts/js/roteirizacao.js?cache=') . time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Roteiriza&ccedil;&atilde;o de Funcion&aacute;rio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./roteirizacao/consultar') ?>"><i class="fa fa-map" aria-hidden="true"></i> Roteiriza&ccedil;&atilde;o</a>
                    </li>
                    <li class="active">Nova Roteiriza&ccedil;&atilde;o</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-roteiriza">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_roteiriza" id="frm_cad_roteiriza">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="endereco_empresa">Local de Trabalho<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="endereco_empresa" id="endereco_empresa">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($enderecos)):
                                                            foreach ($enderecos as $value):
                                                                $endereco = array();
                                                                $endereco[] = $value->logradouro;
                                                                $endereco[] = $value->numero;
                                                                if ($value->complemento != ""):
                                                                    $endereco[] = $value->complemento;
                                                                endif;
                                                                $endereco[] = $value->bairro;
                                                                $endereco[] = $value->cidade;
                                                                $endereco[] = $value->estado;
                                                                $endereco[] = "CEP: " . $value->cep;
                                                                echo "<option value='$value->id_endereco_empresa_pk'>" . implode(", ", $endereco) . "</option>";
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
                                                <label for="cpf">CPF<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" maxlength="14" value="" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="nome_func">Nome<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_func" name="nome_func" placeholder="Nome" maxlength="250" required="true">
                                                    <input type="hidden" id="id_funcionario" name="id_funcionario" value="">
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
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
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
                                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" maxlength="25" required="true">
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
                                            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-3">
                                                <label for="vl_solicitado">Valor Solicitado por Dia<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>R$</strong></span>
                                                        <input type="text" class="form-control" id="vl_solicitado" name="vl_solicitado" placeholder="0,00" maxlength="5" value="" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_roteiriza" name="btn_cad_roteiriza" class="btn btn-success">Processar</button>
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
