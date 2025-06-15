<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('id')->get();

        if ($categorias->isEmpty()) {
            return response()->json([
                'message' => 'Nenhuma categoria encontrada.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Categorias encontradas.',
            'data' => $categorias
        ], 200);
    } 


    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $categoria = Categoria::create($request->all());

            return response()->json([
                'message' => 'Categoria criada com sucesso.',
                'data' => $categoria
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro na validação dos dados.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar categoria.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            return response()->json([
                'message' => 'Categoria encontrada.',
                'data' => $categoria
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar categoria.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $categoria = Categoria::findOrFail($id);
            $categoria->update($request->all());

            return response()->json([
                'message' => 'Categoria atualizada com sucesso.',
                'data' => $categoria
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro na validação dos dados.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar categoria.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $nome = $categoria->nome;
            $categoria->delete();

            return response()->json([
                'message' => "Categoria '{$nome}' deletada com sucesso.",
                'nome' => $nome
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar categoria.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
