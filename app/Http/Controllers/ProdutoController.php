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
        return view('produto.crud', compact('categorias'));
    }


    public function store(ProdutoRequest $request)
    {
        $data = $request->all();

        $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
        $data['preco'] = str_replace(',', '.', $data['preco']);

        $this->produtos->create($data);

        return redirect()->route('produto.index')->with('success', 'Produto criado com sucesso!');
    }


    public function show($id)
    {
        $produto = $this->produtos->find(($id));
        $produto->load('categoria');
        return response()->json($produto);
    }


    public function edit($id)
    {
        $produto = $this->produtos->find($id);
        $categorias = $this->categorias->all();
        return view('produto.crud', compact('produto', 'categorias'));
    }


    public function update(ProdutoRequest $request, $id)
    {
        $data = $request->all();
        $produto = $this->produtos->find($id);
        $data['preco'] = str_replace(',', '.', $data['preco']);

        if($request->hasFile('imagem')){
            Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
            $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($data);
        return redirect()->route('produto.index')->with('success', 'Produto alterado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = $this->produtos->find($id);
        Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
        $produto->delete();
        return redirect()->route('produto.index')->with('success', 'Produto apagado com sucesso!');
    }
}
