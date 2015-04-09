angular.module('semver').controller('AppController', function ($scope, $http, $location) {

	var query = $location.search();

	$scope.package = query.package || 'madewithlove/elasticsearcher';
	$scope.previousPackage = $scope.package;
	$scope.defaultVersion = '~1.2.3';
	$scope.version = query.version || '^0.1.1';
	$scope.stability = query['minimum-stability'] || 'stable';
	$scope.stabilities = ['dev', 'alpha', 'beta', 'RC', 'stable'];

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
		$http.get('/packages/' + $scope.package).success(function (response) {
			$scope.versions = response.versions;
			$scope.defaultVersion = response.default_constraint;

			if (!$scope.version || $scope.previousPackage !== $scope.package) {
				$scope.version = response.default_constraint;
			}

			$scope.previousPackage = $scope.package;
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
			"minimum-stability": $scope.stability,
		});

		$http.get('/packages/' + $scope.package + '/match', {
			params: {
				constraint: $scope.version,
				"minimum-stability": $scope.stability,
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

});
