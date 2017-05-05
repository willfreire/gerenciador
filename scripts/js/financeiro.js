Financeiro = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Buscar Boletos
        $.get('./getBoletos', function(data){
            $("#add_boleto").typeahead({
                source : data,
                items  : 20
            });
        },'json');

        // Adicionar Boleto
        $("#btn_add_boleto").click(function(){
            var vl    = $("#add_boleto").val();
            var dados = vl.split(" / ");

            if (vl !== "") {
                var id_pedido = dados[0];
                var cnpj      = dados[1];
                var cliente   = dados[2];
                var valor     = dados[3];
                var tbl       = "<tr id='linha_"+id_pedido+"'>";
                    tbl      +=     "<td>"+id_pedido+"<input type='hidden' name='ids_boleto[]' value='"+id_pedido+"'></td>";
                    tbl      +=     "<td>"+cnpj+"</td>";
                    tbl      +=     "<td>"+cliente+"</td>";
                    tbl      +=     "<td class='text-center'>"+valor+"</td>";
                    tbl      +=     '<td class="text-center"><input type="button" name="btn_del_bol_'+id_pedido+'" id="btn_del_bol_'+id_pedido+'" class="btn btn-danger btn_del_arq" value="Remover" title="Remover" onclick="Financeiro.removeBoleto(\''+id_pedido+'\')"></td>';
                    tbl      += "</tr>";

                if ($("#linha_"+id_pedido+"").length === 0) {
                    $("#sem_boleto").hide();
                    $("#tbl_boletos").append(tbl);
                    $("#add_boleto").val('');
                } else {
                    Financeiro.modalMsg("ATEN&Ccedil;&Atilde;O", "Boleto j&aacute; Adicionado nesta Lista!", false, false);
                    $("#add_boleto").val('');
                }

            }

        });

        // Cadastro Remessa
        $('#frm_cad_remessa').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Verificar se tem boletos add
            if ($("#tbl_boletos tr").length > 1) {

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                var frm = $form.serialize();
                var url = "./create";

                // Use Ajax to submit form data
                $.post(url, frm, function (data) {
                    if (data.status === true) {
                        Financeiro.modalMsg("MENSAGEM", data.msg, false, './movimentacao');
                    } else {
                        Financeiro.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                    }
                    $('#btn_proximo').removeAttr('disabled');
                }, 'json');

            } else {
                Financeiro.modalMsg("ATEN&Ccedil;&Atilde;O", "Favor Adicionar 1 ou Mais Boletos!", false, false);
                $('#btn_proximo').removeAttr('disabled');
            }

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
		Financeiro.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Financeiro.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Ver Boleto
     **/
    verBoleto: function (nome) {
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

        var url_boleto = "http://"+hostname+"/"+pathproj+"/assets/boletos/"+nome;

        Financeiro.openWindow(url_boleto, "_blank");
    },

    /*!
     * @description Método para remover linha do boleto
     **/
    removeBoleto: function (id_pedido) {
	$("#linha_"+id_pedido).remove();
        if ($("#tbl_boletos tr").length === 1) {
            $("#sem_boleto").show();
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
    }

};

$(document).ready(function () {
    Financeiro.main();
});