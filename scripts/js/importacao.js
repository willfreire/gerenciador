Importacao = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        var currentLocation = window.location;
        var parser          = document.createElement('a');
        // parser.href = "http://example.com:3000/pathname/?search=test#hash";
        parser.href = currentLocation;

        var protocol = parser.protocol; // => "http:"
        var host     = parser.host;     // => "example.com:3000"
        var hostname = parser.hostname; // => "example.com"
        var port     = parser.port;     // => "3000"
        var pathname = parser.pathname; // => "/pathname/"
        var pathproj = pathname.split('/')[1];
        var hash     = parser.hash;     // => "#hash"
        var search   = parser.search;   // => "?search=test"
        var origin   = parser.origin;   // => "http://example.com:3000"

        // Botao voltar
        $('#btn_back').click(function(){
            Importacao.redirect('/'+pathproj+'/');
        });

        // Importacao Cadastrar
        $('#frm_cad_import_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                arq_import: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio selecionar um <strong>ARQUIVO CSV</strong>'
			},
                        file: {
                            extension : 'csv',
                            type      : 'text/csv',
                            maxSize   : 5097152,
                            message   : 'O Arquivo selecionado n&atilde;o &eacute; v&aacute;lido!'
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
            var url = '/'+pathproj+'/importacao/upload';

            // Use Ajax to submit form data
            $.ajax({
                url         : url,
                type        : 'POST',
                dataType    : 'json',
                data        : new FormData($($form)[0]),
                cache       : false,
                contentType : false,
                processData : false,
                success     : function(data) {
                    if (data.status === true) {
                        Importacao.modalMsg("MENSAGEM", data.msg, false, './geral');
                    } else {
                        Importacao.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                    }
                    $('#btn_cad_import_vt').removeAttr('disabled');    
                }
            });

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
		Importacao.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Importacao.redirect(redirect);
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
    Importacao.main();
});