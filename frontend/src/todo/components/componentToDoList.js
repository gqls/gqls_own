import ToDo from './componentToDo';
import React from 'react';

const ToDoList = ({todos, onToDoClick}) => {

    if (todos.length === 0) {
        return <div>Add ToDos</div>
    }

    return (
        <ul>
            {todos.map(
                (todo) => <ToDo
                                key={todo.id}
                                {...todo}
                                onClick={()=>onToDoClick(todo.id)}
                            />

            )}
        </ul>
    );
};

export default ToDoList;
