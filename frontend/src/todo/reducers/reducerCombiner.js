
import todos from './reducerToDoList';
import visibilityFilter from './reducerVisibilityFilter';
import { combineReducers } from "redux";

const todoApp = combineReducers({
    todos,
    visibilityFilter
});


export default todoApp;