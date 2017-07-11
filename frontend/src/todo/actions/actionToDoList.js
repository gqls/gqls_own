/** Created on 25/06/2017. */

const toDoListAction = (list) => {
    return {
        type: 'TODO_LIST',
        list
    }
};

export default toDoListAction;