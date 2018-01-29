Aviso = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Botao voltar
        $('#btn_back').click(function(){
            Aviso.redirect('../gerenciar');
        });

        // Aviso Cadastrar
        $('#frm_cad_aviso').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                titulo: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>T&Iacute;TULO</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>T&Iacute;TULO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                descricao: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DESCRI&Ccedil;&Atilde;O</strong>'
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
                    Aviso.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Aviso.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_aviso').removeAttr('disabled');
            }, 'json');

        });

        // Aviso Editar
        $('#frm_edit_aviso').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                titulo: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>T&Iacute;TULO</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>T&Iacute;TULO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                descricao: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DESCRI&Ccedil;&Atilde;O</strong>'
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
                    Aviso.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Aviso.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_aviso').removeAttr('disabled');
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
		Aviso.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Aviso.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Aviso?",
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
                                Aviso.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_aviso').DataTable().ajax.reload();
                            } else {
                                Aviso.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
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
    Aviso.main();
});