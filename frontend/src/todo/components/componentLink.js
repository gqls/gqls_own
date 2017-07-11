/** Created on 25/06/2017. */

import React from 'react';

const Link = ({active, children, onClick}) => {
    if (active) {
console.log('active in link', active);
        return (
            <span>{children}</span>
        );
    }

    return (
        <a href="#" onClick={e=>{onClick()}}>{children}</a>
    );
};

export default Link;