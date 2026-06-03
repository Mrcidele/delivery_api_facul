<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function confirmarPedido(Request $request)
    {
        // Retornar 202 Accepted + { status: "aceito", mensagem: "Pedido #X em processamento" } [cite: 33, 44]
        return response()->json([
            'status' => 'aceito',
            'mensagem' => "Pedido #{$request->input('pedidoId')} em processamento"
        ], 202);
    }
}
