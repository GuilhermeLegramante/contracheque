@extends('adminlte::page')

@section('title', 'Emitir NFS-e')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')

<h3 style="margin-top: -20px;">Dados Gerais - NFS-e</h3>
<form id="" action="{{ route('prestador.nfse.emissao.emitir') }}" class="form" method="post">
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Nº NFS-e</label>
                        <input type="hidden" name="dadosNfse" value="{{json_encode($dadosNfse)}}">
                        <input type="hidden" name="dados" value="{{json_encode($dados)}}">
                        <input type="text" id="numeronfse" class="form-control" value="{{$dadosNfse->numeronfse}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Data Emissão</label>
                        <input type="date" name="dataemissao" id="dataemissao" class="form-control"
                            value="{{$dadosNfse->dataemissao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Data Prestação</label>
                        <input type="date" name="dataprestacao" id="dataprestacao" class="form-control"
                            value="{{$dadosNfse->dataprestacao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Local Prestação</label>
                        <input type="text" name="localprestacao" id="localprestacao" class="form-control"
                            value="{{$dadosNfse->localprestacao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Série</label>
                        <input type="text" name="serie" id="serie" class="form-control" value="{{$dadosNfse->serie}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Competência</label>
                        <input type="text" name="competencia" id="competencia" class="form-control"
                            value="{{$dadosNfse->competencia}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Ano</label>
                        <input type="text" name="ano" id="ano" class="form-control" value="{{$dadosNfse->ano}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->
        </div>
    </div>

    <h3>Dados do Prestador</h3>
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CPF/CNPJ</label>
                        <input type="text" name="cpfcnpj" id="cpfcnpj" class="form-control"
                            value="{{$dadosNfse->cpfcnpj}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Razão Social</label>
                        <input type="text" name="razaosocial" id="razaosocial" class="form-control"
                            value="{{$dadosNfse->razaosocial}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nome Fantasia</label>
                        <input type="text" name="nomefantasia" id="nomefantasia" class="form-control"
                            value="{{$dadosNfse->nomefantasia}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Inscrição Municipal</label>
                        <input type="text" name="inscricaomunicipal" id="inscricaomunicipal" class="form-control"
                            value="{{$dadosNfse->inscricaomunicipal}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Inscrição Estadual</label>
                        <input type="text" name="inscricaoestadual" id="inscricaoestadual" class="form-control"
                            value="{{$dadosNfse->inscricaoestadual}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$dadosNfse->email}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control"
                            value="{{$dadosNfse->telefone}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" value="{{$dadosNfse->cep}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="rua" id="rua" size="60" class="form-control"
                            value="{{$dadosNfse->rua}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="numero" id="numero" class="form-control" value="{{$dadosNfse->numero}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control" value="{{$dadosNfse->bairro}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{$dadosNfse->cidade}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>UF</label>
                        <input type="text" name="uf" id="uf" class="form-control" value="{{$dadosNfse->uf}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim terceira linha -->
        </div>
    </div>


    <h3>Dados do Tomador</h3>
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CPF/CNPJ</label>
                        <input type="text" name="cpfcnpjtomador" id="cpfcnpjtomador" class="form-control"
                            value="{{$dadosNfse->cpfcnpjtomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Razão Social</label>
                        <input type="text" name="razaosocialtomador" id="razaosocialtomador" class="form-control"
                            value="{{$dadosNfse->razaosocialtomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nome Fantasia</label>
                        <input type="text" name="nomefantasiatomador" id="nomefantasiatomador" class="form-control"
                            value="{{$dadosNfse->nomefantasiatomador}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="emailtomador" id="emailtomador" class="form-control"
                            value="{{$dadosNfse->emailtomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dadosNfse->telefonetomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="ceptomador" id="ceptomador" class="form-control"
                            value="{{$dadosNfse->ceptomador}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="ruatomador" id="ruatomador" class="form-control"
                            value="{{$dadosNfse->ruatomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="numerotomador" id="numerotomador" class="form-control"
                            value="{{$dadosNfse->numerotomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairrotomador" id="bairrotomador" class="form-control"
                            value="{{$dadosNfse->bairrotomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="cidadetomador" id="cidadetomador" class="form-control"
                            value="{{$dadosNfse->cidadetomador}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>UF</label>
                        <input type="text" name="uftomador" id="uftomador" class="form-control"
                            value="{{$dadosNfse->uftomador}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim terceira linha -->
        </div>
    </div>

    <h3>Dados do(s) Serviço(s)</h3>
    <div class="card">
        <div class="card-body">
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CNAE</label>
                        <input type="hidden" name="cnaecompleto" value="{{json_encode($cnaeCompleto)}}">
                        <input type="text" name="cnae" id="cnae" class="form-control"
                            value="{{$cnaeCompleto[0]->codigo . ' - ' . $cnaeCompleto[0]->descricao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atividade</label>
                        <input type="hidden" name="atividadecompleta" value="{{json_encode($atividadeCompleta)}}">
                        <input type="text" name="atividade" id="atividade" class="form-control"
                            value="{{$atividadeCompleta[0]->codigo . ' - ' . $atividadeCompleta[0]->descricao}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                            value="{{$dados->descricao}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Valor do Serviço (R$)</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dados->valor}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Deduções</label>
                        <input type="text" name="deducoes" id="dedudoces" class="form-control"
                            value="{{$dados->deducoes}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Condicionado</label>
                        <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control"
                            value="{{$dados->descontocondicionado}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Incondicionado</label>
                        <input type="text" name="descontoincondicionado" id="descontoincondicionado"
                            class="form-control" value="{{$dados->descontoincondicionado}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Alíquota</label>
                        <input type="text" name="aliquota" id="aliquota" class="form-control"
                            value="{{$dados->aliquota}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Exigibilidade ISS</label>
                        <input type="text" name="exigibilidadeissvariavel" id="exigibilidadeissvariavel"
                            class="form-control" value="{{$dados->exigibilidadeissvariavel}}" disabled>
                    </div>
                </div>

            </div>
            <!-- fim terceira linha -->

            <!-- quarta linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total de ISS (R$)</label>
                        <input type="text" name="valoraproximadotributos" id="valoraproximadotributos"
                            class="form-control" value="{{$dados->valoraproximadotributos}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>COFINS (%)</label>
                        <input type="text" name="cofins" id="cofins" class="form-control" value="{{$dados->cofins}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CSLL (%)</label>
                        <input type="text" name="csll" id="csll" class="form-control" value="{{$dados->csll}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>PIS (%)</label>
                        <input type="text" name="pis" id="pis" class="form-control" value="{{$dados->pis}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>IR (%)</label>
                        <input type="text" name="ir" id="ir" class="form-control" value="{{$dados->ir}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim quarta linha -->
        </div>
    </div>

    <!-- DADOS SERVIÇO 02 -->
    @if (isset($dados->cnaes_2))
    <div class="card">
        <div class="card-body">
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CNAE</label>
                        <input type="text" name="cnae" id="cnae" class="form-control"
                            value="{{$cnaeCompleto2[0]->codigo . ' - ' . $cnaeCompleto2[0]->descricao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atividade</label>
                        <input type="text" name="atividade" id="atividade" class="form-control"
                            value="{{$atividadeCompleta2[0]->codigo . ' - ' . $atividadeCompleta2[0]->descricao}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                            value="{{$dados->descricao_2}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Valor do Serviço (R$)</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dados->valor_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Deduções</label>
                        <input type="text" name="deducoes" id="dedudoces" class="form-control"
                            value="{{$dados->deducoes_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Condicionado</label>
                        <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control"
                            value="{{$dados->descontocondicionado_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Incondicionado</label>
                        <input type="text" name="descontoincondicionado" id="descontoincondicionado"
                            class="form-control" value="{{$dados->descontoincondicionado_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Alíquota</label>
                        <input type="text" name="aliquota" id="aliquota" class="form-control"
                            value="{{$dados->aliquota_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Exigibilidade ISS</label>
                        <input type="text" name="exigibilidadeissvariavel" id="exigibilidadeissvariavel"
                            class="form-control" value="{{$dados->exigibilidadeissvariavel_2}}" disabled>
                    </div>
                </div>

            </div>
            <!-- fim terceira linha -->

            <!-- quarta linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total de ISS (R$)</label>
                        <input type="text" name="valoraproximadotributos" id="valoraproximadotributos"
                            class="form-control" value="{{$dados->valoraproximadotributos_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>COFINS (%)</label>
                        <input type="text" name="cofins" id="cofins" class="form-control" value="{{$dados->cofins_2}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CSLL (%)</label>
                        <input type="text" name="csll" id="csll" class="form-control" value="{{$dados->csll_2}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>PIS (%)</label>
                        <input type="text" name="pis" id="pis" class="form-control" value="{{$dados->pis_2}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>IR (%)</label>
                        <input type="text" name="ir" id="ir" class="form-control" value="{{$dados->ir_2}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim quarta linha -->
        </div>
    </div>
    @endif

    <!-- DADOS SERVIÇO 03 -->
    @if (isset($dados->cnaes_3))
    <div class="card">
        <div class="card-body">
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CNAE</label>
                        <input type="text" name="cnae" id="cnae" class="form-control"
                            value="{{$cnaeCompleto3[0]->codigo . ' - ' . $cnaeCompleto3[0]->descricao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atividade</label>
                        <input type="text" name="atividade" id="atividade" class="form-control"
                            value="{{$atividadeCompleta3[0]->codigo . ' - ' . $atividadeCompleta3[0]->descricao}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                            value="{{$dados->descricao_3}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Valor do Serviço (R$)</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dados->valor_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Deduções</label>
                        <input type="text" name="deducoes" id="dedudoces" class="form-control"
                            value="{{$dados->deducoes_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Condicionado</label>
                        <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control"
                            value="{{$dados->descontocondicionado_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Incondicionado</label>
                        <input type="text" name="descontoincondicionado" id="descontoincondicionado"
                            class="form-control" value="{{$dados->descontoincondicionado_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Alíquota</label>
                        <input type="text" name="aliquota" id="aliquota" class="form-control"
                            value="{{$dados->aliquota_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Exigibilidade ISS</label>
                        <input type="text" name="exigibilidadeissvariavel" id="exigibilidadeissvariavel"
                            class="form-control" value="{{$dados->exigibilidadeissvariavel_3}}" disabled>
                    </div>
                </div>

            </div>
            <!-- fim terceira linha -->

            <!-- quarta linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total de ISS (R$)</label>
                        <input type="text" name="valoraproximadotributos" id="valoraproximadotributos"
                            class="form-control" value="{{$dados->valoraproximadotributos_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>COFINS (%)</label>
                        <input type="text" name="cofins" id="cofins" class="form-control" value="{{$dados->cofins_3}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CSLL (%)</label>
                        <input type="text" name="csll" id="csll" class="form-control" value="{{$dados->csll_3}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>PIS (%)</label>
                        <input type="text" name="pis" id="pis" class="form-control" value="{{$dados->pis_3}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>IR (%)</label>
                        <input type="text" name="ir" id="ir" class="form-control" value="{{$dados->ir_3}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim quarta linha -->
        </div>
    </div>
    @endif


    <!-- DADOS SERVIÇO 04 -->
    @if (isset($dados->cnaes_4))
    <div class="card">
        <div class="card-body">
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CNAE</label>
                        <input type="text" name="cnae" id="cnae" class="form-control"
                            value="{{$cnaeCompleto4[0]->codigo . ' - ' . $cnaeCompleto4[0]->descricao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atividade</label>
                        <input type="text" name="atividade" id="atividade" class="form-control"
                            value="{{$atividadeCompleta4[0]->codigo . ' - ' . $atividadeCompleta4[0]->descricao}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                            value="{{$dados->descricao_4}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Valor do Serviço (R$)</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dados->valor_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Deduções</label>
                        <input type="text" name="deducoes" id="dedudoces" class="form-control"
                            value="{{$dados->deducoes_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Condicionado</label>
                        <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control"
                            value="{{$dados->descontocondicionado_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Incondicionado</label>
                        <input type="text" name="descontoincondicionado" id="descontoincondicionado"
                            class="form-control" value="{{$dados->descontoincondicionado_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Alíquota</label>
                        <input type="text" name="aliquota" id="aliquota" class="form-control"
                            value="{{$dados->aliquota_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Exigibilidade ISS</label>
                        <input type="text" name="exigibilidadeissvariavel" id="exigibilidadeissvariavel"
                            class="form-control" value="{{$dados->exigibilidadeissvariavel_4}}" disabled>
                    </div>
                </div>

            </div>
            <!-- fim terceira linha -->

            <!-- quarta linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total de ISS (R$)</label>
                        <input type="text" name="valoraproximadotributos" id="valoraproximadotributos"
                            class="form-control" value="{{$dados->valoraproximadotributos_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>COFINS (%)</label>
                        <input type="text" name="cofins" id="cofins" class="form-control" value="{{$dados->cofins_4}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CSLL (%)</label>
                        <input type="text" name="csll" id="csll" class="form-control" value="{{$dados->csll_4}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>PIS (%)</label>
                        <input type="text" name="pis" id="pis" class="form-control" value="{{$dados->pis_4}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>IR (%)</label>
                        <input type="text" name="ir" id="ir" class="form-control" value="{{$dados->ir_4}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim quarta linha -->
        </div>
    </div>
    @endif

    <!-- DADOS SERVIÇO 05 -->
    @if (isset($dados->cnaes_5))
    <div class="card">
        <div class="card-body">
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CNAE</label>
                        <input type="text" name="cnae" id="cnae" class="form-control"
                            value="{{$cnaeCompleto5[0]->codigo . ' - ' . $cnaeCompleto5[0]->descricao}}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atividade</label>
                        <input type="text" name="atividade" id="atividade" class="form-control"
                            value="{{$atividadeCompleta5[0]->codigo . ' - ' . $atividadeCompleta5[0]->descricao}}"
                            disabled>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                            value="{{$dados->descricao_5}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

            <!-- terceira linha -->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Valor do Serviço (R$)</label>
                        <input type="text" name="telefonetomador" id="telefonetomador" class="form-control"
                            value="{{$dados->valor_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Deduções</label>
                        <input type="text" name="deducoes" id="dedudoces" class="form-control"
                            value="{{$dados->deducoes_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Condicionado</label>
                        <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control"
                            value="{{$dados->descontocondicionado_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Desconto Incondicionado</label>
                        <input type="text" name="descontoincondicionado" id="descontoincondicionado"
                            class="form-control" value="{{$dados->descontoincondicionado_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Alíquota</label>
                        <input type="text" name="aliquota" id="aliquota" class="form-control"
                            value="{{$dados->aliquota_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Exigibilidade ISS</label>
                        <input type="text" name="exigibilidadeissvariavel" id="exigibilidadeissvariavel"
                            class="form-control" value="{{$dados->exigibilidadeissvariavel_5}}" disabled>
                    </div>
                </div>

            </div>
            <!-- fim terceira linha -->

            <!-- quarta linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Total de ISS (R$)</label>
                        <input type="text" name="valoraproximadotributos" id="valoraproximadotributos"
                            class="form-control" value="{{$dados->valoraproximadotributos_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>COFINS (%)</label>
                        <input type="text" name="cofins" id="cofins" class="form-control" value="{{$dados->cofins_5}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>CSLL (%)</label>
                        <input type="text" name="csll" id="csll" class="form-control" value="{{$dados->csll_5}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>PIS (%)</label>
                        <input type="text" name="pis" id="pis" class="form-control" value="{{$dados->pis_5}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>IR (%)</label>
                        <input type="text" name="ir" id="ir" class="form-control" value="{{$dados->ir_5}}" disabled>
                    </div>
                </div>
            </div>
            <!-- fim quarta linha -->
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6" style="text-align: center;">
                    <button id="voltar" title="Voltar" class="btn btn-info"><i class="fas fa-chevron-left"></i>
                        Voltar</a>
                </div>
                <div class="col-sm-6" style="text-align: center;">
                    <button type="submit" class="btn btn-success" style="width: 50%;">
                        Emitir NFS-e
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>



@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
<script>
    $("#voltar").click(function(e) {
        e.preventDefault();
        window.history.back();
    });
</script>
@stop