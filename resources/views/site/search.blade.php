@extends('layouts.site.site')

@section('title')
    Retro's
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset("site/css/index.css") }}">
@endsection

@section('js')
    <script src="{{ asset("site/js/index.js") }}"></script>
    <script src="site/js/money-formatter.js"></script>
@endsection

@section('content')
<section class="color3bg">
  <div id="search-text">
    <span class="color5"><h1>Resultados para "{{ $query }}"</h1></span>
  </div>
  <nav>
    <div class="scroll">
      <button id="scroll-left" class="btn-scroll color4">
        <span class="material-symbols-outlined">
          chevron_left
        </span>
      </button>
    </div>
    <ul id="menu">
      <li class="category">
        <input type="text" class="category-id" value="#" hidden>
        <button class="btn-category category-activate color4">Todos</button>
      </li>
      
      @isset($categorias)
        @foreach ($categorias as $categoria)
        <li class="category">
          <input type="text" class="category-id" value="{{ $categoria->id }}" hidden>
          <button class="btn-category color4">{{ $categoria->categoria }}</button>
        </li>
        @endforeach
      @endisset
    </ul>
    <div class="scroll">
      <button id="scroll-right" class="btn-scroll color4">
        <span class="material-symbols-outlined">
          chevron_right
        </span>
      </button>
    </div>
  </nav>
  <div id="products-container">
    <div id="none-product" class="hidden">
      <span class="color5">Nenhum produto disponível.</span>
    </div>

    @isset($produtos)
      @foreach ($produtos as $produto)
      <a href="#" class="product color1bg">
        <input type="text" class="category-id" value="{{ $produto["categoria_id"] }}" hidden>
        <div class="product-img">
          <img src="{{ $produto["imagem"] }}" alt="">
        </div>
        <div class="product-text">
          @if ($produto["quantidade"] > 0)
            <div class="product-price color5">
              {{ $produto["preco"] }}
            </div>
          @else
            <div class="sold-off color5">
              Esgotado
            </div>
          @endif
          <div class="product-name color6">
            {{ $produto["nome"] }}
          </div>
        </div>
      </a>
      @endforeach
    @endisset
  </div>
  <div id="select-page">
    <button id="previous-btn" class="btn-scroll color4">
      <span class="material-symbols-outlined">
        chevron_left
      </span>
    </button>
    <span class="color6"><span id="current-page">1</span> de <span id="last-page"></span></span>
    <button id="next-btn" class="btn-scroll color4">
      <span class="material-symbols-outlined">
        chevron_right
      </span>
    </button>
  </div>
</section>
@endsection