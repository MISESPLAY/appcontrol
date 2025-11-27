<x-head-componentes />

<body>
<main>
    <h1>Iniciar sesión</h1>

    <!--
      Formulario en puro HTML.
      Acción apuntada a /login/auth (según tus rutas).
      Cuando lo integres en Laravel añade un campo _token para CSRF:
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    -->
    <form action="/login/auth" method="post" autocomplete="on" novalidate>
        <!-- Email -->
        <div>
            <label for="email">Correo electrónico</label><br>
            <input
                id="email"
                name="email"
                type="email"
                placeholder="tucorreo@ejemplo.com"
                required
                autofocus
            >
        </div>

        <!-- Password -->
        <div>
            <label for="password">Contraseña</label><br>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Tu contraseña"
                required
                minlength="6"
            >
        </div>

        <!-- Remember -->
        <div>
            <input id="remember" name="remember" type="checkbox" value="1">
            <label for="remember">Recordarme</label>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit">Entrar</button>
        </div>

        <!-- Enlaces opcionales -->
        <p>
            <a href="/password/reset">¿Olvidaste tu contraseña?</a>
        </p>
        <p>
            <a href="/register">Crear cuenta</a>
        </p>
    </form>
</main>
</body>
</html>
