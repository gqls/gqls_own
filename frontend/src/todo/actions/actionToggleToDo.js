/** Created on 25/06/2017. */

const toggleToDoAction = (id) => {
    return {
        type: 'TOGGLE_TODO',
        id
    }
};

export default toggleToDoAction;