/*----------  Récupération des modules  ----------*/

// Set true if you're in production
const inProduction = true;

// Put your script library name here
var libJS = ['turbolinks','jquery', 'jquery-ui', 'croppie', 'html2canvas', 'jquery-minicolors', 'medium-editor'];
var scriptBuilder = ['edit_img', 'edit_text', 'control_sections', 'control_menus', 'actions_build'];

var libCSS = ['jquery-ui', 'croppie', 'medium-editor', 'jquery-minicolors'];

const gulp = require('gulp'),
	compass = require('gulp-compass'),
	autoprefixer = require('gulp-autoprefixer'),
	rename = require('gulp-rename'),
	cleanCSS = require('gulp-clean-css'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	babel = require('gulp-babel'),
	concat = require('gulp-concat'),
	print = require('gulp-print'),
	runSequence = require('run-sequence'),
	imagemin = require('gulp-imagemin');

/*----------  Styles  ----------*/

// // Compass task
gulp.task('myCSS', function() {
	return gulp.src(['webroot/scss/back/*.scss'])
		.pipe(compass({
		 	css: 'webroot/css/back',
			sass: 'webroot/scss/back',
			config_file: './config.rb',
		}))
		.on('error', function(error) {
	      console.log(error);
	      this.emit('end');
	    })
	    .pipe(print(function(filepath) {
	      return "file created : " + filepath;
	    }))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 7', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    	.pipe(gulp.dest('webroot/css/back'))
    	.pipe(rename({ suffix: '.min' }))
    	.pipe(cleanCSS({compatibility: 'ie8'}))
    	.pipe(gulp.dest('webroot/css/back'))
    	.pipe(print(function(filepath) {
	      return "file created : " + filepath;
	    }))
});

gulp.task('concatCSS', function() {
	var css = [];
	for (var i = 0; i < libCSS.length; i++) {
		css.push('lib/css/'+libCSS[i]+'/*.css');
	}

	css.push('webroot/css/back/app.min.css');
	css.push('webroot/css/back/builder.min.css');
  	
  	gulp.src(css)
	.pipe(concat('styles.min.css'))
	.pipe(gulp.dest('webroot/css/back/min'));
});

gulp.task('styles', function() {
	runSequence('myCSS', 'concatCSS');
});

/*----------  Images  ----------*/	

// // Compressed task
// gulp.task('image', function() {
// 	return gulp.src(['public/assets/img/*'])
// 		.pipe(imagemin())
// 		.pipe(gulp.dest('public/assets/imgComp'));
// });

/*----------  Scripts  ----------*/

if (!inProduction) {
	// script de nettoyage et de compression
}

else {
	gulp.task('myJs', function() {
		return gulp.src('webroot/js/*.js')
			.pipe(sourcemaps.init())
			.pipe(rename({ suffix: '.min' }))
			.pipe(gulp.dest('webroot/js/min'))

			.pipe(print(function(filepath) {
		      return "file created : " + filepath;
		    }))
	});
}

var scripts = [];
for (var i = 0; i < libJS.length; i++) {
	scripts.push('lib/js/'+libJS[i]+'/*.js');
}

scripts.push('webroot/js/script.js');

gulp.task('concatGeneral', function() {
  gulp.src(scripts)
    .pipe(concat('script.min.js'))
    .pipe(gulp.dest('webroot/js/min'));
});

gulp.task('scripts', function() {
	runSequence('myJs','concatGeneral');
});

var builder = [];
for (var i = 0; i < scriptBuilder.length; i++) {
	builder.push('webroot/js/builder/'+scriptBuilder[i]+'.js');
}

gulp.task('concatBuilder', function() {
  gulp.src(builder)
    .pipe(concat('builder.js'))
    .pipe(gulp.dest('webroot/js/'));
});

gulp.task('builder', function() {
	runSequence('concatBuilder');
});


gulp.task('default', ['scripts', 'builder','styles', 'watch']);

/*----------  Live  ----------*/

// Watch task
gulp.task('watch', function() {
	gulp.watch('./webroot/scss/back/*.scss', ['styles']);
	gulp.watch('./webroot/js/*.js', ['scripts']);
	gulp.watch('./webroot/js/builder/*.js', ['builder']);
});