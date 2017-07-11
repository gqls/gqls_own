/** Created on 23/06/2017. */

import React from 'react';
import ReactDOM from 'react-dom';

let Hi = React.createClass({

    render:  () => {
        return (
            <div className="High">blue - { this.props.name }</div>
        )
    }
});

module.exports=Hi;

ReactDOM.render(
    <Hi name="myName" />,
    document.getElementById('myContainer')
);
