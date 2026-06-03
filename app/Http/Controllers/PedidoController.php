<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use Exception;
use Illuminate\Support\Facades\Cache;

class PedidoController extends Controller
{
    public function __construct(private readonly PedidoService $pedidoService) {}

    public function store(Request $request)
    {
        try {
            $pedido = $this->pedidoService->criarPedido($request->all());
            return response()->json($pedido, 201); // POST /pedidos 201 Created [cite: 39]
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], $e->getCode());
        }
    }

    public function index() {
        return response()->json(array_values(Cache::get('pedidos', [])));
    }

    public function show($id) {
        $pedidos = Cache::get('pedidos', []);
        return isset($pedidos[$id]) ? response()->json($pedidos[$id]) : response()->json(['erro' => 'Não encontrado'], 404);
    }

    public function updateStatus(Request $request, $id) {
        $pedidos = Cache::get('pedidos', []);
        if (!isset($pedidos[$id])) return response()->json(['erro' => 'Não encontrado'], 404);

        $pedidos[$id]['status'] = $request->input('status');
        Cache::put('pedidos', $pedidos);
        return response()->json($pedidos[$id]);
    }
}
