<?php $this->layout('_layout/global') ?>

<?php $this->start('body') ?>
    <form class="form-inline" ng-submit="fetchVersions()">
        <div class="form-group">
            <input class="form-control" placeholder="Package" id="package" type="text" ng-model="package">
            <button type="submit" class="btn btn-default">Fetch</button>
        </div>
    </form>

    <form class="form-inline">
        <div class="form-group">
            <input class="form-control" placeholder="Version" id="version" type="text" ng-model="version" ng-change="fetchMatchingVersions()">
        </div>
    </form>

    <ul>
        <li ng-repeat="version in versions" ng-class="{success: matches(version)}">{{ version }}</li>
    </ul>
<?php $this->stop() ?>
