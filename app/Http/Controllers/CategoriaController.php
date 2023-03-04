<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use Illuminate\Http\Request;

use App\Models\Categoria;

class CategoriaController extends Controller
{

    private $categoria;

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function index()
    {
        $categorias = $this->categoria->all();
        return view('categoria.index', compact('categorias'));
    }


    public function create()
    {
        return view('categoria.crud');
    }


    public function store(CategoriaRequest $request)
    {
        $data = $request->all();
        $this->categoria->create($data);

        return redirect()->route('categoria.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show($id)
    {
        $categoria = $this->categoria->find($id);
        return response()->json($categoria);
    }

    public function edit($id)
    {
        $categoria = $this->categoria->find($id);
        return view('categoria.crud', compact('categoria'));
    }

    public function update(CategoriaRequest $request, $id)
    {
        $data = $request->all();
        $categoria = $this->categoria->find($id);
        $categoria->update($data);

        return redirect()->route('categoria.index')->with('success', 'Categoria alterada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoria deletada com sucesso!');
    }
}
