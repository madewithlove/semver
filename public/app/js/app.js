var app = angular.module('semver', []);

app.controller('AppController', function ($scope, $http) {

	$scope.package = 'madewithlove/elasticsearcher';
	$scope.version = '^0.1.1';
	$scope.exists = false;

	$scope.versions = [];
	$scope.matchingVersions = [];

	/**
	 * Fetches all versions of the specified package
	 */
	$scope.fetchVersions = function () {
		$http.get('/packages/' + $scope.package).success(function (versions) {
			$scope.versions = versions;
			$scope.exists = true;

			$scope.fetchMatchingVersions();
		}).error(function () {
			$scope.exists = false;
		});
	};

	/**
	 * Fetches all versions matching a specified range
	 */
	$scope.fetchMatchingVersions = function () {
		if (!$scope.version) {
			return;
		}

		$http.post('/packages/' + $scope.package + '/match', {
			constraint: $scope.version
		}).success(function (versions) {
			$scope.matchingVersions = versions;
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
