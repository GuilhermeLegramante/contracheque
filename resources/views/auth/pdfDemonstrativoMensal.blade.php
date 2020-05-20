<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Demonstrativo Mensal</title>
</head>

<body>
    <table style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">
        <tr>
            <td rowspan="6"><img src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png" width="100"
                    height="100"></td>
        </tr>
        <tr>
            <td style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">{{$dadosOrgao[0]->nome_empresa}}</td>
        </tr>
        <tr>
            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">{{$dadosOrgao[0]->nome}}, {{$dadosOrgao[0]->numero}}</td>
        </tr>
        <tr>
            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">{{$dadosOrgao[0]->cnpj}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">Folha: {{$valores[0]->desc_tipofolha}} -
                {{$descricaomes}}/{{$ano}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE SALÁRIO</td>
        </tr>
        </table>
        <table
            style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
            <tr>
                <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                <td><b>Contrato:</b> {{$contrato}}</td>
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
            @foreach ($vencimentos as $vencimento)
            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$vencimento->codigo}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$vencimento->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($vencimento->referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($vencimento->valor, 2, ',', '.')}}</td>
                <td style="padding: 5px"></td>
            </tr>
            </tr>
            @endforeach
            @foreach ($descontos as $desconto)
            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$desconto->codigo}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$desconto->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($desconto->referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; text-align: right">{{number_format($desconto->valor, 2, ',', '.')}}</td>
            </tr>
            </tr>
            @endforeach
            @foreach ($bases as $base)
            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$base->codigo}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$base->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($base->referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($base->valor, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px"></td>
            </tr>
            </tr>
            @endforeach
            <tr>
                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black" colspan="4"
                    rowspan="3"><b>Referência:</b> {{$descricaomes}}/{{$ano}}</td>
                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total de
                        Vencimentos:</b></td>
                <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b></td>
            </tr>
            <tr>
                <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                    {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                <td style="padding: 5px; text-align: right">{{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total
                        Líquido:</b>
                </td>
                <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                    {{'R$ '.number_format($totalLiquido, 2, ',', '.')}}</td>
            </tr>
        </table>
</body>

<style>
    @page {
        margin: 3mm 3mm 3mm 3mm;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 50%;
    }
</style>

</html>