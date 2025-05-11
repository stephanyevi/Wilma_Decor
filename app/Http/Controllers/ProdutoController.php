<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public readonly Produto $produtos;

    public function __construct()
    {
        $this->produtos = new Produto();
    }

    
    public function index()
    {
        $produtos = $this->produtos->all();
        return response()->json($produtos);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nome'       => ['required', 'string', 'max:255'],
            'valor'      => ['required', 'numeric', 'between:0,9999.99'],
            'cor'        => ['required', 'string', 'max:50'],
            'quantidade' => ['required', 'integer'],
        ]);

        $produto = Produto::create([
            'nome'       => $request->nome,
            'valor'      => $request->valor,
            'cor'        => $request->cor,
            'quantidade' => $request->quantidade,
        ]);

        return response()->json([
            'message' => 'Produto criado com êxito.',
            'produto' => $produto
        ], 201);
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        return response()->json($produto);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome'       => ['required', 'string', 'max:255' . $id], 
            'valor'      => ['required', 'numeric', 'between:0,9999.99'],
            'cor'        => ['required', 'string', 'max:50'],
            'quantidade' => ['required', 'integer'],
        ]);

        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        $produto->update([
            'nome'       => $request->nome,
            'valor'      => $request->valor,
            'cor'        => $request->cor,
            'quantidade' => $request->quantidade,
        ]);

        return response()->json([
            'message' => 'Produto atualizado com êxito.',
            'produto' => $produto
        ]);
    }

    
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        $produto->delete();

        return response()->json(['message' => 'Produto excluído com êxito.']);
    }
}
