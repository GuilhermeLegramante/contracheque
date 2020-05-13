<?php

use Illuminate\Database\Seeder;

class PrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('prestadores')->insert([
                'cpfcnpj' => mt_rand(10000000000000, 99999999999999),
                'razaosocial' => Str::random(14),
                'nomefantasia' => Str::random(14),
                'inscricaomunicipal' => mt_rand(1000000000, 9999999999),
                'inscricaoestadual' => mt_rand(1000000000, 9999999999),
                'telefone' => mt_rand(1000000000, 9999999999),
                'email' => Str::random(10) . '@gmail.com',
                'cep' => mt_rand(10000000, 99999999),
                'rua' => Str::random(14),
                'numero' => mt_rand(1000, 9999),
                'bairro' => Str::random(14),
                'cidade' => Str::random(14),
                'uf' => Str::random(2),
                'emissaonotafiscal' => 'Sim',
                'emissaoreciboprovisorio' => 'Sim',
                'escritorio_id' => '1',
                'regimetributario' => 'Lucro Real',
                'aliquota' => '2',
                'exigibilidadeissqn' => 'Sim',
                'created_at' => now(),
            ]);
        }

    }
}
