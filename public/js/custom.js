function formatarCampo(campoTexto) {
    if (campoTexto.value.length <= 11) {
        campoTexto.value = mascaraCpf(campoTexto.value);
    } else {
        campoTexto.value = mascaraCnpj(campoTexto.value);
    }
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

$(document).ready(function() {
    $("input[type=text]").keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

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
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);

        document.getElementById('rua').val().toUpperCase();
        document.getElementById('bairro').val().toUpperCase();
        document.getElementById('cidade').val().toUpperCase();
        document.getElementById('rua').val().toUpperCase();


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