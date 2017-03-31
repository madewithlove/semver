<?php $this->layout('_layout/global') ?>

<section class="search">
    <form ng-submit="fetchVersions()" ng-init="fetchVersions()">
        <input select-on-click placeholder="Package" id="package" type="text" ng-model="package">
        <button type="submit" class="btn btn-default">Search</button>
        <input select-on-click placeholder="Version (eg. {{ defaultVersion }})" id="version" type="text" ng-model="version" ng-change="fetchMatchingVersions()">
        <select name="stability" id="stability" class="form-control"
                ng-model="stability" ng-options="item group by 'Minimum stability' for item in stabilities"
                ng-change="fetchMatchingVersions()">
        </select>
    </form>

    <p class="error" ng-show="versions.length && errors.versions">The package {{ package }} does not exist</p>
    <p class="error" ng-show="versions.length && errors.matching">Invalid version constraint</p>
</section>

<section class="versions">
    <h1>Results for <a target="_blank" href="https://packagist.org/packages/{{ package }}">{{ package }}:{{ version }}</a></h1>
    <ul class="versions list-unstyled">
        <li ng-repeat="version in versions" class="version" ng-class="{'version--matching': matches(version.version)}">
            <a target="_blank" href="{{ linkToVersion(version) }}">{{ version.version }}</a>
        </li>
    </ul>

    <h2>Satisfied?</h2>
    <pre>composer require {{ package }}:"{{ version }}{{ version_suffix }}"</pre>
</section>
