<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class PedidoService
{
    public function criarPedido(array $dados): array
    {
        // Regra: Pedido sem itens retorna erro 400 antes da API
        if (empty($dados['itens'])) {
            throw new Exception('Pedido sem itens', 400);
        }

        // Usar no POST /pedidos para buscar endereço pelo CEP
        $response = Http::get("https://viacep.com.br/ws/{$dados['cep']}/json/");
        $viaCepData = $response->json();

        // Regra: CEP não encontrado retorna 400
        if ($response->failed() || isset($viaCepData['erro'])) {
            throw new Exception('CEP inválido', 400);
        }

        // Regra: Taxa de entrega calculada pelo CEP do pedido via ViaCEP
        $cidade = $viaCepData['localidade'];
        // Mesmo município (Curitiba): R$ 5,00 | Outro município: R$ 15,00
        $taxaEntrega = ($cidade === 'Curitiba') ? 5.00 : 15.00;

        // Salvar logradouro + bairro + cidade no pedido
        $enderecoCompleto = "{$viaCepData['logradouro']}, {$viaCepData['bairro']}, {$cidade}";

        $novoId = Cache::get('pedido_id_counter', 1);
        Cache::put('pedido_id_counter', $novoId + 1);

        // Recursos da API: Pedido
        $pedido = [
            'id' => $novoId,
            'cliente' => $dados['cliente'],
            'cep' => $dados['cep'],
            'enderecoEntrega' => $enderecoCompleto,
            'taxaEntrega' => $taxaEntrega,
            'total' => $dados['total'] ?? 0,
            'status' => 'pendente',
            'itens' => $dados['itens']
        ];

        // Persistência em cache (sem SQL)
        $pedidos = Cache::get('pedidos', []);
        $pedidos[$novoId] = $pedido;
        Cache::put('pedidos', $pedidos);

        return $pedido;
    }
}
