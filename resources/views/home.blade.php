<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Package Semver Checker - madewithlove</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
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

        <main>
            <div>
                <p>
                    <a target="_blank" href="https://getcomposer.org/doc/articles/versions.md#versions-and-constraints">Learn more about version constraints</a>
                </p>
            </div>

            <section>
                <form>
                    <input placeholder="Package" id="package" type="text" autofocus="">
                    <button type="submit">Search</button>
                    <input placeholder="Version (eg. ^1.5)" id="version" type="text">
                    <select name="stability" id="stability" ><optgroup label="Minimum stability"><option label="dev" value="string:dev" selected="selected">dev</option><option label="alpha" value="string:alpha">alpha</option><option label="beta" value="string:beta">beta</option><option label="RC" value="string:RC">RC</option><option label="stable" value="string:stable">stable</option></optgroup></select>
                </form>

                <p class="hide" ng-show="versions.length &amp;&amp; errors.versions">The package  does not exist</p>
                <p class="hide" ng-show="versions.length &amp;&amp; errors.matching">Invalid version constraint</p>
            </section>

            <section>
                <h1>Results for <a target="_blank" href="https://packagist.org/packages/">:</a></h1>
                <ul>
                    <li ng-repeat="version in versions">
                        <a target="_blank" href="https://github.com/madewithlove/htaccess-api-client/releases/tag/v1.5.0">v1.5.0</a>
                    </li>
                </ul>

                <h2>Satisfied?</h2>
                <pre>composer require :"@dev"</pre>
            </section>
        </main>

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

    </body>
</html>
