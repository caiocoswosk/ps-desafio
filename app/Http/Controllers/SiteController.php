<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProdutoController;
use App\Http\Requests\SiteRequest;

class SiteController extends Controller
{
    public function index()
    {
        // Busca todos os produtos e ordena pelos
        // produtos que não estão esgotados
        $produtos = Produto::select()->orderBy(DB::raw('quantidade = 0'))->get();
        $categorias = Categoria::all();

        return view('site.index', compact('produtos', 'categorias'));
    }

    public function search(SiteRequest $request)
    {
        $query = $request['query'];
        // Busca o produto no banco de dados de acordo com a query de pesquisa
        // e ordena pelos produtos que não estão esgotados
        $produtos = Produto::where('nome', 'LIKE', "%{$query}%")->orderBy(DB::raw('quantidade = 0'))->get();
        // Busca apenas pelas categorias que possue algum
        // produto que vai ser exibido
        $categorias = DB::table('categorias')->leftJoin('produtos', 'categorias.id', '=', 'produtos.categoria_id')->select('categorias.*')->where('produtos.nome', 'LIKE', "%{$query}%")->whereNotNull('produtos.id')->distinct()->get();

        return view('site.search', compact('produtos', 'categorias', 'query'));
    }

    public function produto(SiteRequest $request)
    {
        $id = $request['id'];
        $produto = Produto::find($id);

        // verifica se o produto existe
        if ($produto) {
            // popula as informações de categoria
            $produto->with('categoria');
            return view('site.produto', compact('produto'));
        } else {
            return redirect()->route('siteIndex')->with('error', 'Produto não encontrado!');
        }
    }

    public function buy(SiteRequest $request)
    {
        $id = $request['id'];
        $qtt = $request['quantity'];

        // busca o produto pelo id
        $produto = Produto::find($id);

        // verifica se o produto não existe
        if (!$produto) {
            return redirect()->back()->with('error', 'Produto não encontrado!');
        }
        // verifica se a quantidade da compra esta adequada
        else if (($produto->quantidade >= $qtt) and ($qtt >= 1)) {
            // subtrai a quantidade do produto pela quantidade comprada
            $produto->quantidade -= $qtt;
            // atualiza o registro do produto no banco de dados
            $produto->save();
            return redirect()->back()->with('success', 'Compra realizada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'A quantidade desejada não esta disponível!');
        }
    }
}
