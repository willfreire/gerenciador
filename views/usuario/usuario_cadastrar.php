<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Usuario -->
    <link rel="stylesheet" href="<?=base_url('assets/css/usuario.css')?>">

    <!-- JS Usuario -->
    <script src="<?=base_url('scripts/js/usuario.js?cache=').time()?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Usu&aacute;rio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./usuario') ?>"><i class="fa fa-user" aria-hidden="true"></i> Usu&aacute;rios</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-user">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>
                            
                            <form role="form" name="frm_cad_user_vt" id="frm_cad_user_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="nome_usuario">Nome<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Nome" maxlength="250" required="true" autofocus="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="email_usuario">E-mail<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="email_usuario" name="email_usuario" placeholder="E-mail" maxlength="250" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="senha_usuario">Senha<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Senha" maxlength="50" required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="perfil">Perfil<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <select class="form-control" name="perfil" id="perfil" required="true">
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                            if (is_array($perfil)):
                                                                foreach ($perfil as $value):
                                                                    echo "<option value='$value->id_perfil_pk'>$value->perfil</option>";
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
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="status">Status<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" checked> <div class="radio-position">Ativo</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="2"> <div class="radio-position">Inativo</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_user_vt" name="btn_cad_user_vt" class="btn btn-success">Cadastrar</button>
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