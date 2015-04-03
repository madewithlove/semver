<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Packagist Semver Checker - madewithlove</title>
    <meta name="description" content="Semver version constraint checker for packagist.">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/builds/css/styles.css" />
</head>
<body ng-app="semver" ng-controller="AppController">
    <main class="container" ng-cloak>
        <?php $this->insert('_partials/header') ?>
        <?= $this->section('body') ?>
    </main>

    <?php $this->insert('_partials/footer') ?>
    <?php $this->insert('_partials/ga') ?>

    <script src="/builds/js/scripts.js"></script>
</body>
</html>
<?php
