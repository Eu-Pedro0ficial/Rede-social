<h1>HomePage</h1>
<?php use app\classes\Fetch; ?>
<?php echo getFlash('posts'); ?>
<a href="/profile" target="_self">Perfil</a>

<form action="/posts" method="post" enctype="multipart/form-data">
    <input type="file" name="path" accept="image/gif, image/jpeg, image/png"> <br>
    <textarea name="content" cols="30" rows="10"></textarea> <br>

    <button type="submit">Enviar</button>
</form>
<div>
    <?php $all = Fetch::all('posts'); ?>
    <?php foreach($all as $key => $value): ?>
        <div>
            <img src="<?php echo $value->path ?>" alt="">
            <p><?php echo $value->content ?></p>
            <p><?php echo $value->dataTime ?></p>

            <a href="/posts/delete/<?php echo $value->id ?>">Delete</a>
            <a href="/posts/update/<?php echo $value->id ?>">Update</a>
        </div>
    <?php endforeach; ?>
</div>