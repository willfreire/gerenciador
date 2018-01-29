Ocorrencia = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Botao voltar
        $('#btn_back').click(function(){
            Ocorrencia.redirect('../historico');
        });
        $('#btn_back_vt').click(function(){
            Ocorrencia.redirect('../historico_all');
        });

        // Ocorrencia Cadastrar
        $('#frm_cad_ocorren').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                func: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>FUNCION&Aacute;RIO</strong>'
                        }
                    }
                },
                motivo: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>MOTIVO</strong>'
                        }
                    }
                },
                descricao: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DESCRI&Ccedil;&Atilde;O</strong>'
                        },
                        stringLength: {
                            min: 5,
                            max: 1000,
                            message: 'O campo <strong>DESCRI&Ccedil;&Atilde;O</strong> deve ter entre <strong>5</strong> a <strong>1000</strong> caracteres'
                        }
                    }
                },
                email: {
                    validators: {
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        },
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL PARA RETORNO</strong>'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = "./create";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Ocorrencia.modalMsg("MENSAGEM", data.msg, false, './historico');
                } else {
                    Ocorrencia.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_ocorren').removeAttr('disabled');
            }, 'json');

        });

        // Abrir modal para cadastrar comentario
        $("#btn_add_comment").click(function(){
            Ocorrencia.modalResp("Adicionar Mensagem");
        });

        // Limpar validacao
        $("#modal_resp").on('hidden.bs.modal', function() {
            // Limpar Validacao
            $('#frm_resp').bootstrapValidator('resetForm', true);
        });

        // Validar formulario Status
        $('#frm_resp').bootstrapValidator({
            framework : 'bootstrap',
            excluded  : ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                resposta: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>MENSAGEM</strong>'
                        },
                        stringLength: {
                            min: 5,
                            max: 1000,
                            message: 'O campo <strong>RESPOSTA</strong> deve ter entre <strong>5</strong> a <strong>1000</strong> caracteres'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = "../cadRespOcorrencia";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Msg
                    Ocorrencia.modalMsg("MENSAGEM", data.msg, false, false);
                    // Fechar Modal
                    $('#modal_resp').modal('hide');
                    // Limpar Formulario
                    $('#frm_resp').each(function () {
                        this.reset();
                    });
                    // Limpar Validacao
                    $('#frm_resp').bootstrapValidator('resetForm', true);
                    // Carregar respostas
                    Ocorrencia.getRespostas();
                } else {
                    Ocorrencia.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg);
                }
                $('#cad_resp').removeAttr('disabled');
            }, 'json');
        });

        // Limpar validacao
        $("#modal_status").on('hidden.bs.modal', function() {
            // Limpar Validacao
            $('#frm_alter_status').bootstrapValidator('resetForm', true);
        });

        // Validar formulario Status
        $('#frm_alter_status').bootstrapValidator({
            framework : 'bootstrap',
            excluded  : ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                status: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS</strong>'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = "./alterStatusOcorrencia";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Msg
                    Ocorrencia.modalMsg("MENSAGEM", data.msg, false, false);
                    // Fechar Modal
                    $('#modal_status').modal('hide');
                    // Limpar Formulario
                    $('#frm_alter_status').each(function () {
                        this.reset();
                    });
                    // Limpar Validacao
                    $('#frm_alter_status').bootstrapValidator('resetForm', true);
                    // Reload grid
                    $('#tbl_ocorr').DataTable().ajax.reload();
                } else {
                    Ocorrencia.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg);
                }
                $('#alt_status').removeAttr('disabled');
            }, 'json');
        });

    },

    /*!
     * @description Método para alterar Status
     **/
    alterStatus: function(id_ocorrencia, id_status)
    {

        // Atribuir Dados
        $('#id_ocorrencia_fk').val(id_ocorrencia);

        var sel_status = '<option value="">Selecione</option>';

        if (id_status === "1") {
            sel_status += '<option value="1" selected="selected">Solicitado</option>';
        } else {
            sel_status += '<option value="1">Solicitado</option>';
        }

        if (id_status === "2") {
            sel_status += '<option value="2" selected="selected">Em Andamento</option>';
        } else {
            sel_status += '<option value="2">Em Andamento</option>';
        }

        if (id_status === "3") {
            sel_status += '<option value="3" selected="selected">Finalizado</option>';
        } else {
            sel_status += '<option value="3">Finalizado</option>';
        }

        $('#status').html(sel_status);
        Ocorrencia.modalStatus("Alterar Status da Ocorr&ecirc;ncia");

    },

    /*!
     * @description Método para abrir modal de mensagem
     **/
    modalMsg: function (title, msg, focus, redirect) {

	$("#title_modal").html(title);
	$("#mensagem_modal").html(msg);
	$("#msg_modal").modal('show');

	if (focus) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Ocorrencia.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Ocorrencia.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para abrir modal da resposta
     **/
    modalResp: function(title)
    {
        $("#title_modal_resp").html(title);
        $("#modal_resp").modal('show');
    },

    /*!
     * @description Método para abrir modal do status
     **/
    modalStatus: function(title)
    {
        $("#title_modal_status").html(title);
        $("#modal_status").modal('show');
    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> essa Ocorr&ecirc;ncia?",
            title: "ATEN&Ccedil;&Atilde;O",
            buttons: {
                success: {
                    label: "Cancelar",
                    className: "btn-primary"
                },
                danger: {
                    label: "Excluir",
                    className: "btn-danger",
                    callback: function() {
                        // Excluir registro
                        $.post('./delete', {
                            id: id
                        },function(data){
                            if (data.status === true) {
                                Ocorrencia.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_ocorr').DataTable().ajax.reload();
                            } else {
                                Ocorrencia.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                            }
                        }, 'json');
                    }
                }
            }
        });
    },

    /*!
     * @description Método para buscar as respostas de um ocorrencia
     **/
    getRespostas: function () {
	var id_ocorrencia = $("#id_ocorrencia").val();
        // Buscar
        $.post('../getRespOcorrencias', {
            id : id_ocorrencia
        }, function(data){
            var html = '';
            if (data.status === true) {

                $.each(data.dados, function(key, value){
                    var nome       = value.nome !== "" ? value.nome : "";
                    var cnpj       = value.cnpj !== "" ? value.cnpj : "";
                    var nome_razao = value.nome_razao !== "" ? value.nome_razao : "";
                    var resposta   = value.resposta !== "" ? value.resposta : "";
                    var dt_hr      = value.dt_hr !== "" ? value.dt_hr : "";

                    if (value.id_usuario_fk !== null) {
                        html += '<div class="row">';
                        html +=     '<div class="col-xs-12">';
                        html +=         '<div class="box box-success box-wrapper-resp">';
                        html +=             '<div class="box-body">';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-12"><h4><strong>Equipe VTCards</strong></h4></div>';
                        html +=                 '</div>';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Respons&aacute;vel</strong></div>';
                        html +=                     '<div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">'+nome+'</div>';
                        html +=                 '</div>';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data</strong></div>';
                        html +=                     '<div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">'+dt_hr+'</div>';
                        html +=                 '</div>';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Mensagem</strong></div>';
                        html +=                     '<div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">'+resposta+'</div>';
                        html +=                 '</div>';
                        html +=             '</div>';
                        html +=         '</div>';
                        html +=     '</div>';
                        html += '</div>';
                    } else if (value.id_cliente_fk !== null) {
                        html += '<div class="row">';
                        html +=     '<div class="col-xs-12">';
                        html +=         '<div class="box box-warning box-wrapper-resp">';
                        html +=             '<div class="box-body">';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-12"><h4><strong>Cliente: '+nome_razao+' - CNPJ: '+cnpj+'</strong></h4></div>';
                        html +=                 '</div>';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Data</strong></div>';
                        html +=                     '<div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">'+dt_hr+'</div>';
                        html +=                 '</div>';
                        html +=                 '<div class="row">';
                        html +=                     '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><strong>Mensagem</strong></div>';
                        html +=                     '<div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">'+resposta+'</div>';
                        html +=                 '</div>';
                        html +=             '</div>';
                        html +=         '</div>';
                        html +=     '</div>';
                        html += '</div>';
                    }
                });

            } else {
                html += '<div class="row">';
                html +=     '<div class="col-xs-12">';
                html +=         '<div class="box box-danger box-wrapper-resp">';
                html +=             '<div class="box-body">';
                html +=                 '<div class="row">';
                html +=                     '<div class="col-xs-12"><h4><strong>Ainda não possui mensagem</strong></h4></div>';
                html +=                 '</div>';
                html +=             '</div>';
                html +=         '</div>';
                html +=     '</div>';
                html += '</div>';
            }
            
            $("#resp_ocorrencias").html(html);

        }, 'json');
    },

    /*!
     * @description Método colocar focus em um campo
     **/
    setFocus: function (id_field) {
	$("#" + id_field).focus();
    },

    /*!
     * @description Método redirecionamento de link
     **/
    redirect: function (link) {
        window.location.href = link;
    },

    /*!
     * @description Método abrir janela
     **/
    openWindow: function (link, target) {
	window.open(link, target);
    },

    /*!
     * @description Metodo para permitir o input de apenas numeros
     **/
    onlyNumber: function (nameField) {
	$("input[name=" + nameField + "]").keydown(function (e) {
	    if (e.shiftKey)
		e.preventDefault();
	    if (!((e.keyCode == 46) || (e.keyCode == 8) || (e.keyCode == 9) // DEL, Backspace e Tab
                    || (e.keyCode == 17) || (e.keyCode == 91) || (e.keyCode == 86) || (e.keyCode == 67) // Ctrl+C / Ctrl+V
		    || ((e.keyCode >= 35) && (e.keyCode <= 40)) // HOME, END, Setas
		    || ((e.keyCode >= 96) && (e.keyCode <= 105)) // Númerod Pad
		    || ((e.keyCode >= 48) && (e.keyCode <= 57))))
		e.preventDefault(); // Números
	});
    }

};

$(document).ready(function () {
    Ocorrencia.main();
});