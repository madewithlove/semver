<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Package Semver Checker - madewithlove</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        @livewireStyles
    </head>
    <body>
        <header>
            <div>
                <a href="https://madewithlove.com?ref=semver" title="go to the madewitlove website">
                    <img src="img/logo-new.svg" alt="the madewithlove logo">
                </a>

                <h1>Packagist Semver Checker</h1>
            </div>
        </header>

        <livewire:semver-checker />

        <footer class="footer">
            <div class="container">
                <div class="footer__copyright">
                    <p>© 2021 <strong>made</strong>with<strong>love</strong></p>
                    <a href="https://madewithlove.be/disclaimer/?ref=semver">terms of service</a>
                    <a target="_blank" href="https://github.com/madewithlove/semver">source</a>
                    <a target="_blank" href="https://app.changehub.io/share/p-oXqP9gaQg1">changelog</a>
                    <a target="_blank" href="https://github.com/madewithlove/semver/graphs/contributors">creators</a>
                    <a target="_blank" href="https://madewithlove.com/company/playground/?ref=semver">This is a madewithlove project</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
