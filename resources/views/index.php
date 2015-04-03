<?php $this->layout('_layout/global') ?>

<?php $this->start('body') ?>
    <section class="search">
        <form ng-submit="fetchVersions()" ng-init="fetchVersions()">
            <input placeholder="Package" id="package" type="text" ng-model="package">
            <input placeholder="Version" id="version" type="text" ng-model="version" ng-change="fetchMatchingVersions()">
            <button type="submit" class="btn btn-default">Fetch</button>
        </form>

        <p class="error" ng-show="!exists">The package {{ package }} does not exist</p>
    </section>

    <section class="versions">
        <h1>Results for <span>{{ package }}:{{ version }}</span></h1>
        <ul class="versions list-unstyled">
            <li ng-repeat="version in versions" class="version" ng-class="{'version--matching': matches(version)}">{{ version }}</li>
        </ul>
    </section>
<?php $this->stop() ?>
