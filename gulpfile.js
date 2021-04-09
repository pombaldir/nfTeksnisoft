var gulp = require('gulp'),
    concat = require('gulp-concat'),
	watch = require('gulp-watch');
	changed = require('gulp-changed');
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sass = require('gulp-ruby-sass'),
	sourcemaps = require('gulp-sourcemaps');
    autoprefixer = require('gulp-autoprefixer'),
	cssnano = require('gulp-cssnano');
	gulpIf = require('gulp-if');
	connect = require('gulp-connect-php'),
    browserSync = require('browser-sync').create();
	
	
	

var DEST = 'build/';
var DEVELFOLDER = '/Users/nelsonsantos/Sites/doc.organifacho.com/_whiteLabel/';
var ARRAYDEVFILES=[
        'footer.php',
        'header.php',
		'include/functions.php',
		'include/psl-config.php*',
		'*/*settings.*',
		'*settings.*',
		'*/*tabelas.*',
		'*tabelas.*',
		'*/*index.*',
		'*index.*',
		'*/*utilizadores.*',
		'*utilizadores.*',
		'*/*perfil.*',
		'*perfil.*',
		'login*',
		'recover.*',
		'reset.*',
      ];



gulp.task('scripts', function() {
    return gulp.src([
        'src/js/helpers/*.js',
        'src/js/*.js',
      ])
      .pipe(concat('custom.js'))
      .pipe(gulp.dest(DEST+'/js'))
      .pipe(rename({suffix: '.min'}))
      .pipe(uglify())
      .pipe(gulp.dest(DEST+'/js'))
      .pipe(browserSync.stream());
});

// TODO: Maybe we can simplify how sass compile the minify and unminify version
var compileSASS = function (filename, options) {
  return gulp.src('src/scss/*.scss', options)
  		.pipe(sourcemaps.init())
        .pipe(autoprefixer('last 2 versions', '> 5%'))
        .pipe(concat(filename))
		.pipe(sourcemaps.write())
        .pipe(gulp.dest(DEST+'/css'))
        .pipe(browserSync.stream());
};

gulp.task('sass', function() {
    return compileSASS('custom.css', {});
});

gulp.task('sass-minify', function() {
    return compileSASS('custom.min.css', {style: 'compressed'});
});
  
/*
gulp.task('browser-sync', function() {
    browserSync.init({
        server: {
            baseDir: './'
        },
        startPath: './'
    });
});
*/

gulp.task('connect-sync', function() {
  connect.server({}, function (){
    browserSync.init({
      proxy: 'dev.nf.teknisoft.pt:8888'
    });
  });
 
}); 

gulp.task('watch', function() {

  gulp.watch('*.php').on('change', function () {
    browserSync.reload();
  });
  
  gulp.watch('include/*.php').on('change', function () {
    browserSync.reload();
  });
  
  gulp.watch('data/*.php').on('change', function () {
    browserSync.reload();
  });
 
  gulp.watch('src/scss/*.scss', gulp.parallel('sass', 'sass-minify'));
  gulp.watch('src/js/*.js', gulp.parallel('scripts'));

});



gulp.task('watch-folder', function() {
	gulp.watch(ARRAYDEVFILES).on('change', function () {
	gulp.src(ARRAYDEVFILES, {base: "."})
		.pipe(changed(DEVELFOLDER))
		.pipe(gulp.dest(DEVELFOLDER));
});
});






// Default Task
var build = gulp.parallel('connect-sync','watch','watch-folder');
gulp.task(build);
gulp.task('default', build);
