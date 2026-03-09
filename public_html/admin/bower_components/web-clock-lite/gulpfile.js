'use strict';
const {task, series} = require('gulp');
const browserSync = require('browser-sync');
const {rollup} = require('rollup');
const babel = require('rollup-plugin-babel');
let cache;

const rollupTask = (entry, dest, moduleName) => {
  return rollup({
    entry: entry,
    cache: cache
  }).then(bundle => {
    cache = bundle;
    bundle.write({
      dest: dest,
      format: 'iife',
      moduleName: moduleName,
      plugins: [ babel() ]
    });
  });
}

task('rollup', () => {
  return rollupTask(
    'src/web-clock-lite.js',
    'dist/web-clock-lite.js',
    'webClockLite'
  );
});

task('browser-sync', () => {
  const reload = () => {
    return browserSync.reload;
  }

  browserSync.init({
    port: 8005,
    ui: {
     port: 8006
    },
    server: {
     baseDir: ['dist', 'demo']
    }
  });

  browserSync.watch('src/*.js').on('change', series('rollup', reload()));
  browserSync.watch('demo/*.html').on('change', reload());
});

task('build', series('rollup'));
task('serve', series('build', 'browser-sync'));
