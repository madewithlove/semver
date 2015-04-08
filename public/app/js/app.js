var app = angular.module('semver', []);

app.controller('AppController', function ($scope, $http, $location) {

	$scope.package = $location.search().package || 'madewithlove/elasticsearcher';
	$scope.defaultVersion = '~1.2.3';
	$scope.version = $location.search().version || '^0.1.1';
	$scope.stability = 'stable';
	$scope.errors = {
		versions: false,
		matching: false,
	};

	$scope.versions = [];
	$scope.matchingVersions = [];

	/**
	 * Fetches all versions of the specified package
	 */
	$scope.fetchVersions = function () {
		$http.get('/packages/' + $scope.package, {
			params: {
				stability: $scope.stability
			}
		}).success(function (response) {
			$scope.versions = response.versions;
			$scope.version = $scope.defaultVersion = response.default_constraint;
			$scope.errors.versions = false;

			$scope.fetchMatchingVersions();
		}).error(function () {
			$scope.errors.versions = true;
		});
	};

	/**
	 * Fetches all versions matching a specified range
	 */
	$scope.fetchMatchingVersions = function () {
		if (!$scope.version) {
			return;
		}

		// Update URL
		$location.search({
			package: $scope.package,
			version: $scope.version,
		});

		$http.get('/packages/' + $scope.package + '/match', {
			params: {
				constraint: $scope.version
			}
		}).success(function (versions) {
			$scope.matchingVersions = versions;
			$scope.errors.matching = false;
		}).error(function () {
			$scope.errors.matching = true;
		});
	};

	/**
	 * Checks if a version is within the specified version range
	 *
	 * @param {string} version
	 *
	 * @returns {boolean}
	 */
	$scope.matches = function (version) {
		return $scope.matchingVersions.indexOf(version) !== -1;
	};

	/**
	 * Compute the link to a version
	 *
	 * @param {string} version
	 *
	 * @returns {string}
	 */
	$scope.linkToVersion = function(version) {
		// Link to a branch
		if (version.version.indexOf('dev') !== -1) {
			var branch = version.version.replace(/-?dev-?/, '');

			return version.source + '/tree/' + branch;
		}

		return version.source + '/releases/tag/' + version.version;
	};

});
