<!doctype html>
<html lang="pt">
    <head>
        <?=$this->fetch('./layout/header.php', ["title" => "base"])?>
    </head>
    <body>
        <?= $this->fetch('layout/menu.php', ['year' => date('Y')]) ?>
        <?= $content ?>
        <?= $this->fetch('layout/footer.php', ['year' => date('Y')]) ?>
    </body>
</html>

