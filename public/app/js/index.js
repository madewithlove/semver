import 'bootstrap-sass/assets/stylesheets/_bootstrap.scss';
import '../sass/styles.scss';
import angular from 'angular';

angular.module('semver', []);
require('./Controllers/AppController');
require('./Directives/SelectOnClick');
