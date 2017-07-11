import { connect } from 'react-redux';
import ToDoList from '../components/componentToDoList';
import toggleToDoAction from '../actions/actionToggleToDo';

const getVisibleToDos = (todos = [], filter) => {
    switch (filter) {
        case 'SHOW_ALL' :
console.log('todos in getvisibletodos switch', todos);
            return todos;
        case 'SHOW_COMPLETED':
console.log('todos in getvisibletodos in show completed switch', todos);
console.log('filter in getvisibletodos in show completed switch', filter);
            return todos.filter(t => t.completed);
        case 'SHOW_ACTIVE':
console.log('todos in getvisibletodos in show active switch', todos);
console.log('filter in getvisibletodos in show active switch', filter);

            return todos.filter(t => !t.completed);
    }
};

const mapStateToProps = (state) => {
    console.log('map state to props in vis todolist container, state:', state);
    console.log('map state to props in vis todolist container, state.todos:', state.todos);
    return {
        todos: getVisibleToDos(
            state.todos,
            state.visibilityFilter
        )
    }
};

const mapDispatchToProps = (dispatch) => {
    return {
        onToDoClick: (id) => {
            dispatch(toggleToDoAction(id));
        }
    }
};

let VisibleToDoListContainer = connect(
    mapStateToProps,
    mapDispatchToProps
)(ToDoList);

export default VisibleToDoListContainer;