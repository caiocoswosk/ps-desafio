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
        if (!empty($data['categoria'])) {
            $this->categorias->create($data);

            return redirect()->route('categoria.index')->with('success', 'Categoria criada com sucesso!');
        } else {
            return redirect()->route('categoria.create')->with('danger', 'Categoria inválida!');
        }
    }

    public function show($id)
    {
        $categoria = $this->categorias->find($id);
        return response()->json($categoria);
    }

    public function edit($id)
    {
        $categoria = $this->categorias->find($id);
        if (!empty($categoria)) {
            return view('categoria.crud', compact('categoria'));
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }

    public function update(CategoriaRequest $request, $id)
    {
        $data = $request->all();
        $categoria = $this->categorias->find($id);
        if (!empty($categoria)) {
            $categoria->update($data);

            return redirect()->route('categoria.index')->with('success', 'Categoria alterada com sucesso!');
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }

    public function destroy($id)
    {
        $categoria = $this->categorias->find($id);
        if (!empty($categoria)) {
            $produtos = $this->produtos->where('categoria_id', $id)->whereNotNull('imagem')->get();
            foreach ($produtos as $produto) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
            }
            $categoria->delete();

            return redirect()->route('categoria.index')->with('success', 'Categoria deletada com sucesso!');
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }
}
