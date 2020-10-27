<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="http://semver.mwl.be">
    <title>Packagist Semver Checker - madewithlove</title>
    <meta name="description" content="Semver version constraint checker for packagist.">
    <link href='//fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/builds/main.css" />
    <!-- favicons -->
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"/>
</head>
<body ng-app="semver" ng-controller="AppController">
    <header class="header">
        <div class="container">
            <a href="https://madewithlove.com?ref=semver" title="go to the madewitlove website" class="logo">
                <img src="img/logo-new.svg" alt="the madewithlove logo" />
            </a>

            <h1>Packagist Semver Checker</h1>
        </div>
    </header>
    <main class="container" ng-cloak>
        <?php $this->insert('_partials/header') ?>
        <?= $this->section('content') ?>
    </main>

    <?php $this->insert('_partials/footer') ?>
    <?php $this->insert('_partials/ga') ?>

    <script src="/builds/main.js"></script>
</body>
</html>
