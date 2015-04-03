<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>semver checker - madewithlove</title>
    <meta name="description" content="Semver version constraint checker for packagist.">
    <link rel="stylesheet" href="/builds/css/styles.css" />
</head>
<body ng-app="semver" ng-controller="AppController">
    <main class="container">
        <?php $this->insert('_partials/header') ?>
        <?= $this->section('body') ?>
    </main>

    <script src="/builds/js/scripts.js"></script>
</body>
</html>
<?php
