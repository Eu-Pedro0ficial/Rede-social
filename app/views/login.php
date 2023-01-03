<h1>Login</h1>

<form action="/login" method="post">
    <div>
        <?php echo getFlash('login'); ?>
    </div>

    <label for="">Email</label>
    <input type="text" name="email">

    <label for="">Senha</label>
    <input type="password" name="password">

    <button type="submit">Login</button>
</form>
<a href="/register" target="_self">Cadastre-se</a>