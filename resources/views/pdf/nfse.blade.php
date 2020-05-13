<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    @page {
      size: 7in 9.25in;
      margin: 5mm 5mm 5mm 5mm;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    #logo-head-left {
      width: 60px;
      height: 80px;
      margin-left: 10px;
      margin-top: 10px;
      text-align: center;
    }

    #img-qrcode {
      width: 115px;
      height: 105px;
      text-align: center;
      margin-left: 5%;
      margin-top: 2%;
    }

    h2 {
      font-size: 10px;
    }

    h3 {
      font-size: 12px;
    }

    #header {
      border-top: 0.5px solid black;

    }

    #col-1-head {
      width: 60px;
      float: left;
      height: 70px;
      align-items: center;
      border-left: 1px solid black;
      border-bottom: 1px solid black;

    }

    #col-2-head {
      width: 250px;
      height: 70px;
      float: left;
      border-bottom: 0.5px solid black;

    }

    #col-3-head {
      width: 216px;
      float: left;
      height: 70px;
      border-left: 1px solid black;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
      text-align: center;
    }

    #col-4-head {
      width: 104px;
      float: left;
      height: 70px;
      text-align: center;
      align-items: center;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
    }

    #img-qrcode {
      width: 110px;
      height: 105px;
      text-align: center;
      margin-left: 5%;
      margin-top: 2px;
    }

    #head-prestador {
      margin-top: 121px;
    }

    .head-section {
      padding: -12px;
      background: #ebebe0;
      height: 40px;
      text-align: center;
      border-bottom: 1px solid black;
    }

    .content-section {
      border-bottom: 1px solid black;
      border-left: 1px solid black;
      border-right: 1px solid black;
      margin-top: -20px;
      padding: 5px;
    }

    .content-section-table {
      padding: -1px;
      border-bottom: 1px solid black;
    }

    .content-section-center {
      text-align: center;
      padding: 5px;
      border-bottom: 1px solid black;
    }

    .h2-head-section {
      color: black;
      padding: -6px;
    }

    table {
      width: 100%;
    }

    th {
      text-align: left;
    }

    .th-content-section {
      font-size: 10px;
      border-bottom: 1px solid black;
      border-left: 1px solid black;
    }

    .th-content-section-left {
      font-size: 10px;
      border-bottom: 1px solid black;
    }

    .td-content-section {

      font-size: 10px;
      border-bottom: 1px solid black;
      border-left: 1px solid black;
    }

    .content-section-footer {
      text-align: right;
      padding: 2px;
      border-bottom: 1px solid black;
    }

    .content-grid-cel {
      width: 156px;
      float: left;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
      padding-left: 10px;
      font-size: 8px;
    }

    .content-last-grid-cel {
      width: 19.2%;
      float: left;
      border-bottom: 1px solid black;
      padding-left: 10px;
      font-size: 8px;
    }

    .content-grid-cel-2 {
      width: 156px;
      float: left;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
      padding-left: 10px;
      margin-bottom: -5px;
      font-size: 8px;
      margin-top: -10px;
    }

    strong {
      font-weight: bold;
    }

    .p-content {
      font-size: 8px;
      padding-bottom: -10px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div id="header">
    <div id="col-1-head">
      <img style="height: 50px; width: 40px;" id="logo-head-left" src="{{public_path('img/logo.png')}}" alt="">
    </div>

    <div id="col-2-head">
      <p style="margin-top: 15px; font-size: 9px;"><strong>MUNICÍPIO DE SANTIAGO <br>
          SECRETARIA MUNICIPAL DA FAZENDA <br>
          NOTA FISCAL DE SERVIÇOS ELETRÔNICA - NFS-e </p>
      </strong>
    </div>

    <div style=" font-size: 10px;" id="col-3-head">
      <p style="margin-top: 15px;">
        Número / Série NFS-e: <strong> {{$dadosNfse->numeronfse}} / {{$dadosNfse->serie}} </strong> <br>
        Número / Série RPS: - <br>
        Data de Emissão: <strong>{{$dadosNfse->dataemissao}}</strong>
      </p>
    </div>

    <div id="col-4-head">
      <img style="width: 75px; height: 65px; text-align: center;" id="img-qrcode"
        src="{{public_path('img/qrcode.png')}}" alt="">
    </div>
  </div>
  <!-- End - Header -->

  <div style="text-align: center;">
    <div
      style="border-right: 1px solid black; height: 20px; background: #ebebe0; margin-top: -50px; border-bottom: 1px solid black;">
      <h2 id="head-prestador" style="border-top: 1px solid black; padding-top: 3px;">PRESTADOR DE SERVIÇOS</h2>
    </div>
  </div>

  <!-- Content - Prestador de Serviços -->
  <div class="content-section" style="">
    <p class="p-content">
      <br>
      <strong>CNPJ/CPF: </strong>{{$dadosNfse->cpfcnpj}}
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <strong>Inscrição Estadual: </strong> {{$dadosNfse->inscricaoestadual}} &nbsp;&nbsp;
      <strong>Inscrição Municipal: </strong> {{$dadosNfse->inscricaomunicipal}}
    </p>

    <p class="p-content">
      <strong>Nome/Razão Social:</strong> {{$dadosNfse->razaosocial}} &nbsp;&nbsp;
    </p>

    <p class="p-content">
      <strong>Nome Fantasia: </strong> {{$dadosNfse->nomefantasia}} &nbsp;&nbsp;
    </p>

    <p class="p-content">
      <strong> Endereço: </strong> {{$dadosNfse->rua}}, &nbsp; {{$dadosNfse->numero}}, &nbsp; CEP {{$dadosNfse->cep}}
      &nbsp;&nbsp;
    </p>

    <p class="p-content">
      <strong> Município: </strong>{{$dadosNfse->cidade}} &nbsp; {{$dadosNfse->uf}} &nbsp;&nbsp;
      <strong> Telefone: </strong> {{$dadosNfse->rua}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong> E-mail: </strong> {{$dadosNfse->email}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong> Local de Tributação: </strong> {{$dadosNfse->cidade}} &nbsp; {{$dadosNfse->uf}} &nbsp;&nbsp;
    </p>
  </div>
  <!-- End - Content Prestador de Serviços -->

  <!-- Head - Tomador de Serviços -->
  <div class="head-section">
    <h2 class="h2-head-section">TOMADOR DE SERVIÇOS</h2>
  </div>
  <!-- End Head - Tomador de Serviços -->

  <!-- Content - Tomador de Serviços -->
  <div class="content-section">
    <p class="p-content">
      <br>
      <strong>CNPJ/CPF:</strong> {{$dadosNfse->cpfcnpjtomador}}
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong>Nome/Razão Social: </strong> {{$dadosNfse->razaosocialtomador}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong>Nome Fantasia: </strong> {{$dadosNfse->nomefantasiatomador}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong>Endereço: </strong> {{$dadosNfse->ruatomador}}, &nbsp; {{$dadosNfse->numerotomador}}, &nbsp; CEP
      {{$dadosNfse->ceptomador}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong>Município: </strong> {{$dadosNfse->cidadetomador}} &nbsp; {{$dadosNfse->uftomador}} &nbsp;&nbsp;
      <strong>Telefone: </strong> {{$dadosNfse->telefonetomador}} &nbsp;&nbsp;
    </p>
    <p class="p-content">
      <strong>E-mail: </strong> {{$dadosNfse->emailtomador}} &nbsp;&nbsp;
    </p>
  </div>
  <!-- End - Content Tomador de Serviços -->

  <!-- Head - Discriminação dos Serviços -->
  <div style="border-right: 1px solid black; border-left: 1px solid black;" class="head-section">
    <h2 class="h2-head-section">DISCRIMINAÇÃO DOS SERVIÇOS</h2>
  </div>
  <!-- End Head - Discriminação dos Serviços -->

  <!-- Content - Discriminação dos Serviços -->
  <div style="border-right: 1px solid black; border-left: 1px solid black;" class="content-section-table">
    <table>
      <tr style="background:#ebebe0;">
        <th class="th-content-section-left">Descrição</th>
        <th class="th-content-section">L.C. 116</th>
        <th class="th-content-section">Alíquota (%)</th>
        <th class="th-content-section">Desconto Cond.</th>
        <th class="th-content-section">Desconto Inc.</th>
        <th class="th-content-section">Valor Serviço</th>
        <th class="th-content-section">ISSQN</th>
      </tr>
      <tr>
        <td class="td-content-section">{{$atividadeCompleta[0]->descricao}}
          {{$dados->descricao}}</td>
        <td class="td-content-section">{{$atividadeCompleta[0]->codigo}}</td>
        <td class="td-content-section">{{$dados->aliquota}}</td>
        <td class="td-content-section">{{$dados->descontocondicionado}}</td>
        <td class="td-content-section">{{$dados->descontoincondicionado}}</td>
        <td class="td-content-section">{{$dados->valor}}</td>
        <td class="td-content-section">{{$dados->valoraproximadotributos}}</td>
      </tr>
    </table>
  </div>
  <div
    style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;"
    class="content-section-footer">
    <h2 style="margin-top: 4px; margin-bottom: 4px;">VALOR TOTAL DA NOTA FISCAL: R$ 500,00</h2>
  </div>
  <!-- End Content - Discriminação dos Serviços -->

  <!-- Head - Demonstrativo de Cálculo -->
  <div style="border-left: 1px solid black; border-right: 1px solid black;" class="head-section">
    <h2 class="h2-head-section">DEMONSTRATIVO DE CÁLCULO</h2>
  </div>
  <!-- End Head - Demonstrativo de Cálculo -->

  <!-- Content - Demonstrativo de Cálculo -->
  <div style="border-left: 1px solid black;" class="content-grid-cel">
    <p class="p-content">
      Valor de Serviço <br> <strong> {{$dados->valor}}</strong>
    </p>
  </div>
  <div class="content-grid-cel">
    <p class="p-content">
      Itens não tributáveis <br> <strong> 0,00</strong>
    </p>
  </div>
  <div class="content-grid-cel">
    <p class="p-content">
      Desconto Condicionado <br> <strong> {{$dados->descontocondicionado}}</strong>
    </p>
  </div>
  <div style=" border-right: 1px solid black;" class="content-last-grid-cel">
    <p class="p-content">
      Deduções <br> <strong> {{$dados->deducoes}}</strong>
    </p>
  </div>

  <br><br><br>

  <!-- Content - Demonstrativo de Cálculo Linha 02 -->
  <div style="border-left: 1px solid black;" class="content-grid-cel-2">
    <p class="p-content">
      Red. na Base de Cálculo <br> <strong> {{$dados->valor}}</strong>
    </p>
  </div>
  <div class="content-grid-cel-2">
    <p class="p-content">
      Valor aprox. de Tributos <br> <strong> {{$dados->valoraproximadotributos}}</strong>
    </p>
  </div>
  <div class="content-grid-cel-2">
    <p class="p-content">
      Base de Cálculo <br> <strong> 0,00</strong>
    </p>
  </div>
  <div style="width: 122px; border-right: 1px solid black;" class="content-grid-cel-2">
    <p class="p-content">
      ISSQN <br> <strong> 0,00</strong>
    </p>
  </div>
  <br><br>
  <!-- End Content - Demonstrativo de Cálculo -->

  <!-- Head - Retenções Federais -->
  <div style="border-left: 1px solid black; border-right: 1px solid black;" class="head-section">
    <h2 class="h2-head-section">RETENÇÕES FEDERAIS</h2>
  </div>
  <!-- End Head - Retenções Federais -->

  <!-- Content - Retenções Federais -->
  <div style="" class="content-grid-cel">
    <p class="p-content">
      Valor de Serviço <br> <strong> {{$dados->valor}}</strong>
    </p>
  </div>
  <div class="content-grid-cel">
    <p class="p-content">
      Itens não tributáveis <br> <strong> 0,00</strong>
    </p>
  </div>
  <div class="content-grid-cel">
    <p class="p-content">
      Desconto Condicional <br> <strong> {{$dados->descontocondicionado}}</strong>
    </p>
  </div>
  <div class="content-last-grid-cel">
    <p class="p-content">
      Deduções <br> <strong> {{$dados->deducoes}}</strong>
    </p>
  </div>
  <div
    style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;"
    class="content-section-footer">
    <h2 style="margin-top: 4px; margin-bottom: 4px;">VALOR LÍQUIDO DA NOTA FISCAL: R$ {{$dados->valor}}</h2>
  </div>
  <!-- End Content - Retenções Federais -->

  <!-- Head - Informações Adicionais -->
  <div style="border-left: 1px solid black; border-right: 1px solid black;" class="head-section">
    <h2 class="h2-head-section">INFORMAÇÕES ADICIONAIS</h2>
  </div>
  <!-- End Head - Informações Adicionais -->

  <!-- Content - Informações Adicionais -->
  <div class="content-section">
    <p class="p-content">
      Documento emitido por ME/EPP optante pelo Simples Nacional
    </p>
    <p class="p-content">
      Correspondência do código municipal com o código da Lei Complementar 116/2003
    </p>
  </div>
  <!-- End - Content Informações Adicionais -->


  <!-- Head - Autenticidade -->
  <div class="head-section">
    <h2 class="h2-head-section">AUTENTICIDADE</h2>
  </div>
  <!-- End Head - Autenticidade -->

  <!-- Content - Autenticidade -->
  <div class="content-section-center">
    <p style="" class="p-content">
      A autenticidade desta Nota Fiscal de Serviços Eletrônica - NFS-e pode ser verificada no portal do Município no
      endereço: <br>
      https://nfse.santiago.rs.gov.br/site <br>
      <strong>Código de Verificação: 87238262</strong> <br>
      <strong>Chave de Acesso: 00-19140972000100-55-0N1-000000033/087238262</strong>
    </p>
  </div>
  <!-- End - Content Autenticidade -->


</body>

</html>