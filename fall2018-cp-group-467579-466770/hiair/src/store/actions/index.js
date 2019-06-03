// index.js: export all the actions in a single file

import { SET_FLIGHT_TEXT_INPUT, SET_DEFAULT_INPUT,
    GET_FLIGHT_DATA, LOADING_FLIGHT_DATA, LOADED_FLIGHT_DATA, ERROR_FLIGHT_DATA,SET_LOGIN_STATUS,SET_LOGOUT_STATUS,GET_LOGIN_DATA,SET_USERNAME_STATUS } from './action-types';
  
  export const setFlightTextInput = flightInputConfig => (
    {
      type: SET_FLIGHT_TEXT_INPUT,
      payload: flightInputConfig,
    }
  );
  
  
  export const setDefaultInput = () => {
    return {
      type: SET_DEFAULT_INPUT,
    };
  };
  
  export const getFlightData = (flightSearchData) => {
    // console.log('index.js :',flightSearchData)
    return {
      type: GET_FLIGHT_DATA,
      payload: flightSearchData,
    };
  };
  

  export const getLoginData = loginData => ( 
     {
      type:SET_USERNAME_STATUS,
      payload:loginData
  }
  );
  export const setLogoutStatus = () =>({
      type:SET_LOGOUT_STATUS
  });

  export{SET_FLIGHT_TEXT_INPUT, SET_DEFAULT_INPUT,
    GET_FLIGHT_DATA, LOADING_FLIGHT_DATA, LOADED_FLIGHT_DATA, ERROR_FLIGHT_DATA,SET_LOGIN_STATUS,SET_LOGOUT_STATUS,SET_USERNAME_STATUS,GET_LOGIN_DATA };