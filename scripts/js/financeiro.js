Financeiro = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Fechar modal remessa
        $("#btn_close").click(function(){
            $("#modal_remessa").modal('hidden');
        });

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
            fields: {
                cod_carteira: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>C&Oacute;DIGO DA CARTEIRA</strong>'
			}
		    }
		},
                cod_ocorrencia: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>C&Oacute;DIGO DE OCORR&Ecirc;NCIA</strong>'
			}
		    }
		},
                especie_doc: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ESP&Eacute;CIE DE DOCUMENTO</strong>'
			}
		    }
		},
                '1_instr_cobranca': {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>1ª INSTRU&Ccedil;&Atilde;O DE COBRAN&Ccedil;A</strong>'
			}
		    }
		},
            }
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
                        // Financeiro.modalMsg("MENSAGEM", data.msg, false, './movimentacao');
                        bootbox.dialog({
                            message : data.msg,
                            title   : "MENSAGEM",
                            buttons: {
                                success: {
                                    label     : "Sim",
                                    className : "btn-success",
                                    callback  : function() {
                                        Financeiro.openWindow('./createRemessa/'+data.id_remessa+'', '_blank');
                                        Financeiro.redirect('./ver_envio');
                                    }
                                },
                                danger: {
                                    label     : "N&atilde;o",
                                    className : "btn-danger",
                                    callback  : function() {
                                        Financeiro.redirect('./ver_envio');
                                    }
                                }
                            }
                        });
                    } else {
                        Financeiro.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                    }
                    $('#btn_gerar').removeAttr('disabled');
                }, 'json');

            } else {
                Financeiro.modalMsg("ATEN&Ccedil;&Atilde;O", "Favor Adicionar 1 ou Mais Boletos!", false, false);
                $('#btn_gerar').removeAttr('disabled');
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
    verBoleto: function (id_pedido) {
        var currentLocation = window.location;
        var parser          = document.createElement('a');
            parser.href     = currentLocation;
        var hostname        = parser.hostname;
        var pathname        = parser.pathname;
        var pathproj        = pathname.split('/')[1];
        // var url_boleto      = "http://"+hostname+"/"+pathproj+"/assets/boletos/"+nome;
        var url_boleto      = "http://"+hostname+"/"+pathproj+"/pedido/remitirboletohtml/"+id_pedido;

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
    },
    
    /*!
     * @description Método para abrir modal da Remessa
     **/
    modalRemessa: function(title)
    {
        $("#title_modal_remessa").html(title);
        $("#modal_remessa").modal('show');
    },

    /*!
     * @description Método para cadastrar Prospeccao
     **/
    abrirRemessa: function(id_remessa)
    {
        // Pesquisar Boletos
        $.post("./getBoletoRemessa", {
            id_remessa: id_remessa
        }, function(data){
            
            if (data.status === true) {
                
                var html = "";
                $.each(data.dados, function(key, value){
                    html += '<table class="table table-bordered table-striped">';
                    html +=     '<tbody>';
                    html +=         '<tr>';
                    html +=             '<th style="width: 25%">ID do Pedido</th>';
                    html +=             '<td>'+value.id_pedido_fk+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>CNPJ</th>';
                    html +=             '<td>'+value.pagador_cnpj_cpf+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>Cliente</th>';
                    html +=             '<td>'+value.pagador_nome+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>Valor</th>';
                    html +=             '<td>'+value.valor+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>Data de Vencimento</th>';
                    html +=             '<td>'+value.dt_vencimento+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>C&oacute;d. Carteira</th>';
                    html +=             '<td>'+value.cod_carteira+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>C&oacute;d. Ocorr&ecirc;ncia</th>';
                    html +=             '<td>'+value.ocorrencia_mov+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>Esp&eacute;cie de Documento</th>';
                    html +=             '<td>'+value.especie_doc+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>1&ordf; Instr. Cobran&ccedil;a</th>';
                    html +=             '<td>'+value.p_instrucao+'</td>';
                    html +=         '</tr>';
                    html +=         '<tr>';
                    html +=             '<th>2&ordf; Instr. Cobran&ccedil;a</th>';
                    html +=             '<td>'+value.s_instrucao+'</td>';
                    html +=         '</tr>';
                    html +=     '</tbody>';
                    html += '</table><br>';
                });
                
                $("#list_bol_rem").html(html);
                
            } else {
                Financeiro.modalMsg("Aten&ccedil;&atilde;o", data.msg);
            }
            
        }, 'json');
        
        // Abrir modal
        Financeiro.modalRemessa("Visualizar Boletos Indexados");
    }

};

$(document).ready(function () {
    Financeiro.main();
});