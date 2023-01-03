<form action="/posts/updated" method="post" enctype="multipart/form-data">
    <input type="file" name="path" accept="image/gif, image/jpeg, image/png"> <br>
    <input type="hidden" name="id" value="<?php echo $_SESSION['POST']->id ?>">
    <textarea name="content" cols="30" rows="10"></textarea> <br>

    <button type="submit">Enviar</button>
</form>