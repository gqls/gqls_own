const todos = (state = [], action) => {
    switch (action.type) {
        case 'ADD_TODO':
console.log('in todolist reducer add todo action type action is:', action, 'state is ', state);
            let myState = [...state, {id: action.id, text:action.text, completed: false}];
console.log('myState after append ',myState);
            return myState;

        case 'TOGGLE_TODO' :
            return state.map((todo) => {
                if (todo.id != action.id) {
                    return todo;
                }
                return Object.assign(
                    {},
                    todo,
                    {completed: !todo.completed}
                )
            });

        default :
            return state;
    }
};

export default todos;