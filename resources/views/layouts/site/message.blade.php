@if (Session::has('success'))
    <section id="message-content" class="message-success">
        <div id="message">
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
    <section id="message-content" class="message-error">
        <div id="message">
            <span>{{ Session::get('error') }}</span>
        </div>
        <div>
            <button class="material-symbols-outlined">
                close
            </button>
        </div>
    </section>
@endif