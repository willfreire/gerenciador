<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('./') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" title="VTCards"><b>VT</b>C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="<?= base_url('assets/imgs/vtcards_logo_100x40.png') ?>" alt="Logo VTCards" title="VTCards" />
        </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= $this->session->userdata('user_st_client') ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                <strong><?= $this->session->userdata('user_client') ?><br></strong>
                                <strong>Perfil:</strong> <?= $this->session->userdata('tipo_client') ?>
                                <small><strong>Data de Cadastro:</strong> <?= $this->session->userdata('dt_cad_client') ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url('./empresa/ver/' . $this->session->userdata('id_client')) ?>" class="btn btn-success btn-flat">Dados Cadastrais</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= base_url('./main/logoff') ?>" class="btn btn-danger btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <li>
                <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Quadro de Avisos</span></a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building" aria-hidden="true"></i> <span>Dados Cadastrais</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./empresa/editar/' . $this->session->userdata('id_client')) ?>"><i class="fa fa-circle-o"></i> Editar Dados Cadastrais</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users" aria-hidden="true"></i> <span>Funcion&aacute;rios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./funcionario/cadastrar') ?>"><i class="fa fa-circle-o"></i> Cadastrar Funcion&aacute;rio</a></li>
                    <li><a href="<?= base_url('./funcionario/gerenciar') ?>"><i class="fa fa-circle-o"></i> Funcion&aacute;rios Cadastrados</a></li>
                </ul>
            </li>
            <?php /* <li class="treeview">
                <a href="#">
                    <i class="fa fa-credit-card" aria-hidden="true"></i> <span>Benef&iacute;cio - Cart&atilde;o</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./beneficiocartao/cadastrar') ?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?= base_url('./beneficiocartao/gerenciar') ?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li> */ ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list" aria-hidden="true"></i> <span>Pedidos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./pedido/solicitar') ?>"><i class="fa fa-circle-o"></i> Gerar Pedidos</a></li>
                    <li><a href="<?= base_url('./pedido/acompanhar') ?>"><i class="fa fa-circle-o"></i> Consulta de Pedidos</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>Per&iacute;odos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./periodo/cadastrar') ?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?= base_url('./periodo/gerenciar') ?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-upload" aria-hidden="true"></i> <span>Importa&ccedil;&atilde;o</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./importacao/geral') ?>"><i class="fa fa-circle-o"></i> Importar Arquivo</a></li>
                    <li><a href="<?= base_url('./importacao/historico') ?>"><i class="fa fa-circle-o"></i> Hist&oacute;rico de Importa&ccedil;&atilde;o</a></li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('./main/logoff') ?>"><i class="fa fa-sign-out"></i> <span>Sair</span></a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>