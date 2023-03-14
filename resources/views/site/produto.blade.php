@extends('layouts.site.site')

@section('title')
    {{ $produto->nome }} | Retro's
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('site/css/produto.css') }}">
@endsection

@section('js')
    <script src="{{ asset('site/js/money-formatter.js') }}"></script>
    <script src="{{ asset('site/js/produto.js') }}"></script>
@endsection

@section('content')
    <section id="product-container" class="color1bg">
        <div id="img-container">
            <div id="product-img">
                <img src="{{ $produto->imagem }}" alt="">
            </div>
        </div>
        <div id="info-container">
            <div>
                <div id="product-category">
                    <span class="color6">{{ $produto->categoria->categoria }}</span>
                </div>
                <div id="product-name">
                    <h1 class="color5">{{ $produto->nome }}</h1>
                </div>
                <div id="product-price">
                    <span class="product-price">{{ $produto->preco }}</span>
                </div>
            </div>
            <div>
                @if ($produto->quantidade > 0)
                    @if ($produto->quantidade == 1)
                        <div id="product-qtt">
                            <span class="color6">{{ $produto->quantidade }} unidade disponível.</span>
                        </div>
                    @else
                        <div id="product-qtt">
                            <span class="color6">{{ $produto->quantidade }} unidades disponíveis.</span>
                        </div>
                    @endif
                    <form action="{{ route('siteBuy') }}" method="post">
                        @csrf
                        <button id="buy-btn" class="btn" type="submit">
                            <span class="material-symbols-outlined">
                                shopping_bag
                            </span>
                            <span class="btn-text">Comprar</span>
                        </button>
                        <input type="text" name="id" value="{{ $produto->id }}" hidden>
                        <div id="quantity-buy">
                            <button type="button" id="quantity-less">
                                <span class="material-symbols-outlined color5">
                                    expand_more
                                </span>
                            </button>
                            <input type="number" name="quantity" value="1" min="1"
                                max="{{ $produto->quantidade }}" class="color5">
                            <button type="button" id="quantity-more">
                                <span class="material-symbols-outlined color5">
                                    expand_less
                                </span>
                            </button>

                        </div>
                    </form>
                @else
                    <button id="sold-off-btn" class="btn color3bg-dark">
                        <span class="material-symbols-outlined color4">
                            shopping_bag
                        </span>
                        <span class="btn-text color4">Esgotado</span>
                    </button>
                @endif


            </div>
        </div>
    </section>

    <section id="description-container" class="color1bg">
        <h2 class="color5">Descrição</h2>
        <p class="color6">
            {{ $produto->descricao }}
        </p>
    </section>
@endsection
