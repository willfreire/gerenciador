Beneficio = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {
        // Botao cadastrar
        $('#btn_cad_benef').click(function(){
            var url = ""+protocol+"//"+hostname+"/"+pathproj+"/beneficio/cadastrar";
            Beneficio.redirect(url);
        });

        // Botao voltar
        $('#btn_back').click(function(){
            Beneficio.redirect('../gerenciar');
        });

        // Mascara
        $("#vl_unitario").maskMoney({
            thousands : '.',
            decimal   : ','
        });
        $("#vl_repasse_func").maskMoney({
            thousands : '.',
            decimal   : ','
        });
        $("#vl_repasse").maskMoney({
            allowNegative: true
        });

        // Beneficio Cadastrar
        $('#frm_cad_benef_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                grupo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>GRUPO</strong>'
			}
		    }
		},
                descricao: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DESCRI&Ccedil;&Atilde;O</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>DESCRI&Ccedil;&Atilde;O</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                modalidade: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>MODALIDADE</strong>'
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
                    Beneficio.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Beneficio.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }
                $('#btn_cad_benef_vt').removeAttr('disabled');
            }, 'json');

        });

        // Beneficio Editar
        $('#frm_edit_benef_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                grupo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>GRUPO</strong>'
			}
		    }
		},
                descricao: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DESCRI&Ccedil;&Atilde;O</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>DESCRI&Ccedil;&Atilde;O</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                modalidade: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>MODALIDADE</strong>'
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
            var url = "../update";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Beneficio.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Beneficio.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_benef_vt').removeAttr('disabled');
            }, 'json');

        });

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
		Beneficio.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Beneficio.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Benef&iacute;cio?",
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
                                Beneficio.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_benef_vt').DataTable().ajax.reload();
                            } else {
                                Beneficio.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                            }
                        }, 'json');
                    }
                }
            }
        });
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
    Beneficio.main();
});