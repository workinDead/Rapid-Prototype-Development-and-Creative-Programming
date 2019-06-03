import { put, call, takeLatest } from 'redux-saga/effects';

import * as actions from '../actions/action-types';
import { flightAppAPI } from '../../utils';

export default function * root() {
  yield takeLatest(actions.GET_FLIGHT_DATA, fetchFlightData);
  // yield takeLatest(actions.GET_LOGIN_DATA,getLoginData);

};
// function * getLoginData(action){
//   try{
//     const {loginData} = action.payload;
//     yield put({ type: actions.SET_USERNAME_STATUS,payload:{...loginData}});

//   }catch(e){
//     console.log('failed');
//   }
// }

function * fetchFlightData(action) {
  try {
    const { flightSearchData } = action.payload;

    yield put({ type: actions.LOADING_FLIGHT_DATA });

    const response = yield call(flightApiPromiseWrapper, flightSearchData);
    console.log(response.data)
    if(response.data.errors){
      // if "errors" is defined in response.data
      console.log('error request')
      yield put({type: actions.ERROR_FLIGHT_DATA });

    }else{
      // successfully 
      yield put({ type: actions.LOADED_FLIGHT_DATA, payload: { ...response.data } });

    }
    // yield put({ type: actions.LOADED_FLIGHT_DATA, payload: { ...response.data } });

  } catch (e) {
    yield put({type: actions.ERROR_FLIGHT_DATA });
  }
}

function * flightApiPromiseWrapper(flightSearchData) {
  const promise = yield new Promise((resolve, reject) => {
    flightAppAPI({}, flightSearchData, function(err, data) {
      console.log('sagas -> index.js')
      console.log('err:',err)
      console.log('data:',data)

      if (err) {
        reject(err);
      } else {
        resolve(data);
      }
    });
  });

  return promise;
}