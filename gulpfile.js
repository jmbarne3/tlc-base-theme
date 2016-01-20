var gulp = require('gulp'),
	addsrc = require('gulp-add-src'),
	sass = require('gulp-sass'),
	minifyCss = require('gulp-minify-css'),
	bless = require('gulp-bless'),
	notify = require('gulp-notify'),
	bower = require('gulp-bower'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	jshint = require('gulp-jshint'),
	jshintStylish = require('jshint-stylish'),
	scsslint = require('gulp-scss-lint'),
	vinylPaths = require('vinyl-paths'),
	del = require('del');
	
var config = {
	scssPath: './src/scss',
	cssPath: './res/css',
	jsPath: './src/js',
	jsMinPath: './res/js',
	fontPath: './res/fonts',
	imgPath: './src/img',
	imgOutPath: './res/img',
	bowerDir: './src/components'	
};

gulp.task('bower', function() {
	bower()
		.pipe(gulp.dest(config.bowerDir))
		.on('end', function() {
			// Copy bootstrap fonts
			gulp.src(config.bowerDir + '/bootstrap-sass-official/assets/fonts/*/*')
				.pipe(gulp.dest(config.fontPath));
				
			// Copy font-awesome fonts
			gulp.src(config.bowerDir + '/font-awesome/fonts/*')
				.pipe(gulp.dest(config.fontPath + '/font-awesome'));

			gulp.src(config.imgPath + '/*.*')
				.pipe(gulp.dest(config.imgOutPath));
		});
});

gulp.task('css', function() {
	gulp.src(config.scssPath + '/*.scss')
		.pipe(scsslint())
		.pipe(sass().on('error', sass.logError))
		.pipe(minifyCss({compatibility: 'ie8'}))
		.pipe(rename('style.min.css'))
		.pipe(bless())
		.pipe(gulp.dest(config.cssPath));

	gulp.src(config.scssPath + '/admin/*.scss')
		.pipe(scsslint())
		.pipe(sass().on('error', sass.logError))
		.pipe(addsrc(config.bowerDir + '/spectrum/spectrum.css'))
		.pipe(minifyCss({compatibility: 'ie8'}))
		.pipe(rename('admin.min.css'))
		.pipe(bless())
		.pipe(gulp.dest(config.cssPath));
});

gulp.task('js', function() {
	return gulp.src([config.jsPath + '/*.js', '!' + config.jsPath + '/*.min.js'])
		.pipe(jshint())
		.pipe(jshint.reporter('jshint-stylish'))
		.pipe(jshint.reporter('fail'))
		.on('end', function() {
			console.log("Working...");
			var minified = [
				config.bowerDir + '/fittext/fittext.js',
				config.bowerDir + '/bootstrap-sass-official/assets/javascripts/bootstrap.js',
				config.jsPath + '/fillsize.js',
				config.jsPath + '/script.js'
			];

			gulp.src(minified)
				.pipe(concat('script.min.js'))
				.pipe(uglify())
				.pipe(gulp.dest(config.jsMinPath));

			var adminMinified = [
				config.jsPath + '/admin.js'
			];

			gulp.src(adminMinified)
				.pipe(concat('admin.min.js'))
				.pipe(uglify())
				.pipe(gulp.dest(config.jsMinPath));
		});
});

gulp.task('watch', function() {
	gulp.watch([config.scssPath + '/*.scss', config.scssPath + '/admin/*.scss'], ['css']);
	gulp.watch(config.jsPath + '/*.js', ['js']);
});

gulp.task('default', ['bower', 'css', 'js']);