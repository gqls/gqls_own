import React from 'react';
import Footer from './componentFooter';
import AddToDoContainer from '../containers/containerAddToDo';
import VisibleToDoListContainer from '../containers/containerVisibleToDoList';

const App = () => (
    <div>
        <AddToDoContainer/>
        <VisibleToDoListContainer/>
        <Footer/>
    </div>
);

export default App;