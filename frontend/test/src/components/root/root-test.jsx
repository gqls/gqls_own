import React from 'react';
import ReactDOM from 'react-dom';
import TestUtils from 'react-addons-test-utils';
import expect from 'expect';
import Root from './root';

//var TestUtils = require('react/lib/ReactTestUtils');

describe('root', function () {
    it('renders without problems', function() {
        let root = TestUtils.renderIntoDocument(<Root/>);
        expect(root).toExist();
    })

    it('changes without problems', function () {
        let root = TestUtils.renderIntoDocument(<Root/>);

        const inputNode = ReactDOM.findDOMNode(root.refs.input);
        inputNode.value = newValue;
        TestUtils.Simulate.change(inputNode);

        const nameNode = ReactDOM.findDOMNode(root.refs.name);
        expect(nameNode.textContent).toEqual(newValue);
    });
});