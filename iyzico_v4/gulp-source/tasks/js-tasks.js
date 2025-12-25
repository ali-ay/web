import gulp from 'gulp';
import concat from 'gulp-concat';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';

import runSequence from 'run-sequence';

const ownScriptsTask = () =>
  gulp
    .src('web/assets/scripts/site/*.js')
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(rename('main.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('web/assets/scripts'));

const vendorScriptsTask = () =>
  gulp
    .src('web/assets/scripts/vendors/*.js')
    .pipe(sourcemaps.init())
    .pipe(concat('vendors.js'))
    .pipe(rename('vendors.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('web/assets/scripts'));

gulp.task('own-scripts', () => ownScriptsTask());
gulp.task('vendor-scripts', () => vendorScriptsTask());

const javascriptTask = callback => {
  runSequence('own-scripts', 'vendor-scripts', callback);
};

export default javascriptTask;
