var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('login', './assets/requiredLogin.js')
    .addEntry('dashboard', './assets/requiredDashboard.js')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
