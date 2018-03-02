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
                        <span class="hidden-xs"><?=$this->session->userdata('user_st')?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                <strong><?=$this->session->userdata('user_vt')?><br></strong>
                                <strong>Perfil:</strong> <?=$this->session->userdata('perfil_vt')?>
                                <small><strong>Data de Cadastro:</strong> <?=$this->session->userdata('dt_cad_vt')?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?=base_url('./usuario/ver/'.$this->session->userdata('id_vt'))?>" class="btn btn-success btn-flat">Dados Cadastrais</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=base_url('./main/logoff')?>" class="btn btn-danger btn-flat">Sair</a>
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
                <a href="<?=base_url('./main/dashboard')?>"><i class="fa fa-dashboard"></i> <span>Quadro Geral</span></a>
            </li>
            <li>
                <a href="<?=base_url('./aviso/gerenciar')?>"><i class="fa fa-warning" aria-hidden="true"></i> <span>Avisos</span></a>
            </li>
            <li>
                <a href="<?=base_url('./beneficio/gerenciar')?>"><i class="fa fa-bus" aria-hidden="true"></i> <span>Benef&iacute;cios</span></a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users" aria-hidden="true"></i> <span>Clientes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./cliente/cadastrar')?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?=base_url('./cliente/gerenciar')?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <?php if ($this->session->userdata('id_perfil_vt') == "2"): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user" aria-hidden="true"></i> <span>Dados Cadastrais</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./usuario/editar/'.$this->session->userdata('id_vt'))?>"><i class="fa fa-circle-o"></i> Editar</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money" aria-hidden="true"></i> <span>Financeiro</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./financeiro/boleto')?>"><i class="fa fa-circle-o"></i> Boletos</a></li>
                    <li>
                        <a href="#"><i class="fa fa-arrow-circle-right text-aqua"></i> Remessa
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('./remessa/gerar') ?>"><i class="fa fa-circle-o"></i> Gerar</a></li>
                            <!-- <li><a href="<?= base_url('./remessa/retorno') ?>"><i class="fa fa-circle-o"></i> Importar Retorno</a></li> -->
                            <li><a href="<?= base_url('./remessa/ver_envio') ?>"><i class="fa fa-circle-o"></i> Ver Envios</a></li>
                            <!-- <li><a href="<?= base_url('./remessa/ver_retorno') ?>"><i class="fa fa-circle-o"></i> Ver Retorno</a></li> -->
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building" aria-hidden="true"></i> <span>Fornecedor</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./fornecedor/cadastrar')?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?=base_url('./fornecedor/gerenciar')?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Mailing</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./mailing/cadastrar')?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?=base_url('./mailing/gerenciar')?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-support" aria-hidden="true"></i> <span>Ocorr&ecirc;ncias</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./ocorrencia/historico_all') ?>"><i class="fa fa-circle-o"></i> Hist&oacute;rico de Ocorr&ecirc;ncias</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list" aria-hidden="true"></i> <span>Pedidos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./pedido/selecionar') ?>"><i class="fa fa-circle-o"></i> Solicitar</a></li>
                    <li><a href="<?= base_url('./pedido/gerenciar') ?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Prospec&ccedil;&atilde;o</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./prospeccao/cadastrar')?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?=base_url('./prospeccao/gerenciar')?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-database" aria-hidden="true"></i> <span>Relat&oacute;rio</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./relatorio/funcionario_vt') ?>"><i class="fa fa-circle-o"></i> Relat&oacute;rio de Funcion&aacute;rios</a></li>
                    <li><a href="<?= base_url('./relatorio/pedido_vt') ?>"><i class="fa fa-circle-o"></i> Relat&oacute;rio de Pedidos</a></li>
                    <li><a href="<?= base_url('./relatorio/inconsistencia_vt') ?>"><i class="fa fa-circle-o"></i> Relat&oacute;rio de Inconsist&ecirc;ncias</a></li>
                </ul>
            </li>
            <?php if ($this->session->userdata('id_perfil_vt') == "1"): ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user" aria-hidden="true"></i> <span>Usu&aacute;rios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('./usuario/cadastrar')?>"><i class="fa fa-circle-o"></i> Cadastrar</a></li>
                    <li><a href="<?=base_url('./usuario/gerenciar')?>"><i class="fa fa-circle-o"></i> Gerenciar</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <li>
                <a href="<?=base_url('./main/logoff')?>"><i class="fa fa-sign-out"></i> <span>Sair</span></a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
