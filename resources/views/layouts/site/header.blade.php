<header class="color1bg">
  <!-- Logo -->
  <div id="header-logo">
    <a href="{{ route("siteIndex") }}">
      <img src="{{ asset("site/img/logo.png") }}" alt="Logo Retro's">
    </a>
  </div>

  <!-- Search bar -->
  <form action="{{ route('siteSearch') }}" method="get" id="form-search">
    <div id="search-bar" class="color3bg">
      <input name="query" type="text" placeholder="Busque produtos e muito mais..." class="color4 color5">
      <button type="submit">
        <span id="search-icon" class="material-symbols-outlined color4">
          search
        </span>
      </button>
    </div>
  </form>

  <!-- Login and theme toogle  -->
  <div id="login-theme">
    @auth
      <a href="{{ route("dashboard") }}" id="login">
        <span class="color5">Dashboard</span>
        <span id="login-icon" class="material-symbols-outlined color5">
          space_dashboard
        </span>
      </a>
    @endauth

    @guest
      <a href="{{ route("log.index") }}" id="login">
        <span class="color5">Login</span>
        <span id="login-icon" class="material-symbols-outlined color5">
          login
        </span>
      </a>
    @endguest
    <button id="theme-button">
      <input id="toggle-theme-url" type="text" value="{{ route('toggleTheme') }}" hidden>
      <span id="theme-icon" class="material-symbols-outlined color5">
        @if(session()->has('theme'))
          {{ session()->get('theme') }}
        @else
            dark_mode
        @endif
      </span>
    </button>
  </div>
</header>