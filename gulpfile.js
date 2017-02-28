var buildDir = 'dash-prod';

//GENERAL MODULES
var gulp = require('gulp'),
    concat = require('gulp-concat'),
    replace = require('gulp-replace'),
    plumber = require('gulp-plumber');
//CSS PROCESSING
var sass = require('gulp-sass');
var babel = require('gulp-babel');

var del = require('del'); // rm -rf
//

function clean() {
  // You can use multiple globbing patterns as you would with `gulp.src`
  // If you are using del 2.0 or above, return its promise
  return del(['../'+buildDir+'/**'], {force:true});
}
gulp.task('clean', function(){
  clean();
});

//Generic sass Processor
function sassProcessor(blob, dest) {
   gulp.src(blob)
    .pipe(plumber())
    .pipe(sass())
    .pipe(gulp.dest(dest));
}
//Generic js Processor
function jsProcessor(blob, dest, newName) {
  return gulp.src(blob)
    .pipe(plumber())
    .pipe(babel({
        presets: [["es2015", { "modules": false }]]
    }))
    .pipe(replace('$(', 'jQuery('))
    .pipe(concat(newName))
    .pipe(gulp.dest(dest));
}
//Generic html Processor




//SASS CSS TASK
gulp.task('sass', function () {
  sassProcessor(['sass/main.scss', 'sass/expanded.scss','sass/ie-fixes.scss','sass/editor-styles.scss'], '../'+buildDir+'/css');
});

//JS TASK
gulp.task('js', function () {
  jsProcessor([ 'js/plugins/*.js', 'js/site.js', 'js/modules/*.js'], '../'+buildDir+'/js', 'main.js');
  jsProcessor('todo/scripts/*.js','../'+buildDir+'/todo','main.js');
});



//HTML TASK
gulp.task('templatecrush', function() {
  dumper(['*.php','*.html','!custom-module-functions.php'], '../'+buildDir);
  dumper(['todo/*.php','todo/*.html','!custom-module-functions.php'], '../'+buildDir+'/todo');
});






//DUMPS
function dumper(src, dest) {
  return gulp.src(src)
    .pipe(gulp.dest(dest));
}
gulp.task('fontdump', function(){
  dumper('assets/fonts/**/*', '../'+buildDir+'/assets/fonts');
});

gulp.task('wpdump', function(){
  dumper(['style.css', 'screenshot.png'], '../'+buildDir);
});

gulp.task('watch', function() {
    gulp.watch(['js/**/*.js', 'todo/scripts/*.js'], ['js']);
    gulp.watch(['sass/**/*'], ['sass']);
    gulp.watch('assets/fonts/**/*', ['fontdump']);
    gulp.watch(['**/*.php', '**/*.html'], ['templatecrush']);
    gulp.watch(['style.css', 'screenshot.png'], ['wpdump']);

});

gulp.task('build', ['wpdump','templatecrush','fontdump','js','sass']);
