// index.js: Integrate flight app with redux saga
// reference to https://blog.cloudboost.io/getting-started-with-react-native-and-redux-6cd4addeb29
// - actions
// - reducers
// - sagas 

import { createStore, applyMiddleware, compose } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';

import createSagaMiddleware from 'redux-saga';
import rootReducer from './reducers/index';
import rootSaga from './sagas/index';


const sagaMiddleware = createSagaMiddleware();

// const reduxDevTools = window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__();

const store = createStore(
  rootReducer,
  composeWithDevTools(applyMiddleware(sagaMiddleware))
);

sagaMiddleware.run(rootSaga);

export default store;