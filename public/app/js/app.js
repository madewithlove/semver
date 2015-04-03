var app = angular.module('semver', []);

app.controller('AppController', function ($scope, $http) {
	$scope.package = 'rocketeers/rocketeer';
	$scope.version = '~2.1';

	$scope.versions = [];
	$scope.matchingVersions = [];

	$scope.fetchVersions = function () {
		$scope.versions = ['1.0.0', '2.0.0'];
	};

	$scope.fetchMatchingVersions = function () {
		$scope.matchingVersions = ['2.0.0'];
	};

	$scope.matches = function(version) {
		console.log(version, $scope.matchingVersions);

		return $scope.matchingVersions.indexOf(version) !== 1;
	};
});
