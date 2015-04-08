<?php $this->layout('_layout/global') ?>

<?php $this->start('body') ?>
    <section class="search">
        <form ng-submit="fetchVersions()" ng-init="fetchVersions()">
            <input placeholder="Package" id="package" type="text" ng-model="package">
            <button type="submit" class="btn btn-default">Search</button>
            <input placeholder="Version (eg. {{ defaultVersion }})" id="version" type="text" ng-model="version" ng-change="fetchMatchingVersions()">
            <select name="stability" id="stability" ng-model="stability" class="form-control">
                <optgroup label="Minimum stability">
                    <option value="stable">stable</option>
                    <option value="RC">RC</option>
                    <option value="beta">beta</option>
                    <option value="alpha">alpha</option>
                    <option value="dev">dev</option>
                </optgroup>
            </select>
        </form>

        <p class="error" ng-show="versions.length && errors.versions">The package {{ package }} does not exist</p>
        <p class="error" ng-show="versions.length && errors.matching">Invalid version constraint</p>
    </section>

    <section class="versions">
        <h1>Results for <a target="_blank" href="https://packagist.org/packages/{{ package }}">{{ package }}:{{ version }}</a></h1>
        <ul class="versions list-unstyled">
            <li ng-repeat="version in versions" class="version" ng-class="{'version--matching': matches(version.version)}">
                <a target="_blank" href="{{ version.source }}/releases/tag/{{ version.version }}">{{ version.version }}</a>
            </li>
        </ul>

        <h2>Satisfied?</h2>
        <pre>composer require {{ package }}:{{ version }}</pre>
    </section>
<?php $this->stop() ?>
