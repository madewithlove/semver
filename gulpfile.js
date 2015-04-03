var gulp       = require('gulp'),
		annotate   = require('gulp-ng-annotate'),
		changed    = require('gulp-changed'),
		concat     = require('gulp-concat'),
		config     = require('./gulpconfig.json'),
		cssmin     = require('gulp-cssmin'),
		livereload = require('gulp-livereload'),
		plumber    = require('gulp-plumber'),
		prefix     = require('gulp-autoprefixer'),
		rename     = require('gulp-rename'),
		sass       = require('gulp-sass'),
		sourcemaps = require('gulp-sourcemaps'),
		uglify     = require('gulp-uglify');

// Configuration
//////////////////////////////////////////////////////////////////////

gulp.task('css', function () {
	return gulp.src(config.styles)
		.pipe(plumber())
		.pipe(changed(config.paths.compiled.css))
		.pipe(sass())
		.pipe(prefix())
		.pipe(sourcemaps.init())
			.pipe(concat('styles.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.css))
		.pipe(livereload());
});

gulp.task('js', function () {
	return gulp.src(config.scripts)
		.pipe(plumber())
		.pipe(changed(config.paths.compiled.js))
		.pipe(sourcemaps.init())
			.pipe(annotate())
			.pipe(concat('scripts.js'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.js))
		.pipe(livereload());
});

gulp.task('minify', function () {
	gulp.src(config.paths.compiled.css + '/styles.css')
		.pipe(plumber())
		.pipe(cssmin())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.css));

	gulp.src(config.paths.compiled.js + '/scripts.js')
		.pipe(plumber())
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.js));
});

// Tasks
//////////////////////////////////////////////////////////////////////

gulp.task('default', ['css', 'js']);

gulp.task('watch', function () {
	livereload.listen();

	gulp.watch(config.paths.original.css + '/**/*.scss', ['css']);
	gulp.watch(config.paths.original.js + '/**/*.js', ['js']);
	gulp.watch(config.paths.original.views + '/**/*.php', function () {
		livereload.reload('index.php');
	});
});
