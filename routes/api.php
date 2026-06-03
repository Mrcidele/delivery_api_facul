<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EventoController;

// Endpoints obrigatórios de Produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);

// Endpoints obrigatórios de Pedidos
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
Route::put('/pedidos/{id}/status', [PedidoController::class, 'updateStatus']);

// Evento M5
Route::post('/eventos/pedido-confirmado', [EventoController::class, 'confirmarPedido']);
