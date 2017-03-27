Login = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Mascara
        Login.onlyNumber('cnpj');
        $("#cnpj").mask('99.999.999/9999-99');
        
        // Login VT Card
        $('#frm_login_empresa').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Informe seu <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                pwd_empresa: {
                    validators: {
                        notEmpty: {
                            message: 'Digite sua <strong>Senha</strong>'
                        },
                        stringLength: {
                            min: 8,
                            max: 100,
                            message: 'Sua <strong>Senha</strong> deve ter no m&iacute;nimo <strong>8</strong> caracteres'
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
            var url = "./main/loginVT";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    //modalMsg("MENSAGEM", data.msg, false, false);
                    // Limpar Formulario
                    $('#frm_login_empresa').each(function () {
                        this.reset();
                    });
                    $('#frm_login_empresa').bootstrapValidator('resetForm', true);
                    Login.redirect("./main/dashboard");
                } else {
                    Login.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_acc_empresa').removeAttr('disabled');
            }, 'json');

        });

        // Login Cliente
        $('#frm_login_cliente').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                cnpj: {
                    validators: {
                        notEmpty: {
                            message: 'Informe seu <strong>CNPJ</strong>'
                        },
			vat: {
			    country: 'BR',
			    message: 'Digite um <strong>CNPJ</strong> v&aacute;lido'
			}
                    }
                },
                pwd_cliente: {
                    validators: {
                        notEmpty: {
                            message: 'Digite sua <strong>Senha</strong>'
                        },
                        stringLength: {
                            min: 8,
                            max: 100,
                            message: 'Sua <strong>Senha</strong> deve ter no m&iacute;nimo <strong>8</strong> caracteres'
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
            var url = "./main/loginClient";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    //Login.modalMsg("MENSAGEM", data.msg, false, false);
                    // Limpar Formulario
                    $('#frm_login_empresa').each(function () {
                        this.reset();
                    });
                    $('#frm_login_empresa').bootstrapValidator('resetForm', true);
                    Login.redirect("./main/dashboard_client");
                } else {
                    Login.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_acc_empresa').removeAttr('disabled');
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
		Login.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Login.redirect(redirect);
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
    Login.main();
});