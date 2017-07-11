var React = require('react');
var TestUtils = require('react/lib/ReactTestUtils'); //I like using the Test Utils, but you can just use the DOM API instead.
var expect = require('expect');
var Root = require('../app'); //my root-test lives in components/__tests__/, so this is how I require in my components.


describe('app', function () {
    it('loads without problems', function () {
        var root = TestUtils.renderIntoDocument(<Root/>);
        expect(root).toExist();
    });
});