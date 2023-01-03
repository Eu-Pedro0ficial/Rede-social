<h1>Perfil</h1>
<h2>Bem vindo <?php echo logged()->name ?>!</h2>
<a href="/logout" target="_self">Logout</a>
<?php echo getFlash('updateUser') ?> 
<?php echo getFlash('deleteUser') ?> 

<a href="/user/update">update</a>
<a href="/user/delete">delete</a>