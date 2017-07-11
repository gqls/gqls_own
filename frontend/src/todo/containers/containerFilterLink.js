/** Created on 25/06/2017. */

import React from 'react';
import { connect } from 'react-redux';
import Link from '../components/componentLink';
import setVisibilityFilterAction from '../actions/actionSetVisibilityFilter';

const mapStateToProps = (state, ownProps) => {
    return {
        active: ownProps.filter === state.visibilityFilter
    }
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        onClick: () => {
            dispatch(setVisibilityFilterAction(ownProps.filter));
        }
    }
};

let FilterLink = connect(
    mapStateToProps,
    mapDispatchToProps
)(Link);

export default FilterLink;