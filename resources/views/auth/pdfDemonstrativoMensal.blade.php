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
            <td style="font-size:16px; font-weight: bold">'.$nomeempresa.'</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold">'.$logradouro.', '.$numeroempresa.'</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold">'.$cnpj.'</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">Folha: '.$descricaotipofolha.' -
                '.$ano.'/'.$descricaomes.'</td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-weight: bold; text-align: right">DEMONSTRATIVO DE PAGAMENTO DE SALÁRIO</td>
        </tr>
    </table>
    <table
        style="width: 100%; border: 2px solid black; font-size: 10px; border-top: 1px solid black; border-bottom: 1px solid black">
        <tr>
            <td style="padding-left: 5px"><b>Servidor: </b></td>
            <td><b>Contrato: </b></td>
            <td rowspan="2"><b>Padrão-Nível-Classe: </b></td>
        </tr>
        <tr>
            <td style="padding-left: 5px"><b>Função:</b> </td>
            <td><b>Lotação: </b>'.$lotacao.'</td>
            <td></td>
        </tr>
    </table>
    <table style="width: 100%; border: 2px solid black; border-top: 1px solid black; font-size: 10px" cellspacing="0">
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
            <td style="padding: 5px; text-align:right; border-bottom: 2px solid black; width: 17%"><b>Descontos</b></td>
        </tr>'
</body>

</html>