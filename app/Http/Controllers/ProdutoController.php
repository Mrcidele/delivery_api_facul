<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(array_values(Cache::get('produtos', [])));
    }

    public function store(Request $request)
    {
        // Recursos da API: Produto [cite: 6]
        $produto = [
            'nome' => $request->nome,
            'preco' => $request->preco,
            'categoria' => $request->categoria,
            'disponivel' => $request->disponivel ?? true
        ];

        $produtos = Cache::get('produtos', []);
        $produtos[] = $produto;
        Cache::put('produtos', $produtos);

        return response()->json($produto, 201);
    }
}
