/** Created on 25/06/2017. */

import AddToDoForm from '../components/componentAddToDoForm';
import addToDoAction from '../actions/actionAddToDo';
import { connect } from 'react-redux';

let mapDispatchToProps = (dispatch) => {
    return {
        onSubmit: (text) => {
console.log('text in add to do container', text);
            dispatch(addToDoAction(text));
        }
    }
};

let AddToDoContainer = connect(null, mapDispatchToProps)(AddToDoForm);

export default AddToDoContainer;