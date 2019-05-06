<body class="hold-transition skin-blue sidebar-mini">

    <!-- CSS Cliente -->
    <link rel="stylesheet" href="<?= base_url('assets/css/cliente.css') ?>">

    <!-- JS Cliente -->
    <script src="<?= base_url('scripts/js/cliente.js?cache=').time() ?>"></script>

    <div class="wrapper">

        <!-- Menu -->
        <?php require_once(APPPATH . '/views/menu_vt.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cadastro de Cliente
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= base_url('./main/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('./cliente') ?>"><i class="fa fa-users" aria-hidden="true"></i> Clientes</a>
                    </li>
                    <li class="active">Cadastrar</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="container-fluid box box-primary" id="box-frm-client">

                            <div class="box-header with-border">
                                <span class="text-danger">*</span> Campo com preenchimento obrigat&oacute;rio
                            </div>

                            <form role="form" name="frm_cad_client_vt" id="frm_cad_client_vt">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#empresa" data-toggle="tab"><strong>Dados do Cliente</strong></a></li>
                                        <li><a href="#ender" data-toggle="tab"><strong>Endere&ccedil;o da Empresa</strong></a></li>
                                        <li><a href="#contato" data-toggle="tab"><strong>Contato na Empresa</strong></a></li>
                                        <li><a href="#cond_comer" data-toggle="tab"><strong>Condi&ccedil;&atilde;o Comercial</strong></a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="empresa">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="plano">Plano Contratado<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="plano" id="plano" value="1"> <div class="radio-position">Plano Plus</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="plano" id="plano" value="2"> <div class="radio-position">Plano Plus + Roteiriza&ccedil;&atilde;o</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="importar_prospec">Importar Dados da Prospec&ccedil;&atilde;o?<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="importar_prospec" id="importar_prospec" value="1"> <div class="radio-position">Sim</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="importar_prospec" id="importar_prospec" value="2"> <div class="radio-position">N&atilde;o</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group hidden" id="div_prospec">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="empr_prospec">Empresa da Prospec&ccedil;&atilde;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="empr_prospec" id="empr_prospec">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($mailing)):
                                                                        foreach ($mailing as $value):
                                                                            echo "<option value='$value->id_mailing_pk'>$value->razao_social - $value->cnpj</option>";
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
                                                            <label for="tp_empresa">Tipo de Empresa<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="1"> <div class="radio-position">Matriz</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_empresa" id="tp_empresa" value="2"> <div class="radio-position">Filial</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group hidden" id="div_matriz">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="matriz">Selecione a Matriz<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="matriz" id="matriz">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($matriz)):
                                                                        foreach ($matriz as $value):
                                                                            echo "<option value='$value->id_empresa_pk'>$value->nome_razao - $value->cnpj</option>";
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
                                                            <label for="cnpj">CNPJ<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" maxlength="18" value="" required="true">
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
                                                            <label for="nome_fantasia">Nome Fantasia</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="Nome Fantasia" maxlength="250">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="insc_estadual">Inscri&ccedil;&atilde;o Estadual</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="insc_estadual" name="insc_estadual" placeholder="Inscri&ccedil;&atilde;o Estadual" maxlength="20">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-10 col-sm-8 col-md-5 col-lg-4">
                                                            <label for="inscr_municipal">Inscri&ccedil;&atilde;o Municipal</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="inscr_municipal" name="inscr_municipal" placeholder="Inscri&ccedil;&atilde;o Municipal" maxlength="20">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="atividade">Ramo de Atividade<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="atividade" id="atividade" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($atividades)):
                                                                        foreach ($atividades as $value):
                                                                            echo "<option value='$value->id_ramo_atividade_pk'>$value->ramo_atividade</option>";
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
                                                            <label for="email_adicional">E-mail Adicional</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_adicional" name="email_adicional" placeholder="E-mail Adicional" maxlength="250">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
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
                                                            <label for="email_primario">E-mail Prim&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_primario" name="email_primario" placeholder="E-mail Prim&aacute;rio" maxlength="250">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_secundario">E-mail Segund&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_secundario" name="email_secundario" placeholder="E-mail Segund&aacute;rio" maxlength="250">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="senha_cliente">Senha<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="Senha" maxlength="50" required="true" autocomplete="off">
                                                                <input type="button" class="btn btn-primary" id="gen_pwd" name="gen_pwd" value="Gerar Senha">
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
                                        </div>

                                        <div class="tab-pane" id="ender">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="tp_endereco">Tipo de Endere&ccedil;o<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_endereco" id="tp_endereco" value="1"> <div class="radio-position">Entrega</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="tp_endereco" id="tp_endereco" value="2"> <div class="radio-position">Faturamento</div>
                                                                </label>
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
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="resp_receb">Respons&aacute;vel pelo Recebimento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="resp_receb" name="resp_receb" placeholder="Respons&aacute;vel pelo Recebimento" maxlength="250" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="contato">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label for="nome_contato">Nome do Contato<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="nome_contato" name="nome_contato" placeholder="Nome do Contato" maxlength="250" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                            <label for="depto">Departamento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="depto" id="depto" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($dpto)):
                                                                        foreach ($dpto as $value):
                                                                            echo "<option value='$value->id_departamento_pk'>$value->departamento</option>";
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
                                                            <label for="cargo">Cargo<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select class="form-control" name="cargo" id="cargo" required="true">
                                                                    <option value="">Selecione</option>
                                                                    <?php
                                                                    if (is_array($cargo)):
                                                                        foreach ($cargo as $value):
                                                                            echo "<option value='$value->id_cargo_pk'>$value->cargo</option>";
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
                                                            <label for="sexo">Sexo<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="sexo" id="sexo" value="m"> <div class="radio-position">Masculino</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="sexo" id="sexo" value="f"> <div class="radio-position">Feminino</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-5 col-md-5 col-lg-4">
                                                            <label for="dt_nasc">Data de Nascimento<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="dt_nasc" id="dt_nasc" placeholder="dd/mm/aaaa" value="" maxlength="10" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                                                            <label for="resp_compra">Respons&aacute;vel pela Compra?<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="resp_compra" id="resp_compra" value="s"> <div class="radio-position">Sim</div>
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="resp_compra" id="resp_compra" value="n"> <div class="radio-position">N&atilde;o</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_pri_contato">E-mail Principal<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_pri_contato" name="email_pri_contato" placeholder="E-mail Principal" maxlength="250" value="" required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-10 col-md-9 col-lg-8">
                                                            <label for="email_sec_contato">E-mail Segund&aacute;rio</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" id="email_sec_contato" name="email_sec_contato" placeholder="E-mail Segund&aacute;rio" maxlength="250" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="cond_comer">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title">Taxas - Vale Transporte</h4>
                                                        </div>
                                                        <div class="box-body">

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm">Taxa Administrativa</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm" name="taxa_adm" placeholder="0.00" maxlength="6" value="0.00">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_entrega">Taxa de Entrega</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon text-bold">R$</span>
                                                                                <input type="text" class="form-control" id="taxa_entrega" name="taxa_entrega" placeholder="0,00" maxlength="9" value="0,00">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_fixa_perc">Taxa Fixa %</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_fixa_perc" name="taxa_fixa_perc" placeholder="0.00" maxlength="6" value="0.00">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_fixa_real">Taxa Fixa R$</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon text-bold">R$</span>
                                                                                <input type="text" class="form-control" id="taxa_fixa_real" name="taxa_fixa_real" placeholder="0,00" maxlength="9" value="0,00">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title">Taxas - Outros Produtos</h4>
                                                        </div>
                                                        <div class="box-body">

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_cr">Taxa Administrativa - Cart&atilde;o Refei&ccedil;&atilde;o</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_cr" name="taxa_adm_cr" placeholder="0.00" maxlength="6" value="0.00">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_ca">Taxa Administrativa - Cart&atilde;o Alimenta&ccedil;&atilde;o</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_ca" name="taxa_adm_ca" placeholder="0.00" maxlength="6" value="0.00">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                                        <label for="taxa_adm_cc">Taxa Administrativa - Cart&atilde;o Combust&iacute;vel</label>
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="taxa_adm_cc" name="taxa_adm_cc" placeholder="0.00" maxlength="6" value="0.00">
                                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" id="btn_cad_client_vt" name="btn_cad_client_vt" class="btn btn-success">Cadastrar</button>
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
