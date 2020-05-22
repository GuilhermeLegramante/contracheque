<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Demonstrativo Período</title>
</head>


<body>

    @for ($j = 1; $j < 7; $j++) @for ($i=0; $i < sizeof($eventos); $i++) @if ($eventos[$i]->idtipofolha == $j)
        @php
        $mes = $eventos[0]->mes;
        $ano = $eventos[0]->ano;
        @endphp
        <!-- PRINT HEADER -->
        <tr>
            <td rowspan="6"><img src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png" width="100"
                    height="100"></td>
        </tr>
        <tr>
            <td style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">
                {{$dadosorgao[0]->nome_empresa}}</td>
        </tr>
        <tr>
            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">{{$dadosorgao[0]->nome}},
                {{$dadosorgao[0]->numero}}</td>
        </tr>
        <tr>
            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">{{$dadosorgao[0]->cnpj}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                {{$eventos[$i]->desc_tipofolha}} -
                {{$eventos[$i]->mes}}/ {{$eventos[$i]->ano}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE SALÁRIO</td>
        </tr>
        </table>
        <table
            style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
            <tr>
                <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                <td><b>Contrato: {{$eventos[$i]->idcontrato}}</b></td>
                <td rowspan="2"><b>Padrão-Nível-Classe:
                    </b>{{$servidor[0]->padrao}}-{{$servidor[0]->nivel}}-{{$servidor[0]->classe}}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px"><b>Função:</b>{{$servidor[0]->desc_funcao}} </td>
                <td><b>Lotação: </b>{{$servidor[0]->desc_lotacao}}</td>
                <td></td>
            </tr>
        </table>


        <table style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px"
            cellspacing="0">
            <tr>
                <td
                    style="padding: 5px; text-align:center; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                    <b>Código</b></td>
                <td style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
                    <b>Descrição</b></td>
                <td
                    style="padding: 5px; text-align:right; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                    <b>Referência</b></td>
                <td
                    style="padding: 5px; text-align:right; border-right: 2px solid black; border-bottom: 2px solid black; width: 17%">
                    <b>Base de Cálculo</b></td>
                <td
                    style="padding: 5px; text-align:right; border-right: 2px solid black; border-bottom: 2px solid black; width: 17%">
                    <b>Vencimentos</b></td>
                <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%"><b>Descontos</b>
                </td>
            </tr>

        <!-- FIM HEADER -->
        @endif

        @endfor
        @endfor



</body>

<style>
    @page {
        margin: 3mm 3mm 3mm 3mm;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 50%;
    }
</style>

</html>