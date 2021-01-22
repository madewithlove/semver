<main>
    <div>
        <p>
            <a target="_blank" href="https://getcomposer.org/doc/articles/versions.md#versions-and-constraints">Learn more about version constraints</a>
        </p>
    </div>

    <section>
        <form>
            <input wire:model="packageName" placeholder="Package" id="package" type="text" autofocus="">
            <button type="submit">Search</button>
            <input wire:model="version" placeholder="Version (eg. ^1.5)" id="version" type="text">
            <select name="stability" id="stability" wire:model="stability">
                <option label="dev" value="dev">dev</option>
                <option label="alpha" value="alpha">alpha</option>
                <option label="beta" value="beta">beta</option>
                <option label="RC" value="RC">RC</option>
                <option label="stable" value="stable">stable</option>
            </select>
        </form>

        <p class="hide" ng-show="versions.length &amp;&amp; errors.versions">The package  does not exist</p>
        <p class="hide" ng-show="versions.length &amp;&amp; errors.matching">Invalid version constraint</p>
    </section>

    <section>
        <h1>Results for <a target="_blank" href="https://packagist.org/packages/">:</a></h1>
        <ul>
            @foreach ($package->getVersions() as $packageVersion)
                <li>
                    <a target="_blank" href="https://github.com/{{ $packageName }}/releases/tag/{{ $packageVersion->getVersion() }}">{{ $packageVersion->getVersion() }}</a>
                </li>
            @endforeach
        </ul>

        <h2>Satisfied?</h2>
        <pre>composer require {{ $packageName }}:"{{ $version }}{{ $this->stabilityFlag }}"</pre>
    </section>
</main>
