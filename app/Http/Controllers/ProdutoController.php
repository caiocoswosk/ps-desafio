<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProdutoController extends Controller
{

    private $produtos;
    private $categorias;

    public function __construct(Produto $produtos, Categoria $categorias)
    {
        $this->produtos = $produtos;
        $this->categorias = $categorias;
    }

    public function index()
    {
        $produtos = $this->produtos->all();
        return view('produto.index', compact('produtos'));
    }


    public function create()
    {
        $categorias = $this->categorias->all();
        if (!empty($categorias)){
            return view('produto.crud', compact('categorias'));
        } else {
            return redirect()->route('produto.index')->with('danger', 'Registre uma categoria primeiro!');
        }
    }


    public function store(ProdutoRequest $request)
    {
        $data = $request->all();

        $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
        // substitui a vírgula por ponto
        $data['preco'] = str_replace(',', '.', $data['preco']);

        $this->produtos->create($data);

        return redirect()->route('produto.index')->with('success', 'Produto criado com sucesso!');
    }


    public function show($id)
    {
        $produto = $this->produtos->find(($id));
        if (!empty($produto)){
            $produto->load('categoria');
        }
        return response()->json($produto);
    }


    public function edit($id)
    {
        $produto = $this->produtos->find($id);
        if (!empty($produto)) {
            $categorias = $this->categorias->all();
            return view('produto.crud', compact('produto', 'categorias'));
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }


    public function update(ProdutoRequest $request, $id)
    {
        $data = $request->all();
        $produto = $this->produtos->find($id);
        if (!empty($produto)) {
            $data['preco'] = str_replace(',', '.', $data['preco']);

            if ($request->hasFile('imagem')) {
                // verifica se possui imagem para excluí-la
                if (!empty($produto->imagem)) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
                }
                $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
            }

            $produto->update($data);
            return redirect()->route('produto.index')->with('success', 'Produto alterado com sucesso!');
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }

    public function destroy($id)
    {
        $produto = $this->produtos->find($id);
        if (!empty($produto)) {
            // verifica se possui imagem para excluí-la
            if (!empty($produto->imagem)) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
            }
            $produto->delete();
            return redirect()->route('produto.index')->with('success', 'Produto apagado com sucesso!');
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }
}
