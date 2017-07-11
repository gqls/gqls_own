
// *Some* environments (phantomjs) don't have es5
(Function.prototype.bind)
require('babel-core/polyfill');

var context = require.context('./src', true, /-test\.jsx?$/);
context.keys().forEach(context);