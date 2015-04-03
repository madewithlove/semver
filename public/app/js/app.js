var app = angular.module('semver', []);

app.controller('AppController', function ($scope, $http, $location) {

	$scope.package = $location.search().package || 'madewithlove/elasticsearcher';
	$scope.version = $location.search().version || '^0.1.1';
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
		$http.get('/packages/' + $scope.package).success(function (versions) {
			$scope.versions = versions;
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

		$http.post('/packages/' + $scope.package + '/match', {
			constraint: $scope.version
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

});
