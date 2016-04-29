var config = require('madewithlove-webpack-config');

module.exports = config.default({
    angular: true,
    sourcePath: 'public/app/js',
    filenames: '[name]',
});
