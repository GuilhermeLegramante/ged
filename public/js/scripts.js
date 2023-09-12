function formatarCampo(campoTexto) {
    if (campoTexto.value.length <= 11) {
        campoTexto.value = mascaraCpf(campoTexto.value);
    } else {
        campoTexto.value = mascaraCnpj(campoTexto.value);
    }
}

function carregaNomeProtocolante(campoTexto) {
    swal('teste');
    $.ajax({
        url: '/buscaProtocolantePeloDocumento',
        type: 'POST',
        data: { documento: documento },
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': laravel_token
        },
        success: function(data) {
            debugger;
            console.log(data);
        }
    });
}

function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g, "");
}

function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}

function mascaraCnpj(valor) {
    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "\$1.\$2.\$3\/\$4\-\$5");
}

// Máscara CEP
$("#cep").keydown(function() {
    $('#cep').mask('99999-000');
});

// Máscara Alíquota
$("#aliquota").keydown(function() {
    $('#aliquota').mask('##0.0', { reverse: true });
});

// Máscara Telefone
$("#telefone").keydown(function() {

    try {
        $("#telefone").unmask();
    } catch (e) {}

    var tamanho = $("#telefone").val().length;

    if (tamanho < 10) {
        $("#telefone").mask("(99) 9999-9999");
    } else {
        $("#telefone").mask("(99) 99999-9999");
    }

    // ajustando foco
    var elem = this;
    setTimeout(function() {
        // mudo a posição do seletor
        elem.selectionStart = elem.selectionEnd = 10000;
    }, 0);
    // reaplico o valor para mudar o foco
    var currentValue = $(this).val();
    $(this).val('');
    $(this).val(currentValue);
});

function desabilitaSelect(elemento) {
    if (($(elemento).val() == 'Lucro Presumido') || ($(elemento).val() == 'Lucro Real')) {
        $('#faixasimplesnacional').attr('disabled', 'disabled');
        $("#faixasimplesnacional").val('');
    } else {
        $('#faixasimplesnacional').removeAttr('disabled');
        $("#faixasimplesnacional").val('1');
    }
}

// FUNÇÕES AO CARREGAR A PÁGINA
$(document).ready(function() {

    // Transforma campos text pra maiúsculas
    $(".toUpper").keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    // Transforma campos text pra minúscula
    $(".toLower").keyup(function() {
        $(this).val($(this).val().toLowerCase());
    });

    // Marcar/Desmarcar todos os checkbox
    $("#checkAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    // Marca apenas uma linha
    $('.selectLine').change(function() {
        var value = $(this).attr("id");
        $(":checkbox[class='" + value + "']").prop("checked", this.checked);
    })

    // Configuração do select2 nos comboboxes
    $('.combobox-select2').select2({
        language: "pt-BR",
        allowClear: true,
        placeholder: "Selecione..."
    });

    $('.combobox-select2-tags').select2({
        language: "pt-BR",
        allowClear: true,
        placeholder: "Selecione...",
        tags: true
    });

    // Configuração para exibição do tooltip
    $('[data-toggle="tooltip"]').tooltip();
});

/*
FUNÇÕES PARA REÚSO
*/
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('uf').value = ("");

    // $('#rua').attr('disabled', false);

}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);
        document.getElementById('ibge').value = (conteudo.ibge);
        document.getElementById('logradouro').value = (conteudo.logradouro);
        document.getElementById('complemento').value = (conteudo.complemento);

        // Habilita o campo novamente, pois
        // CEP "genérico" ex. 97610-000 retorna string vazia 
        if (document.getElementById('rua').value == '') {
            $('#rua').attr('disabled', false);
        }

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        swal("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

            //  $('#rua').attr('disabled', 'disabled');


        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            swal("Informe o CEP no formato válido. Ex. 00000-000");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function confirmaExclusao() {
    confirm("Você deseja realmente excluir o registro?");
}

$("#voltar").click(function(e) {
    e.preventDefault();
    window.history.back();
});

function toggleFAB(fab) {
    if (document.querySelector(fab).classList.contains('show')) {
        document.querySelector(fab).classList.remove('show');
    } else {
        document.querySelector(fab).classList.add('show');
    }
}

document.querySelector('.fab .main').addEventListener('click', function() {
    toggleFAB('.fab');
});

document.querySelectorAll('.fab ul li button').forEach((item) => {
    item.addEventListener('click', function() {
        toggleFAB('.fab');
    });
});

/* PROCEDIMENTOS DE PRINT DOS FORMULÁRIOS COM BOTÃO DE MENU RÁPIDO */

function printFormulario() {
    //esconder o menu rápido
    document.getElementById('menu-rapido').style.display = 'none';
    document.getElementById('filter-row').style.display = 'none';

    //chamada do procedimento de impressão
    window.print();

    //habilitar o menu rápido novamente
    document.getElementById('menu-rapido').style.display = 'block';
    document.getElementById('filter-row').style.display = 'flex';
}

function showQuadrante(idprotocolo) {
    var idpro = document.getElementById('id_prot');
    var quad = document.getElementById('quadrante');

    idpro.value = idprotocolo;
    quad.value = '';
}

// Expandir e Recolher Table (treetable)
function expandTreeTable(name) {
    $(name).treetable('expandAll');
    return false;
}

function collapseTreeTable(name) {
    $(name).treetable('collapseAll');
    return false;
}