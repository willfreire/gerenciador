<body class="hold-transition login-page">

    <!-- CSS Login -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">

    <!-- JS Login -->
    <script src="<?= base_url('scripts/js/login.js') ?>"></script>

    <div class="login-box container-fluid">

        <div class="login-logo">
            <a href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/imgs/vtcards_logo.png') ?>" alt="Logo VT CARDS">
            </a>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="login-box-body break_block">
                    <h3 class="login-box-msg">&Aacute;rea VT Cards Empresa</h3>
                    <form role="form" name="frm_login_empresa" id="frm_login_empresa">
                        <div class="form-group has-feedback">
                            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" maxlength="250">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="pwd_empresa" id="pwd_empresa" class="form-control" placeholder="Senha" maxlength="50">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-7 col-lg-7">
                                <a href="javascript:Main.modalPwdVt();">Esqueci a senha</a><br>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_acc_empresa">Acessar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="login-box-body">
                    <h3 class="login-box-msg">&Aacute;rea do Cliente</h3>
                    <form role="form" name="frm_login_cliente" id="frm_login_cliente">
                        <div class="form-group has-feedback">
                            <input type="cnpj" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" maxlength="18">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="pwd_cliente" id="pwd_cliente" class="form-control" placeholder="Senha" maxlength="50">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-7 col-lg-7">
                                <a href="javascript:Main.modalPwdClient();">Esqueci a senha</a><br>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_acc_client">Acessar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal_pwd_vt">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h4 class="modal-title">Nova Senha</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="frm_newpwd_vt" id="frm_newpwd_vt">
                        <div class="row">
                            <div class="col-xs-12 col-md-11">
                                <div class="form-group">
                                    <label for="email_pwd_vt">E-mail</label>
                                    <input type="email" name="email_pwd_vt" id="email_pwd_vt" class="form-control" placeholder="E-mail" maxlength="250" autocomplete="off">
                                    <input type="hidden" name="send_pwd_vt" id="send_pwd_vt" class="form-control" maxlength="50" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_new_pwd_vt">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_pwd_client">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h4 class="modal-title">Nova Senha</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="frm_newpwd_client" id="frm_newpwd_client">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <div class="form-group">
                                    <label for="cnpj_pwd_client">CNPJ</label>
                                    <input type="text" name="cnpj_pwd_client" id="cnpj_pwd_client" class="form-control" placeholder="CNPJ" maxlength="18" autocomplete="off">
                                    <input type="hidden" name="send_pwd_client" id="send_pwd_client" class="form-control" maxlength="50" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_new_pwd_client">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>