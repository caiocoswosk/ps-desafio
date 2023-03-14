@if (Session::has('success'))
    <section id="alert-content" class="alert-success">
        <div id="alert">
            <span>{{ Session::get('success') }}</span>
        </div>
        <div>
            <button class="material-symbols-outlined">
                close
            </button>
        </div>
    </section>
@endif

@if (Session::has('error'))
    <section id="alert-content" class="alert-error">
        <div id="alert">
            <span>{{ Session::get('error') }}</span>
        </div>
        <div>
            <button class="material-symbols-outlined">
                close
            </button>
        </div>
    </section>
@endif