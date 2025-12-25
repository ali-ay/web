// Requires
import gulp from 'gulp';
import runSequence from 'run-sequence';

import cssTask from './gulp-source/tasks/css-tasks';
import javascriptTask from './gulp-source/tasks/js-tasks';
import { watchTask } from './gulp-source/tasks/browser-tasks';

gulp.task('css', cb => cssTask(cb));
gulp.task('js', cb => javascriptTask(cb));
gulp.task('watch', ['create-server'], cb => watchTask(cb));

gulp.task('run', function(cb) {
  runSequence('css', 'js', 'watch', cb);
});
