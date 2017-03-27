Main = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Gerar senha
        $('#email_pwd_vt').pGenerator({
            'bind'            : 'click',
            'passwordElement' : '#send_pwd_vt',
            'displayElement'  : '#send_pwd_vt',
            'passwordLength'  : 8,
            'uppercase'       : true,
            'lowercase'       : true,
            'numbers'         : true,
            'specialChars'    : false
        });
        $('#cnpj_pwd_client').pGenerator({
            'bind'            : 'click',
            'passwordElement' : '#send_pwd_client',
            'displayElement'  : '#send_pwd_client',
            'passwordLength'  : 8,
            'uppercase'       : true,
            'lowercase'       : true,
            'numbers'         : true,
            'specialChars'    : false
        });

        // Mascara
        Main.onlyNumber('cnpj_pwd_client');
        $("#cnpj_pwd_client").mask('99.999.999/9999-99');

        // Fecha modal
        $('#modal_pwd_vt').on('hidden.bs.modal', function (e) {
            $('#frm_newpwd_vt').each(function () {
                this.reset();
            });
            $('#frm_newpwd_vt').bootstrapValidator('resetForm', true);
        });
        $('#modal_pwd_client').on('hidden.bs.modal', function (e) {
            $('#frm_newpwd_client').each(function () {
                this.reset();
            });
            $('#frm_newpwd_client').bootstrapValidator('resetForm', true);
        });

        // Nova Senha VT Card
        $('#frm_newpwd_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                email_pwd_vt: {
                    validators: {
                        notEmpty: {
                            message: 'Informe seu <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
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
            var url = "./main/newPwdVt";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Main.modalMsg("MENSAGEM", data.msg, false, false);
                    // Limpar Formulario
                    $('#frm_newpwd_vt').each(function () {
                        this.reset();
                    });
                    $('#frm_newpwd_vt').bootstrapValidator('resetForm', true);
                    $("#modal_pwd_vt").modal('hide');
                } else {
                    Main.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }
                $('#btn_new_pwd_vt').removeAttr('disabled');
            }, 'json');

        });

        // Nova Senha Cliente
        $('#frm_newpwd_client').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                cnpj_pwd_client: {
                    validators: {
                        notEmpty: {
                            message: 'Informe seu <strong>CNPJ</strong>'
                        },
			vat: {
			    country: 'BR',
			    message: 'Digite um <strong>CNPJ</strong> v&aacute;lido'
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
            var url = "./main/newPwdClient";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Main.modalMsg("MENSAGEM", data.msg, false, false);
                    // Limpar Formulario
                    $('#frm_newpwd_client').each(function () {
                        this.reset();
                    });
                    $('#frm_newpwd_client').bootstrapValidator('resetForm', true);
                    $("#modal_pwd_client").modal('hide');
                } else {
                    Main.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }
                $('#btn_new_pwd_client').removeAttr('disabled');
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
		Main.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Main.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Modal alterar senha VT
     **/
    modalPwdVt: function () {
	$("#modal_pwd_vt").modal('show');
    },

    /*!
     * @description Modal alterar senha Cliente
     **/
    modalPwdClient: function () {
	$("#modal_pwd_client").modal('show');
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
    Main.main();
});