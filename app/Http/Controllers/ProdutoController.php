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
        // busca todos os produtos
        $produtos = $this->produtos->all();
        return view('produto.index', compact('produtos'));
    }


    public function create()
    {
        // busca todas as categorias
        $categorias = $this->categorias->all();
        // verifica se possue categorias
        if (!empty($categorias)) {
            return view('produto.crud', compact('categorias'));
        } else {
            return redirect()->route('produto.index')->with('danger', 'Registre uma categoria primeiro!');
        }
    }


    public function store(ProdutoRequest $request)
    {
        $data = $request->all();

        // armazena a imagem no servidor
        $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
        // substitui a vírgula por ponto
        $data['preco'] = str_replace(',', '.', $data['preco']);

        // registra o produto
        $this->produtos->create($data);

        return redirect()->route('produto.index')->with('success', 'Produto criado com sucesso!');
    }


    public function show($id)
    {
        // busca o produto de acordo com o id
        $produto = $this->produtos->find(($id));
        //verifica se o produto existe
        if (!empty($produto)) {
            $produto->load('categoria');
        }
        return response()->json($produto);
    }


    public function edit($id)
    {
        // busca o produto de acordo com o id
        $produto = $this->produtos->find($id);
        // verifica se o produto existe
        if (!empty($produto)) {
            // busca todas as categorias
            $categorias = $this->categorias->all();
            return view('produto.crud', compact('produto', 'categorias'));
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }


    public function update(ProdutoRequest $request, $id)
    {
        $data = $request->all();
        // procura o produto pelo id
        $produto = $this->produtos->find($id);
        // verifica se o produto existe
        if (!empty($produto)) {
            // substitui a virgula pelo ponto no preço do produto
            $data['preco'] = str_replace(',', '.', $data['preco']);

            // verifica se a requisição enviou a imagem do produto
            if ($request->hasFile('imagem')) {
                // verifica se o produto ja registrado possui imagem
                if (!empty($produto->imagem)) {
                    // exclui a imagem
                    Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
                }
                // armazena a nova imagem no servidor
                $data['imagem'] = '/storage/' . $request->file('imagem')->store('produtos', 'public');
            }

            // atualiza as informações do produto no banco de dados
            $produto->update($data);
            return redirect()->route('produto.index')->with('success', 'Produto alterado com sucesso!');
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }

    public function destroy($id)
    {
        // busca o produto pelo id
        $produto = $this->produtos->find($id);
        // verifica se o produto existe
        if (!empty($produto)) {
            // verifica se o produto ja registrado possui imagem
            if (!empty($produto->imagem)) {
                // exclui a imagem
                Storage::disk('public')->delete(str_replace('/storage/', '', $produto->imagem));
            }
            // exclui o registro do produto no banco de dados
            $produto->delete();
            return redirect()->route('produto.index')->with('success', 'Produto apagado com sucesso!');
        } else {
            return redirect()->route('produto.index')->with('danger', 'Produto não encontrado!');
        }
    }
}
