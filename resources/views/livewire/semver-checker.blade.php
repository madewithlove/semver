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
