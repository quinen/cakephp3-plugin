<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?php

    echo $this->element('Quinen.Layout/meta_css');
    echo $this->element('Quinen.Layout/meta_js');

    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <?= $this->element('Quinen.Layout/header')?>
        <?= $this->Flash->render() ?>
    </header>
    <div class="container-fluid clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <?= $this->element('Quinen.Layout/footer')?>
    </footer>
</body>
</html>
