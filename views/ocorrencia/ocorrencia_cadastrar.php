<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Ocorrencia -->
    <link rel="stylesheet" href="<?=base_url('assets/css/ocorrencia.css')?>">

    <!-- JS Ocorrencia -->
    <script src="<?=base_url('scripts/js/ocorrencia.js')?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_client.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gerar Ocorr&ecirc;ncia
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./ocorrencia') ?>"><i class="fa fa-support" aria-hidden="true"></i> Ocorr&ecirc;ncias</a>
                    </li>
                    <li class="active">Abrir</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-ocorren">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>
                            
                            <form role="form" name="frm_cad_ocorren" id="frm_cad_ocorren">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                <label for="func">Funcion&aacute;rio<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="func" id="func" required="true" autofocus="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($funcs)):
                                                            foreach ($funcs as $value):
                                                                echo "<option value='$value->id_funcionario_pk'>$value->nome - CPF: $value->cpf</option>";
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
                                            <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">
                                                <label for="motivo">Motivo<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="motivo" id="motivo" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        if (is_array($motivos)):
                                                            foreach ($motivos as $value):
                                                                echo "<option value='$value->id_ocorr_motivo_pk'>$value->ocorr_motivo</option>";
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
                                                <label for="descricao">Descri&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descri&ccedil;&atilde;o" maxlength="1000" rows="5" required="true"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                <label for="email">E-mail para Retorno<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <p class="text-bold text-danger">Obs: O prazo para a resposta desta ocorr&ecirc;ncia ser&aacute; de at&eacute; 24 horas.</p>
                                    <button type="submit" id="btn_cad_ocorren" name="btn_cad_ocorren" class="btn btn-success">Cadastrar</button>
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