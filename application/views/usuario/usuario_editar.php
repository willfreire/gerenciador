<?php
# Dados do usuário
$id        = isset($usuario[0]->id_usuario_pk) ? $usuario[0]->id_usuario_pk : "";
$nome      = isset($usuario[0]->nome) ? $usuario[0]->nome : "";
$email     = isset($usuario[0]->email) ? $usuario[0]->email : "";
$id_perfil = isset($usuario[0]->id_perfil_fk) ? $usuario[0]->id_perfil_fk : "";
$id_status = isset($usuario[0]->id_status_fk) ? $usuario[0]->id_status_fk : "";
?>

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
                    Edi&ccedil;&atilde;o de Usu&aacute;rio
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./usuario') ?>"><i class="fa fa-user" aria-hidden="true"></i> Usu&aacute;rios</a>
                    </li>
                    <li class="active">Editar</li>
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

                            <form role="form" name="frm_edit_user_vt" id="frm_edit_user_vt">

                                <div class="box-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label for="nome_usuario">Nome<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Nome" maxlength="250" required="true" autofocus="true" value="<?=$nome?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                <label for="email_usuario">E-mail<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="email_usuario" name="email_usuario" placeholder="E-mail" maxlength="250" required="true" value="<?=$email?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="alt_senha">Alterar Senha?</label>
                                                <div class="controls">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="alt_senha" id="alt_senha" value="1"> Sim
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="senha_usuario">Senha</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Senha" maxlength="50" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($this->session->userdata('id_perfil_vt') == "1"): ?>
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
                                                                    $sel = $id_perfil == $value->id_perfil_pk ? "selected='selected'" : "";
                                                                    echo "<option value='$value->id_perfil_pk' $sel>$value->perfil</option>";
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <input type="hidden" id="perfil" name="perfil" value="<?=$id_perfil?>">
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('id_perfil_vt') == "1"): ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                <label for="status">Status<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" <?=$id_status == "1" ? "checked='checked'" : ""?>> <div class="radio-position">Ativo</div>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="2" <?=$id_status == "2" ? "checked='checked'" : ""?>> <div class="radio-position">Inativo</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <input type="hidden" id="status" name="status" value="<?=$id_status?>">
                                    <?php endif; ?>

                                </div>

                                <div class="box-footer">
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$id?>">
                                    <button type="submit" id="btn_cad_user_vt" name="btn_edit_user_vt" class="btn btn-success">Alterar</button>
                                    <button type="button" id="btn_back" name="btn_back" class="btn btn-primary">Voltar</button>
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