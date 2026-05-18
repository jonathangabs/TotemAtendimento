<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="E-mail">
    <input type="password" name="senha" placeholder="Senha">

    <button type="submit">Entrar</button>
</form>