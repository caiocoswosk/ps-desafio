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
        // busca por todas as categorias
        $data = $request->all();
        // verifica se a requisição enviou o nome da categoria
        if (!empty($data['categoria'])) {
            // registra a categoria no banco de dados
            $this->categorias->create($data);

            return redirect()->route('categoria.index')->with('success', 'Categoria criada com sucesso!');
        } else {
            return redirect()->route('categoria.create')->with('danger', 'Categoria inválida!');
        }
    }

    public function show($id)
    {
        // busca a categoria pelo id
        $categoria = $this->categorias->find($id);
        return response()->json($categoria);
    }

    public function edit($id)
    {
        // busca a categoria pelo id
        $categoria = $this->categorias->find($id);
        // verifica se a categoria existe
        if (!empty($categoria)) {
            return view('categoria.crud', compact('categoria'));
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }

    public function update(CategoriaRequest $request, $id)
    {
        $data = $request->all();
        // busca a categoria pelo id
        $categoria = $this->categorias->find($id);
        // verifica se a categoria existe
        if (!empty($categoria)) {
            // atualiza o registro da categoria no banco de dados
            $categoria->update($data);

            return redirect()->route('categoria.index')->with('success', 'Categoria alterada com sucesso!');
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }

    public function destroy($id)
    {
        // busca a categoria pelo id
        $categoria = $this->categorias->find($id);
        // verifica se a categoria existe
        if (!empty($categoria)) {
            // busca por todos os produtos dessa categoria que possuem uma imagem
            $produtos = $this->produtos->where('categoria_id', $id)->whereNotNull('imagem')->get();
            // percorre por todos os produtos e exclui sua respectiva imagem
            foreach ($produtos as $produto) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
            }
            // apaga o registro da categoria no banco de dados
            $categoria->delete();

            return redirect()->route('categoria.index')->with('success', 'Categoria deletada com sucesso!');
        } else {
            return redirect()->route('categoria.index')->with('danger', 'Categoria não encontrada!');
        }
    }
}
