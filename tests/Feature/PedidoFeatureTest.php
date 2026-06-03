<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

uses(TestCase::class);

test('POST /pedidos retorna 201 com pedido criado', function () {
    Http::fake([
        'viacep.com.br/*' => Http::response([
            'logradouro' => 'Rua XV de Novembro',
            'bairro' => 'Centro',
            'localidade' => 'Curitiba'
        ], 200)
    ]);

    $response = $this->postJson('/api/pedidos', [
        'cliente' => 'Ana Lima',
        'cep' => '80010-000',
        'total' => 45.90,
        'itens' => ['Pizza']
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'cliente' => 'Ana Lima',
            'cep' => '80010-000',
            'enderecoEntrega' => 'Rua XV de Novembro, Centro, Curitiba',
            'taxaEntrega' => 5.00,
            'status' => 'pendente'
        ]);
});
