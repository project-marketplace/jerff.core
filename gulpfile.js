"use strict";
/*
 npm install gulp@4.0.0 gulp-build-bitrix-modul --save
 */

let gulp = require('gulp');
let build = require('gulp-build-bitrix-modul')({
    name: 'jerff.b24autotask',
    tools: {
        'project.tools': ['Project', 'Tools']
    },
    encode: [
        'include.php',
        'project.tools/**/*.php',
        '!project.tools/modules/install.php'
    ]
});

// Сборка текущей версии модуля
gulp.task('release', build.release);

// Сборка текущей версии модуля для маркеплейса
gulp.task('last_version', build.last_version);

// Сборка обновления модуля (разница между последней и предпоследней версией по тегам git)
gulp.task('build_update', build.update);

// Дефолтная задача. Собирает все по очереди
gulp.task('default', gulp.series('last_version', 'build_update'));