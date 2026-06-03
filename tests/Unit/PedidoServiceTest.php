<?php

use Tests\TestCase;
use App\Services\PedidoService;
use Illuminate\Support\Facades\Http;

uses(TestCase::class);

test('Service: rejeitar pedido sem itens e retornar erro', function () {
    $service = new PedidoService();

    $service->criarPedido([
        'cliente' => 'Ana Lima',
        'cep' => '80010-000',
        'itens' => []
    ]);
})->throws(Exception::class, 'Pedido sem itens');

test('Service: calcular taxa de entrega por municipio', function () {
    Http::fake([
        'viacep.com.br/*' => Http::response([
            'logradouro' => 'Rua XV de Novembro',
            'bairro' => 'Centro',
            'localidade' => 'Curitiba'
        ], 200)
    ]);

    $service = new PedidoService();

    $pedido = $service->criarPedido([
        'cliente' => 'Ana Lima',
        'cep' => '80010-000',
        'total' => 45.90,
        'itens' => ['Pizza']
    ]);

    expect($pedido['taxaEntrega'])->toBe(5.00);
});
