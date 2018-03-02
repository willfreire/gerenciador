<?php $session_vt = $this->session->userdata(); ?>
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
                <?php if (!empty($this->session->userdata('filiais'))): ?>
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog" title="Alternar Sess&atilde;o"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><h4>Alternar Sess&atilde;o</h4></li>
                        <li>
                            <ul class="menu">
                                <li>
                                <?php if ($this->session->userdata('id_client') !== $this->session->userdata('matriz')->id_client): ?>
                                    <a href="javascript:Main.changeSession('<?=base64_encode($this->session->userdata('matriz')->id_client)?>');">
                                <?php else: ?>
                                    <a href="javascript:Main.void();" title="Sess&atilde;o Ativa">
                                <?php endif; ?>
                                        <h3 class="text-bold text-green"><?=$this->session->userdata('matriz')->cnpj_client?> - Matriz</h3>
                                        <h3 class="text-bold"><?=$this->session->userdata('matriz')->user_client?></h3>
                                    </a>
                                </li>
                                <?php foreach ($this->session->userdata('filiais') as $value): ?>
                                    <li>
                                    <?php if ($this->session->userdata('id_client') !== $value->id_client): ?>
                                        <a href="javascript:Main.changeSession('<?=base64_encode($value->id_client)?>');">
                                    <?php else: ?>
                                        <a href="javascript:Main.void();" title="Sess&atilde;o Ativa">
                                    <?php endif; ?>
                                            <h3 class="text-bold text-aqua"><?=$value->cnpj_client?> - Filial</h3>
                                            <h3 class="text-bold"><?=$value->user_client?></h3>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
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
            <li>
                <a href="<?= base_url('./empresa/editar/' . $this->session->userdata('id_client')) ?>"><i class="fa fa-building" aria-hidden="true"></i> <span>Dados Cadastrais</span></a>
            </li>
            <li>
                <a href="<?= base_url('./funcionario/gerenciar') ?>"><i class="fa fa-users" aria-hidden="true"></i> <span>Funcion&aacute;rios</span></a>
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
                    <i class="fa fa-support" aria-hidden="true"></i> <span>Ocorr&ecirc;ncias</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./ocorrencia/abrir') ?>"><i class="fa fa-circle-o"></i> Abrir Ocorr&ecirc;ncia</a></li>
                    <li><a href="<?= base_url('./ocorrencia/historico') ?>"><i class="fa fa-circle-o"></i> Hist&oacute;rico de Ocorr&ecirc;ncias</a></li>
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
                    <li><a href="<?= base_url('./pedido/solicitar') ?>"><i class="fa fa-circle-o"></i> Gerar Pedidos</a></li>
                    <li><a href="<?= base_url('./pedido/acompanhar') ?>"><i class="fa fa-circle-o"></i> Consulta de Pedidos</a></li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('./periodo/gerenciar') ?>"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Per&iacute;odos</span></a>
            </li>
            <?php /* <li class="treeview">
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
            </li> */ ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-database" aria-hidden="true"></i> <span>Relat&oacute;rio</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= base_url('./relatorio/funcionario') ?>"><i class="fa fa-circle-o"></i> Funcion&aacute;rios</a></li>
                    <li><a href="<?= base_url('./relatorio/pedido') ?>"><i class="fa fa-circle-o"></i> Pedidos</a></li>
                    <li><a href="<?= base_url('./relatorio/inconsistencia') ?>"><i class="fa fa-circle-o"></i> Inconsist&ecirc;ncias</a></li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('./main/logoff') ?>"><i class="fa fa-sign-out"></i> <span>Sair</span></a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
