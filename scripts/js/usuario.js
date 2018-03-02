Usuario = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {
        // Botao cadastrar
        $('#btn_cad_usu').click(function(){
            var url = ""+protocol+"//"+hostname+"/"+pathproj+"/usuario/cadastrar";
            Usuario.redirect(url);
        });

        // Botao voltar
        $('#btn_back').click(function(){
            Usuario.redirect('../gerenciar');
        });

        // Habilitar campo senha
        $("#alt_senha").click(function(){
            if ($("#alt_senha:checked").val() === "1") {
                $("#senha_usuario").removeAttr('disabled');
                Usuario.setFocus('senha_usuario');
            } else {
                $("#senha_usuario").val('');
                $("#senha_usuario").attr('disabled', 'disabled');
            }
        });

        // Usuario Cadastrar VT Card
        $('#frm_cad_user_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome_usuario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>NOME</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                email_usuario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                senha_usuario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>SENHA</strong>'
                        },
                        stringLength: {
                            min: 8,
                            max: 50,
                            message: 'O campo <strong>SENHA</strong> deve ter entre <strong>8</strong> e <strong>50</strong> caracteres'
                        }
                    }
                },
                perfil: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PERFIL</strong>'
			}
		    }
		},
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
            var url = "./create";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Usuario.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Usuario.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_user_vt').removeAttr('disabled');
            }, 'json');

        });

        // Usuario Editar VT Card
        $('#frm_edit_user_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome_usuario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>NOME</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                email_usuario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                senha_usuario: {
                    validators: {
                        callback: {
                            callback: function (value, validator, $field) {
                                var alt_pwd = $('#alt_senha').is(':checked');
                                if (alt_pwd === true && value.length < 8) {
                                    return {
                                        valid   : false,
                                        message : 'O campo <strong>SENHA</strong> deve ter entre <strong>8</strong> e <strong>50</strong> caracteres'
                                    };
                                }
                                return true;
                            }
                        }
                    }
                },
                perfil: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PERFIL</strong>'
			}
		    }
		},
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
            var url = "../update";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Usuario.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Usuario.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_user_vt').removeAttr('disabled');
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
		Usuario.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Usuario.redirect(redirect);
		e.preventDefault();
	    });
	}

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
    Usuario.main();
});