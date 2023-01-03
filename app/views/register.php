<h1>Cadastre-se</h1>
<?php $values = getValues('register')?>

<form action="/register" method="post">
    <div>
        <?php echo getFlash('error') ?> 
    </div>

    <label for="">Nome</label>
    <input type="text" value="<?php echo $values->name ?>" name="name">
    <?php echo getFlash('name') ?> <br>

    <label for="">Sobrenome</label>
    <input type="text" value="<?php echo $values->lastname ?>" name="lastname">
    <?php echo getFlash('lastname') ?> <br>

    <label for="">Email</label>
    <input type="text" value="<?php echo $values->email ?>" name="email">
    <?php echo getFlash('email') ?> <br>

    <label for="">Celular</label>
    <input type="number" value="<?php echo $values->phone ?>" name="phone">
    <?php echo getFlash('phone') ?> <br>

    <label for="">Data de nascimento</label>
    <input type="date" value="<?php echo $values->birthDate ?>" name="birthDate">
    <?php echo getFlash('birthDate') ?> <br>

    <label for="">Password</label>
    <input type="password" value="<?php echo $values->password ?>" name="password">
    <?php echo getFlash('password') ?> <br>

    <button type="submit">Cadastrar</button>
</form>