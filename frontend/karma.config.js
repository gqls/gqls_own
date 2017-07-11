/** Created on 20/06/2017. */

module.exports = function (config) {
    config.set({
        browsers: [ 'Firefox', 'PhantomJS'],
        singleRun: true,
        frameworks: ['mocha', 'jasmine'],
        files: [
            'tests.webpack.js'
        ],
        preprocessors: {
            'tests.webpack.js': [ 'webpack', 'sourcemap']
        },
        devtool: 'eval',
        reporters: [ 'dots' ],
        webpack: {
            module: {
                loaders: [
                    { test: /\.jsx? #$/, exclude: /node_modules/, loader: 'babel-loader'}
                ]
            }
        },
        webpackServer: {
            noInfo: false
        }
    })
}
