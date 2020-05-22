<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Demonstrativo Período</title>
</head>


@php
$totalVencimentos = 0;
$totalDescontos = 0;
$contador = 0;
$mes = "";
@endphp

<body>
    <!-- INÍCIO LOOP TOTAL MENSAL -->
    @if(isset($totalMensal))
    @for ($i=0; $i<sizeof($totalMensal); $i++) <table
        style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

        @php
        $mes = $totalMensal[$i]['mes'];

        switch ($mes) {
        case 1: $mes = "JANEIRO"; break;
        case 2: $mes = "FEVEREIRO"; break;
        case 3: $mes = "MARÇO"; break;
        case 4: $mes = "ABRIL"; break;
        case 5: $mes = "MAIO"; break;
        case 6: $mes = "JUNHO"; break;
        case 7: $mes = "JULHO"; break;
        case 8: $mes = "AGOSTO"; break;
        case 9: $mes = "SETEMBRO"; break;
        case 10: $mes = "OUTUBRO"; break;
        case 11: $mes = "NOVEMBRO"; break;
        case 12: $mes = "DEZEMBRO"; break;

        }
        @endphp

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
                {{$totalMensal[$i]['desc_tipofolha']}} -
                {{$mes}}/ {{$totalMensal[$i]['ano']}}</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE SALÁRIO</td>
        </tr>
        </table>
        <table
            style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
            <tr>
                <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                <td><b>Contrato: {{$contrato}}</b></td>
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
            @foreach ($valores as $valor)

            @if (($valor->classificacao == '1' && $valor->mes == $totalMensal[$i]['mes'] && $valor->ano ==
            $totalMensal[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal[$i]['mes'] &&
            $valor->ano == $totalMensal[$i]['ano']))
            @php
            if(($valor->classificacao == '1') || ($valor->classificacao == 'P')){
            $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
            }
            @endphp

            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                <td style="padding: 5px"></td>
            </tr>
            @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal[$i]['mes'] && $valor->ano ==
            $totalMensal[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal[$i]['mes'] &&
            $valor->ano == $totalMensal[$i]['ano']))

            @php
            if (($valor->classificacao == '2') || ($valor->classificacao == 'D')) {
            $totalDescontos = $totalDescontos + $valor->valor_calculado ;
            }
            @endphp

            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px; text-align: right">{{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
            </tr>
            @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal[$i]['mes'] && $valor->ano ==
            $totalMensal[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal[$i]['mes'] &&
            $valor->ano == $totalMensal[$i]['ano']))
            <tr>
                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                    {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                <td style="padding: 5px; border-right: 2px solid black"></td>
                <td style="padding: 5px"></td>
            </tr>
            @endif
            @endforeach


            <tr>
                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black" colspan="4"
                    rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal[$i]['ano']}}</td>
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
                    {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
            </tr>
            @php
            $totalVencimentos = 0;
            $totalDescontos = 0;
            $contador++;
            @endphp
            <div style="page-break-after: always">

        </table>

        @endfor

        @endif
        <!-- FIM LOOP TOTAL MENSAL -->

        <!-- INÍCIO LOOP TOTAL MENSAL 1 -->
        @if(isset($totalMensal1))
        @for ($i=0; $i<sizeof($totalMensal1); $i++) <table
            style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

            @php
            $mes = $totalMensal1[$i]['mes'];

            switch ($mes) {
            case 1: $mes = "JANEIRO"; break;
            case 2: $mes = "FEVEREIRO"; break;
            case 3: $mes = "MARÇO"; break;
            case 4: $mes = "ABRIL"; break;
            case 5: $mes = "MAIO"; break;
            case 6: $mes = "JUNHO"; break;
            case 7: $mes = "JULHO"; break;
            case 8: $mes = "AGOSTO"; break;
            case 9: $mes = "SETEMBRO"; break;
            case 10: $mes = "OUTUBRO"; break;
            case 11: $mes = "NOVEMBRO"; break;
            case 12: $mes = "DEZEMBRO"; break;

            }
            @endphp

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
                    {{$totalMensal1[$i]['desc_tipofolha']}} -
                    {{$mes}}/ {{$totalMensal1[$i]['ano']}}</td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE SALÁRIO
                </td>
            </tr>
            </table>
            <table
                style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                <tr>
                    <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                    <td><b>Contrato: {{$contrato}}</b></td>
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
                    <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                        <b>Descontos</b>
                    </td>
                </tr>
                @foreach ($valoresTipoFolha1 as $valor)

                @if (($valor->classificacao == '1' && $valor->mes == $totalMensal1[$i]['mes'] && $valor->ano ==
                $totalMensal1[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal1[$i]['mes'] &&
                $valor->ano == $totalMensal1[$i]['ano']))

                @php
                if(($valor->classificacao == '1')||($valor->classificacao === 'P')){
                $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                }
                @endphp

                <tr>
                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                    <td style="padding: 5px; border-right: 2px solid black"></td>
                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                        {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                    <td style="padding: 5px"></td>
                </tr>
                @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal1[$i]['mes'] && $valor->ano ==
                $totalMensal1[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal1[$i]['mes'] &&
                $valor->ano == $totalMensal1[$i]['ano']))

                @php
                if (($valor->classificacao == '2')||($valor->classificacao === 'D')) {
                $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                }
                @endphp

                <tr>
                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                    <td style="padding: 5px; border-right: 2px solid black"></td>
                    <td style="padding: 5px; border-right: 2px solid black"></td>
                    <td style="padding: 5px; text-align: right">{{number_format($valor->valor_calculado, 2, ',', '.')}}
                    </td>
                </tr>
                @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal1[$i]['mes'] && $valor->ano ==
                $totalMensal1[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal1[$i]['mes'] &&
                $valor->ano == $totalMensal1[$i]['ano']))
                <tr>
                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                        {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                    <td style="padding: 5px; border-right: 2px solid black"></td>
                    <td style="padding: 5px"></td>
                </tr>
                @endif
                @endforeach


                <tr>
                    <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black" colspan="4"
                        rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal1[$i]['ano']}}</td>
                    <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total de
                            Vencimentos:</b></td>
                    <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b></td>
                </tr>
                <tr>
                    <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                        {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                    <td style="padding: 5px; text-align: right">{{'R$ '.number_format($totalDescontos, 2, ',', '.')}}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total
                            Líquido:</b>
                    </td>
                    <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                        {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
                </tr>
                @php
                $totalVencimentos = 0;
                $totalDescontos = 0;
                $contador++;
                @endphp
                <div style="page-break-after: always">

            </table>

            @endfor

            @endif
            <!-- FIM LOOP TOTAL MENSAL 1 -->


            <!-- INÍCIO LOOP TOTAL MENSAL 2 -->
            @if(isset($totalMensal2))
            @for ($i=0; $i<sizeof($totalMensal2); $i++) <table
                style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                @php
                $mes = $totalMensal2[$i]['mes'];

                switch ($mes) {
                case 1: $mes = "JANEIRO"; break;
                case 2: $mes = "FEVEREIRO"; break;
                case 3: $mes = "MARÇO"; break;
                case 4: $mes = "ABRIL"; break;
                case 5: $mes = "MAIO"; break;
                case 6: $mes = "JUNHO"; break;
                case 7: $mes = "JULHO"; break;
                case 8: $mes = "AGOSTO"; break;
                case 9: $mes = "SETEMBRO"; break;
                case 10: $mes = "OUTUBRO"; break;
                case 11: $mes = "NOVEMBRO"; break;
                case 12: $mes = "DEZEMBRO"; break;

                }
                @endphp

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
                        {{$totalMensal2[$i]['desc_tipofolha']}} -
                        {{$mes}}/ {{$totalMensal2[$i]['ano']}}</td>
                </tr>
                <tr>
                    <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE
                        SALÁRIO</td>
                </tr>
                </table>
                <table
                    style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                    <tr>
                        <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                        <td><b>Contrato: {{$contrato}}</b></td>
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
                        <td
                            style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                        <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                            <b>Descontos</b>
                        </td>
                    </tr>
                    @foreach ($valoresTipoFolha2 as $valor)

                    @if (($valor->classificacao == '1' && $valor->mes == $totalMensal2[$i]['mes'] && $valor->ano ==
                    $totalMensal2[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal2[$i]['mes'] &&
                    $valor->ano == $totalMensal2[$i]['ano']))

                    @php
                    if(($valor->classificacao == '1')||($valor->classificacao === 'P')){
                    $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                    }
                    @endphp

                    <tr>
                        <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                        <td style="padding: 5px; border-right: 2px solid black"></td>
                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                        <td style="padding: 5px"></td>
                    </tr>
                    @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal2[$i]['mes'] && $valor->ano ==
                    $totalMensal2[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal2[$i]['mes'] &&
                    $valor->ano == $totalMensal2[$i]['ano']))

                    @php
                    if (($valor->classificacao == '2')||($valor->classificacao === 'D')) {
                    $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                    }
                    @endphp

                    <tr>
                        <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                        <td style="padding: 5px; border-right: 2px solid black"></td>
                        <td style="padding: 5px; border-right: 2px solid black"></td>
                        <td style="padding: 5px; text-align: right">
                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                    </tr>
                    @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal2[$i]['mes'] && $valor->ano ==
                    $totalMensal2[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal2[$i]['mes'] &&
                    $valor->ano == $totalMensal2[$i]['ano']))
                    <tr>
                        <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                        <td style="padding: 5px; border-right: 2px solid black"></td>
                        <td style="padding: 5px"></td>
                    </tr>
                    @endif
                    @endforeach


                    <tr>
                        <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black" colspan="4"
                            rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal2[$i]['ano']}}</td>
                        <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total de
                                Vencimentos:</b></td>
                        <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                            {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                        <td style="padding: 5px; text-align: right">
                            {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"><b>Total
                                Líquido:</b>
                        </td>
                        <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                            {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
                    </tr>
                    @php
                    $totalVencimentos = 0;
                    $totalDescontos = 0;
                    $contador++;
                    @endphp
                    
                    <div style="page-break-after: always">

                </table>

                @endfor

                @endif
                <!-- FIM LOOP TOTAL MENSAL 2 -->

                <!-- INÍCIO LOOP TOTAL MENSAL 3 -->
                @if(isset($totalMensal3))
                @for ($i=0; $i<sizeof($totalMensal3); $i++) <table
                    style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                    @php
                    $mes = $totalMensal3[$i]['mes'];

                    switch ($mes) {
                    case 1: $mes = "JANEIRO"; break;
                    case 2: $mes = "FEVEREIRO"; break;
                    case 3: $mes = "MARÇO"; break;
                    case 4: $mes = "ABRIL"; break;
                    case 5: $mes = "MAIO"; break;
                    case 6: $mes = "JUNHO"; break;
                    case 7: $mes = "JULHO"; break;
                    case 8: $mes = "AGOSTO"; break;
                    case 9: $mes = "SETEMBRO"; break;
                    case 10: $mes = "OUTUBRO"; break;
                    case 11: $mes = "NOVEMBRO"; break;
                    case 12: $mes = "DEZEMBRO"; break;

                    }
                    @endphp

                    <tr>
                        <td rowspan="6"><img src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png"
                                width="100" height="100"></td>
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
                        <td style="padding-left: -120px; font-size: 14px; font-weight: bold">{{$dadosorgao[0]->cnpj}}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                            {{$totalMensal3[$i]['desc_tipofolha']}} -
                            {{$mes}}/ {{$totalMensal3[$i]['ano']}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE
                            SALÁRIO</td>
                    </tr>
                    </table>
                    <table
                        style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                        <tr>
                            <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                            <td><b>Contrato: {{$contrato}}</b></td>
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
                            <td
                                style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                            <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                                <b>Descontos</b>
                            </td>
                        </tr>
                        @foreach ($valoresTipoFolha3 as $valor)

                        @if (($valor->classificacao == '1' && $valor->mes == $totalMensal3[$i]['mes'] && $valor->ano ==
                        $totalMensal3[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal3[$i]['mes'] &&
                        $valor->ano == $totalMensal3[$i]['ano']))

                        @php
                        if(($valor->classificacao == '1')||($valor->classificacao == 'P')){
                        $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                        }
                        @endphp

                        <tr>
                            <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                            <td style="padding: 5px; border-right: 2px solid black"></td>
                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                            <td style="padding: 5px"></td>
                        </tr>
                        @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal3[$i]['mes'] && $valor->ano ==
                        $totalMensal3[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal3[$i]['mes'] &&
                        $valor->ano == $totalMensal3[$i]['ano']))

                        @php
                        if (($valor->classificacao == '2')||($valor->classificacao == 'D')) {
                        $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                        }
                        @endphp

                        <tr>
                            <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                            <td style="padding: 5px; border-right: 2px solid black"></td>
                            <td style="padding: 5px; border-right: 2px solid black"></td>
                            <td style="padding: 5px; text-align: right">
                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                        </tr>
                        @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal3[$i]['mes'] && $valor->ano ==
                        $totalMensal3[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal3[$i]['mes'] &&
                        $valor->ano == $totalMensal3[$i]['ano']))
                        <tr>
                            <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                            <td style="padding: 5px; border-right: 2px solid black"></td>
                            <td style="padding: 5px"></td>
                        </tr>
                        @endif
                        @endforeach


                        <tr>
                            <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"
                                colspan="4" rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal3[$i]['ano']}}</td>
                            <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                <b>Total de
                                    Vencimentos:</b></td>
                            <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                                {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                            <td style="padding: 5px; text-align: right">
                                {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                <b>Total
                                    Líquido:</b>
                            </td>
                            <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                                {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
                        </tr>
                        @php
                        $totalVencimentos = 0;
                        $totalDescontos = 0;
                        $contador++;
                        @endphp
                       
                        <div style="page-break-after: always">

                    </table>

                    @endfor

                    @endif
                    <!-- FIM LOOP TOTAL MENSAL 3 -->

                    <!-- INÍCIO LOOP TOTAL MENSAL 4 -->
                    @if(isset($totalMensal4))
                    @for ($i=0; $i<sizeof($totalMensal4); $i++) <table
                        style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                        @php
                        $mes = $totalMensal4[$i]['mes'];

                        switch ($mes) {
                        case 1: $mes = "JANEIRO"; break;
                        case 2: $mes = "FEVEREIRO"; break;
                        case 3: $mes = "MARÇO"; break;
                        case 4: $mes = "ABRIL"; break;
                        case 5: $mes = "MAIO"; break;
                        case 6: $mes = "JUNHO"; break;
                        case 7: $mes = "JULHO"; break;
                        case 8: $mes = "AGOSTO"; break;
                        case 9: $mes = "SETEMBRO"; break;
                        case 10: $mes = "OUTUBRO"; break;
                        case 11: $mes = "NOVEMBRO"; break;
                        case 12: $mes = "DEZEMBRO"; break;

                        }
                        @endphp

                        <tr>
                            <td rowspan="6"><img src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png"
                                    width="100" height="100"></td>
                        </tr>
                        <tr>
                            <td style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">
                                {{$dadosorgao[0]->nome_empresa}}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                {{$dadosorgao[0]->nome}}, {{$dadosorgao[0]->numero}}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                {{$dadosorgao[0]->cnpj}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                                {{$totalMensal4[$i]['desc_tipofolha']}} -
                                {{$mes}}/ {{$totalMensal4[$i]['ano']}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO
                                DE SALÁRIO</td>
                        </tr>
                        </table>
                        <table
                            style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                            <tr>
                                <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                                <td><b>Contrato: {{$contrato}}</b></td>
                                <td rowspan="2"><b>Padrão-Nível-Classe:
                                    </b>{{$servidor[0]->padrao}}-{{$servidor[0]->nivel}}-{{$servidor[0]->classe}}</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 5px"><b>Função:</b>{{$servidor[0]->desc_funcao}} </td>
                                <td><b>Lotação: </b>{{$servidor[0]->desc_lotacao}}</td>
                                <td></td>
                            </tr>
                        </table>


                        <table
                            style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px"
                            cellspacing="0">
                            <tr>
                                <td
                                    style="padding: 5px; text-align:center; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                                    <b>Código</b></td>
                                <td
                                    style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                                <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                                    <b>Descontos</b>
                                </td>
                            </tr>
                            @foreach ($valoresTipoFolha4 as $valor)

                            @if (($valor->classificacao == '1' && $valor->mes == $totalMensal4[$i]['mes'] && $valor->ano ==
                            $totalMensal4[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal4[$i]['mes'] &&
                            $valor->ano == $totalMensal4[$i]['ano']))

                            @php
                            if(($valor->classificacao == '1')||($valor->classificacao == 'P')){
                            $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                            }
                            @endphp

                            <tr>
                                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                </td>
                                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                <td style="padding: 5px; border-right: 2px solid black"></td>
                                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                    {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                <td style="padding: 5px"></td>
                            </tr>
                            @elseif (($valor->classificacao == '1' && $valor->mes == $totalMensal4[$i]['mes'] && $valor->ano ==
                            $totalMensal4[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal4[$i]['mes'] &&
                            $valor->ano == $totalMensal4[$i]['ano']))

                            @php
                            if (($valor->classificacao == '2')||($valor->classificacao == 'D')) {
                            $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                            }
                            @endphp

                            <tr>
                                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                </td>
                                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                <td style="padding: 5px; border-right: 2px solid black"></td>
                                <td style="padding: 5px; border-right: 2px solid black"></td>
                                <td style="padding: 5px; text-align: right">
                                    {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                            </tr>
                            @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal4[$i]['mes'] && $valor->ano ==
                            $totalMensal4[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal4[$i]['mes'] &&
                            $valor->ano == $totalMensal4[$i]['ano']))
                            <tr>
                                <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                </td>
                                <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                    {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                    {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                <td style="padding: 5px; border-right: 2px solid black"></td>
                                <td style="padding: 5px"></td>
                            </tr>
                            @endif
                            @endforeach


                            <tr>
                                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"
                                    colspan="4" rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal4[$i]['ano']}}
                                </td>
                                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                    <b>Total de
                                        Vencimentos:</b></td>
                                <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                                    {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                                <td style="padding: 5px; text-align: right">
                                    {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                    <b>Total
                                        Líquido:</b>
                                </td>
                                <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                                    {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
                            </tr>
                            @php
                            $totalVencimentos = 0;
                            $totalDescontos = 0;
                            $contador++;
                            @endphp
                            <div style="page-break-after: always">

                        </table>

                        @endfor

                        @endif
                        <!-- FIM LOOP TOTAL MENSAL 4 -->

                        <!-- INÍCIO LOOP TOTAL MENSAL 5 -->
                        @if(isset($totalMensal5))
                        @for ($i=0; $i<sizeof($totalMensal5); $i++) <table
                            style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                            @php
                            $mes = $totalMensal5[$i]['mes'];

                            switch ($mes) {
                            case 1: $mes = "JANEIRO"; break;
                            case 2: $mes = "FEVEREIRO"; break;
                            case 3: $mes = "MARÇO"; break;
                            case 4: $mes = "ABRIL"; break;
                            case 5: $mes = "MAIO"; break;
                            case 6: $mes = "JUNHO"; break;
                            case 7: $mes = "JULHO"; break;
                            case 8: $mes = "AGOSTO"; break;
                            case 9: $mes = "SETEMBRO"; break;
                            case 10: $mes = "OUTUBRO"; break;
                            case 11: $mes = "NOVEMBRO"; break;
                            case 12: $mes = "DEZEMBRO"; break;

                            }
                            @endphp

                            <tr>
                                <td rowspan="6"><img src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png"
                                        width="100" height="100"></td>
                            </tr>
                            <tr>
                                <td style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">
                                    {{$dadosorgao[0]->nome_empresa}}</td>
                            </tr>
                            <tr>
                                <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                    {{$dadosorgao[0]->nome}}, {{$dadosorgao[0]->numero}}</td>
                            </tr>
                            <tr>
                                <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                    {{$dadosorgao[0]->cnpj}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                                    {{$totalMensal5[$i]['desc_tipofolha']}} -
                                    {{$mes}}/ {{$totalMensal5[$i]['ano']}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE
                                    PAGAMENTO DE SALÁRIO</td>
                            </tr>
                            </table>
                            <table
                                style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                                <tr>
                                    <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                                    <td><b>Contrato: {{$contrato}}</b></td>
                                    <td rowspan="2"><b>Padrão-Nível-Classe:
                                        </b>{{$servidor[0]->padrao}}-{{$servidor[0]->nivel}}-{{$servidor[0]->classe}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 5px"><b>Função:</b>{{$servidor[0]->desc_funcao}} </td>
                                    <td><b>Lotação: </b>{{$servidor[0]->desc_lotacao}}</td>
                                    <td></td>
                                </tr>
                            </table>


                            <table
                                style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px"
                                cellspacing="0">
                                <tr>
                                    <td
                                        style="padding: 5px; text-align:center; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                                        <b>Código</b></td>
                                    <td
                                        style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                                    <td
                                        style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                                        <b>Descontos</b>
                                    </td>
                                </tr>
                                @foreach ($valoresTipoFolha5 as $valor)

                                @if (($valor->classificacao == '1' && $valor->mes == $totalMensal5[$i]['mes'] && $valor->ano ==
                                $totalMensal5[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal5[$i]['mes'] &&
                                $valor->ano == $totalMensal5[$i]['ano']))
                                @php
                                if(($valor->classificacao == '1')||($valor->classificacao == 'P')){
                                $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                                }
                                @endphp

                                <tr>
                                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                    </td>
                                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black"></td>
                                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                        {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                    <td style="padding: 5px"></td>
                                </tr>
                                @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal5[$i]['mes'] && $valor->ano ==
                                $totalMensal5[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal5[$i]['mes'] &&
                                $valor->ano == $totalMensal5[$i]['ano']))

                                @php
                                if (($valor->classificacao == '2')||($valor->classificacao == 'D')) {
                                $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                                }
                                @endphp

                                <tr>
                                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                    </td>
                                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black"></td>
                                    <td style="padding: 5px; border-right: 2px solid black"></td>
                                    <td style="padding: 5px; text-align: right">
                                        {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                </tr>
                                @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal5[$i]['mes'] && $valor->ano ==
                                $totalMensal5[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal5[$i]['mes'] &&
                                $valor->ano == $totalMensal5[$i]['ano']))
                                <tr>
                                    <td style="border-right: 2px solid black; text-align: center">{{$valor->cod_evento}}
                                    </td>
                                    <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                        {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                        {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                    <td style="padding: 5px; border-right: 2px solid black"></td>
                                    <td style="padding: 5px"></td>
                                </tr>
                                @endif
                                @endforeach


                                <tr>
                                    <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"
                                        colspan="4" rowspan="3"><b>Referência:</b> {{$mes}}/{{$totalMensal5[$i]['ano']}}
                                    </td>
                                    <td
                                        style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                        <b>Total de
                                            Vencimentos:</b></td>
                                    <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                                        {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                                    <td style="padding: 5px; text-align: right">
                                        {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                        <b>Total
                                            Líquido:</b>
                                    </td>
                                    <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                                        {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}</td>
                                </tr>
                                @php
                                $totalVencimentos = 0;
                                $totalDescontos = 0;
                                $contador++;
                                @endphp
                                <div style="page-break-after: always">

                            </table>

                            @endfor

                            @endif
                            <!-- FIM LOOP TOTAL MENSAL 5 -->

                            <!-- INÍCIO LOOP TOTAL MENSAL 6 -->
                            @if(isset($totalMensal6))
                            @for ($i=0; $i<sizeof($totalMensal6); $i++) <table
                                style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                                @php
                                $mes = $totalMensal6[$i]['mes'];

                                switch ($mes) {
                                case 1: $mes = "JANEIRO"; break;
                                case 2: $mes = "FEVEREIRO"; break;
                                case 3: $mes = "MARÇO"; break;
                                case 4: $mes = "ABRIL"; break;
                                case 5: $mes = "MAIO"; break;
                                case 6: $mes = "JUNHO"; break;
                                case 7: $mes = "JULHO"; break;
                                case 8: $mes = "AGOSTO"; break;
                                case 9: $mes = "SETEMBRO"; break;
                                case 10: $mes = "OUTUBRO"; break;
                                case 11: $mes = "NOVEMBRO"; break;
                                case 12: $mes = "DEZEMBRO"; break;

                                }
                                @endphp

                                <tr>
                                    <td rowspan="6"><img
                                            src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png" width="100"
                                            height="100"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">
                                        {{$dadosorgao[0]->nome_empresa}}</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                        {{$dadosorgao[0]->nome}}, {{$dadosorgao[0]->numero}}</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                        {{$dadosorgao[0]->cnpj}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                                        {{$totalMensal6[$i]['desc_tipofolha']}} -
                                        {{$mes}}/ {{$totalMensal6[$i]['ano']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE
                                        PAGAMENTO DE SALÁRIO</td>
                                </tr>
                                </table>
                                <table
                                    style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                                    <tr>
                                        <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                                        <td><b>Contrato: {{$contrato}}</b></td>
                                        <td rowspan="2"><b>Padrão-Nível-Classe:
                                            </b>{{$servidor[0]->padrao}}-{{$servidor[0]->nivel}}-{{$servidor[0]->classe}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 5px"><b>Função:</b>{{$servidor[0]->desc_funcao}} </td>
                                        <td><b>Lotação: </b>{{$servidor[0]->desc_lotacao}}</td>
                                        <td></td>
                                    </tr>
                                </table>


                                <table
                                    style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px"
                                    cellspacing="0">
                                    <tr>
                                        <td
                                            style="padding: 5px; text-align:center; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                                            <b>Código</b></td>
                                        <td
                                            style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                                        <td
                                            style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                                            <b>Descontos</b>
                                        </td>
                                    </tr>
                                    @foreach ($valoresTipoFolha6 as $valor)

                                    @if (($valor->classificacao == '1' && $valor->mes == $totalMensal6[$i]['mes'] && $valor->ano ==
                                    $totalMensal6[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal6[$i]['mes'] &&
                                    $valor->ano == $totalMensal6[$i]['ano']))

                                    @php
                                    if(($valor->classificacao == '1')||($valor->classificacao == 'P')){
                                    $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                                    }
                                    @endphp

                                    <tr>
                                        <td style="border-right: 2px solid black; text-align: center">
                                            {{$valor->cod_evento}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}
                                        </td>
                                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black"></td>
                                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                        <td style="padding: 5px"></td>
                                    </tr>
                                    @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal6[$i]['mes'] && $valor->ano ==
                                    $totalMensal6[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal6[$i]['mes'] &&
                                    $valor->ano == $totalMensal6[$i]['ano']))
                                    @php
                                    if (($valor->classificacao == '2')||($valor->classificacao == 'D')) {
                                    $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                                    }
                                    @endphp

                                    <tr>
                                        <td style="border-right: 2px solid black; text-align: center">
                                            {{$valor->cod_evento}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}
                                        </td>
                                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black"></td>
                                        <td style="padding: 5px; border-right: 2px solid black"></td>
                                        <td style="padding: 5px; text-align: right">
                                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                    </tr>
                                    @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal6[$i]['mes'] && $valor->ano ==
                                    $totalMensal6[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal6[$i]['mes'] &&
                                    $valor->ano == $totalMensal6[$i]['ano']))
                                    <tr>
                                        <td style="border-right: 2px solid black; text-align: center">
                                            {{$valor->cod_evento}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black">{{$valor->desc_evento}}
                                        </td>
                                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                            {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                            {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                        <td style="padding: 5px; border-right: 2px solid black"></td>
                                        <td style="padding: 5px"></td>
                                    </tr>
                                    @endif
                                    @endforeach


                                    <tr>
                                        <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"
                                            colspan="4" rowspan="3"><b>Referência:</b>
                                            {{$mes}}/{{$totalMensal6[$i]['ano']}}</td>
                                        <td
                                            style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                            <b>Total de
                                                Vencimentos:</b></td>
                                        <td style="padding: 5px; border-top: 2px solid black"><b>Total de Descontos:</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                                            {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                                        <td style="padding: 5px; text-align: right">
                                            {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                            <b>Total
                                                Líquido:</b>
                                        </td>
                                        <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                                            {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}
                                        </td>
                                    </tr>
                                    @php
                                    $totalVencimentos = 0;
                                    $totalDescontos = 0;
                                    $contador++;
                                    @endphp
                                    <div style="page-break-after: always">

                                        
                                </table>

                                @endfor

                                @endif
                                <!-- FIM LOOP TOTAL MENSAL 6 -->

                                <!-- INÍCIO LOOP TOTAL MENSAL 7 -->
                                @if(isset($totalMensal7))
                                @for ($i=0; $i<sizeof($totalMensal7); $i++) <table
                                    style="width: 100%; border: 2px solid black; border-bottom: 1px solid black">

                                    @php
                                    $mes = $totalMensal7[$i]['mes'];

                                    switch ($mes) {
                                    case 1: $mes = "JANEIRO"; break;
                                    case 2: $mes = "FEVEREIRO"; break;
                                    case 3: $mes = "MARÇO"; break;
                                    case 4: $mes = "ABRIL"; break;
                                    case 5: $mes = "MAIO"; break;
                                    case 6: $mes = "JUNHO"; break;
                                    case 7: $mes = "JULHO"; break;
                                    case 8: $mes = "AGOSTO"; break;
                                    case 9: $mes = "SETEMBRO"; break;
                                    case 10: $mes = "OUTUBRO"; break;
                                    case 11: $mes = "NOVEMBRO"; break;
                                    case 12: $mes = "DEZEMBRO"; break;

                                    }
                                    @endphp

                                    <tr>
                                        <td rowspan="6"><img
                                                src="http://localhost/webpatrimonio/hsportal/imagens/brasao.png"
                                                width="100" height="100"></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="padding-left: -120px; margin-left: -20px; font-size:16px; font-weight: bold">
                                            {{$dadosorgao[0]->nome_empresa}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                            {{$dadosorgao[0]->nome}}, {{$dadosorgao[0]->numero}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: -120px; font-size: 14px; font-weight: bold">
                                            {{$dadosorgao[0]->cnpj}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px; font-weight: bold; text-align: right">Folha:
                                            {{$totalMensal7[$i]['desc_tipofolha']}} -
                                            {{$mes}}/ {{$totalMensal7[$i]['ano']}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO
                                            DE PAGAMENTO DE SALÁRIO</td>
                                    </tr>
                                    </table>
                                    <table
                                        style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
                                        <tr>
                                            <td style="padding-left: 5px"><b>Servidor: </b>{{$servidor[0]->nome}}</td>
                                            <td><b>Contrato: {{$contrato}}</b></td>
                                            <td rowspan="2"><b>Padrão-Nível-Classe:
                                                </b>{{$servidor[0]->padrao}}-{{$servidor[0]->nivel}}-{{$servidor[0]->classe}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 5px"><b>Função:</b>{{$servidor[0]->desc_funcao}}
                                            </td>
                                            <td><b>Lotação: </b>{{$servidor[0]->desc_lotacao}}</td>
                                            <td></td>
                                        </tr>
                                    </table>


                                    <table
                                        style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px"
                                        cellspacing="0">
                                        <tr>
                                            <td
                                                style="padding: 5px; text-align:center; border-right: 2px solid black; border-bottom: 2px solid black; width: 10%">
                                                <b>Código</b></td>
                                            <td
                                                style="padding: 5px; border-right: 2px solid black; border-bottom: 2px solid black; width: 39%">
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
                                            <td
                                                style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%">
                                                <b>Descontos</b>
                                            </td>
                                        </tr>
                                        @foreach ($valoresTipoFolha7 as $valor)

                                        @if (($valor->classificacao == '1' && $valor->mes == $totalMensal7[$i]['mes'] && $valor->ano ==
                                        $totalMensal7[$i]['ano']) || ($valor->classificacao == 'P' && $valor->mes == $totalMensal7[$i]['mes'] &&
                                        $valor->ano == $totalMensal7[$i]['ano']))

                                        @php
                                        if(($valor->classificacao == '1')||($valor->classificacao == 'P')){
                                        $totalVencimentos = $totalVencimentos + $valor->valor_calculado ;
                                        }
                                        @endphp

                                        <tr>
                                            <td style="border-right: 2px solid black; text-align: center">
                                                {{$valor->cod_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black">
                                                {{$valor->desc_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black"></td>
                                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                            <td style="padding: 5px"></td>
                                        </tr>
                                        @elseif (($valor->classificacao == '2' && $valor->mes == $totalMensal7[$i]['mes'] && $valor->ano ==
                                        $totalMensal7[$i]['ano']) || ($valor->classificacao == 'D' && $valor->mes == $totalMensal7[$i]['mes'] &&
                                        $valor->ano == $totalMensal7[$i]['ano']))

                                        @php
                                        if(($valor->classificacao == '2')||($valor->classificacao == 'D')) {
                                        $totalDescontos = $totalDescontos + $valor->valor_calculado ;
                                        }
                                        @endphp

                                        <tr>
                                            <td style="border-right: 2px solid black; text-align: center">
                                                {{$valor->cod_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black">
                                                {{$valor->desc_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black"></td>
                                            <td style="padding: 5px; border-right: 2px solid black"></td>
                                            <td style="padding: 5px; text-align: right">
                                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                        </tr>
                                        @elseif (($valor->classificacao == '4' && $valor->mes == $totalMensal7[$i]['mes'] && $valor->ano ==
                                        $totalMensal7[$i]['ano']) || ($valor->classificacao == 'B' && $valor->mes == $totalMensal7[$i]['mes'] &&
                                        $valor->ano == $totalMensal7[$i]['ano']))
                                        <tr>
                                            <td style="border-right: 2px solid black; text-align: center">
                                                {{$valor->cod_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black">
                                                {{$valor->desc_evento}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                                {{number_format($valor->valor_referencia, 2, ',', '.')}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black; text-align: right">
                                                {{number_format($valor->valor_calculado, 2, ',', '.')}}</td>
                                            <td style="padding: 5px; border-right: 2px solid black"></td>
                                            <td style="padding: 5px"></td>
                                        </tr>
                                        @endif
                                        @endforeach


                                        <tr>
                                            <td style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black"
                                                colspan="4" rowspan="3"><b>Referência:</b>
                                                {{$mes}}/{{$totalMensal7[$i]['ano']}}</td>
                                            <td
                                                style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                                <b>Total de
                                                    Vencimentos:</b></td>
                                            <td style="padding: 5px; border-top: 2px solid black"><b>Total de
                                                    Descontos:</b></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px; text-align: right; border-right: 2px solid black">
                                                {{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}</td>
                                            <td style="padding: 5px; text-align: right">
                                                {{'R$ '.number_format($totalDescontos, 2, ',', '.')}}</td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="padding: 5px; border-top: 2px solid black; border-right: 2px solid black">
                                                <b>Total
                                                    Líquido:</b>
                                            </td>
                                            <td style="padding: 5px; text-align: right; border-top: 2px solid black">
                                                {{'R$ '.number_format($totalVencimentos - $totalDescontos, 2, ',', '.')}}
                                            </td>
                                        </tr>
                                        @php
                                        $totalVencimentos = 0;
                                        $totalDescontos = 0;
                                        $contador++;
                                        @endphp
                                        <div style="page-break-after: always">

                                    </table>

                                    @endfor

                                    @endif
                                    <!-- FIM LOOP TOTAL MENSAL 7 -->






</body>

<style>
    @page {
        margin: 3mm 3mm 3mm 3mm;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 50%;
    }
</style>

</html>