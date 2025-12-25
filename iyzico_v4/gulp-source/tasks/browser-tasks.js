import gulp from 'gulp';
import browserSync from 'browser-sync';
import shell from 'gulp-shell';

import { CONFIG_PATH } from '../utils/getConfig';

const phpVersion = '7.0.22';

export const createServerTask = () => {
  browserSync(
    {
      proxy: '127.0.0.1:8000',
      startPath: '/',
    },
    function(err, bs) {}
  );
};
const browserSyncReloadTask = () => {
  browserSync.reload();
};
const reloader = browserSync.reload;

export const watchTask = () => {
  gulp.watch('web/assets/stylus/**/*.styl', ['css']);
  gulp.watch('web/assets/styles/vendors/**/*.css', ['css']);
  gulp.watch('web/assets/scripts/**/*.js', ['own-scripts', 'bs-reload']);
  gulp.watch('web/assets/scripts/vendors/others/**/*.js', [
    'vendors-scripts',
    'bs-reload',
  ]);
  gulp.watch(CONFIG_PATH, ['css']);
  gulp.watch('web/**/*.html').on('change', reloader);
  gulp.watch('src/WebBundle/Resources/views/**/*.twig').on('change', reloader);
};

gulp.task('bs-reload', () => browserSyncReloadTask());
gulp.task('create-server', () => createServerTask());

gulp.task(
  'run-all',
  shell.task([
    `cd ../ms-iyzico && /Applications/MAMP/bin/php/php${phpVersion}/bin/php -S localhost:8082 router.php &`,
    `cd ../bo-iyzico && /Applications/MAMP/bin/php/php${phpVersion}/bin/php -S localhost:8081 &`,
    `/Applications/MAMP/bin/php/php${phpVersion}/bin/php bin/console server:run &`,
    'npm run gulp:watch',
  ])
);
gulp.task('kill-all', shell.task(['killall php']));
