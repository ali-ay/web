import gulp from 'gulp';
import cleanCSS from 'gulp-clean-css';
import clean from 'gulp-clean';
import rename from 'gulp-rename';
import spritesmith from 'gulp.spritesmith';
import stylus from 'gulp-stylus';
import runSequence from 'run-sequence';
import merge from 'merge-stream';
import nib from 'nib';

import { DIRECTORIES } from '../config';
import getConfig from '../utils/getConfig';
import getFolders from '../utils/getFolders';

const stylesFolder = `${DIRECTORIES.source}/${DIRECTORIES.styles}`;
const stylusFolder = `${DIRECTORIES.source}/${DIRECTORIES.styl}`;
const imagesFolder = `${DIRECTORIES.source}/${DIRECTORIES.img}`;
const spriteFolder = `${DIRECTORIES.source}/${DIRECTORIES.img}/${DIRECTORIES.sprite}`;

const minifyCssTask = () =>
  gulp
    .src(`${stylesFolder}/main.css`)
    .pipe(cleanCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(stylesFolder));

const stylusMainTask = () =>
  gulp
    .src(`${stylusFolder}/main.styl`)
    .pipe(
      stylus({
        'include css': true,
        compress: false,
        linenos: false,
        use: [nib()],
      })
    )
    .pipe(gulp.dest(stylesFolder));

const cleanSpriteTask = () => gulp.src(`${imagesFolder}/sprite-*.png`).pipe(clean());

const createSpriteTask = () => {
  const { version } = getConfig().framework.assets;
  const folders = getFolders(spriteFolder);
  const tasks = folders.map(folder => {
    const spriteObj = {
      retinaSrcFilter: `sprite/${folder}/*@2x.png`,
      imgName: `sprite-${folder}-${version}.png`,
      retinaImgName: `sprite-${folder}-${version}@2x.png`,
      cssName: `${folder}.styl`,
      imgPath: `../${DIRECTORIES.img}/sprite-${folder}-${version}.png`,
      retinaImgPath: `../${DIRECTORIES.img}/sprite-${folder}-${version}@2x.png`,
      padding: 4,
    };
    const spriteData = gulp
      .src(`sprite/${folder}/*.png`, { cwd: imagesFolder })
      .pipe(spritesmith(spriteObj));
    spriteData.img.pipe(gulp.dest(imagesFolder));
    spriteData.css.pipe(gulp.dest(`${stylusFolder}/${DIRECTORIES.sprite}`));
    return spriteData;
  });
  return merge(tasks);
};

gulp.task('minify-css', () => minifyCssTask());
gulp.task('stylus-main', () => stylusMainTask());
gulp.task('clean-sprite', () => cleanSpriteTask());
gulp.task('create-sprite', () => createSpriteTask());

const cssTask = callback => {
  runSequence(
    'clean-sprite',
    'create-sprite',
    'stylus-main',
    'minify-css',
    'bs-reload',
    callback
  );
};

export default cssTask;
