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
        <?php if ($exception['debug']) { ?>
            <p>Отладочная информация:</p>
            <p>
                Сообщение: <small><?php echo $exception['message']; ?></small><br/>
                Код: <small><?php echo $exception['code']; ?></small><br/>
                Файл: <small><?php echo $exception['file']; ?>:<?php echo $exception['line']; ?></small><br/>
                Трассировка: 
            <pre>
<?php echo $exception['trace']; ?>
            </pre>
        </p>
    <?php } else { ?>
        <h1>Внутрення ошибка</h1>
        <p>Что-то сломалось. Если ошибка повторится свяжитесь с нами.</p>
    <?php } ?>
    <p><a href="<?php echo '/index.adm'; ?>" class="btn btn-primary">Главная</a></p>
</div>

    </body>
</html>