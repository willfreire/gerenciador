<body class="hold-transition login-page">

    <!-- CSS Login -->
    <link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">

    <!-- JS Login -->
    <script src="<?=base_url('scripts/js/login.js')?>"></script>

    <div class="login-box container-fluid">
        
        <div class="login-logo">
            <a href="<?=base_url('/')?>">
                <img src="<?=base_url('assets/imgs/vtcards_logo.png')?>" alt="Logo VT CARDS">
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
                            <div class="col-xs-8">
                                <a href="#">Esqueci minha senha</a><br>
                            </div>
                            <div class="col-xs-4">
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
                            <div class="col-xs-8">
                                <a href="#">Esqueci minha senha</a><br>
                            </div>
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Acessar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>