<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Produto;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    private $produtos;
    private $categorias;

    public function __construct(Produto $produto, Categoria $categoria)
    {
        $this->produtos = $produto;
        $this->categorias = $categoria;
    }

    public function index()
    {
        $categorias = $this->categorias->all();
        return view('categoria.index', compact('categorias'));
    }


    public function create()
    {
        return view('categoria.crud');
    }


    public function store(CategoriaRequest $request)
    {
        $data = $request->all();
        $this->categorias->create($data);

        return redirect()->route('categoria.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show($id)
    {
        $categoria = $this->categorias->find($id);
        return response()->json($categoria);
    }

    public function edit($id)
    {
        $categoria = $this->categorias->find($id);
        return view('categoria.crud', compact('categoria'));
    }

    public function update(CategoriaRequest $request, $id)
    {
        $data = $request->all();
        $categoria = $this->categorias->find($id);
        $categoria->update($data);

        return redirect()->route('categoria.index')->with('success', 'Categoria alterada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = $this->categorias->find($id);
        $produtos = $this->produtos->where('categoria_id', $id)->whereNotNull('imagem')->get();
        foreach($produtos as $produto){
                Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
        }
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoria deletada com sucesso!');
    }
}
