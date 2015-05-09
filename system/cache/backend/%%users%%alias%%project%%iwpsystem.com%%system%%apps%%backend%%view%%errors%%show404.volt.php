<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php echo $this->tag->getTitle(); ?>
        <?php echo $this->tag->stylesheetLink('css/backend/bootstrap.min.css'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
<div class="jumbotron">
    <h1>Страница не найдена</h1>
    <p>Вы попали на страницу, которой не существует.</p>
    <p><a href="<?php echo '/index.adm'; ?>" class="btn btn-primary">Главная</a></p>
</div>

    </body>
</html>