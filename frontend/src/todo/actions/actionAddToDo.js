/** Created on 25/06/2017. */

let nextToDoId = 1;

const addToDoAction = (text) => {

/*console.log('in add to do action', text);
console.log('nextToDoId', nextToDoId);
console.log('nextToDoId++', nextToDoId++);
console.log('nextToDoId+=1', nextToDoId += 1);*/


    return {
        type: 'ADD_TODO',
        id: nextToDoId++,
        text
    }
};

export default addToDoAction;