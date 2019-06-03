// index.js: enforces the definition of all the redux components in a single file
import { SET_FLIGHT_TEXT_INPUT,  SET_DEFAULT_INPUT,
    LOADING_FLIGHT_DATA, LOADED_FLIGHT_DATA, ERROR_FLIGHT_DATA } from '../actions/index';
import { STATES } from 'mongoose';
import { SET_LOGIN_STATUS,SET_LOGOUT_STATUS,SET_USERNAME_STATUS } from '../actions/index';
  
  const defaultState = {
    flightData: '',
    // flightType: false,
    loading: true,
    loaded: false,
    error: false,
    logged:false,
    username:null
  };
  
  const rootReducer = function(state = defaultState, action) {
    const { payload } = action;
  
    switch (action.type) {
      case SET_FLIGHT_TEXT_INPUT: {
        return { ...state, flightData: payload.flightData };
      }
      case SET_DEFAULT_INPUT: {
        return { ...state };
      }
      case LOADING_FLIGHT_DATA: {
        return { ...state, loading: true, loaded: false, error: false };
      }
      case LOADED_FLIGHT_DATA: {
        const { data, success } = payload;
  
        return { ...state, loading: false, loaded: success, main: data};
      }
      case ERROR_FLIGHT_DATA: {
        return { ...state, loading: false, error: true };
      }
      case SET_LOGIN_STATUS: {
        return {...state,logged:true}
      }
      case SET_LOGOUT_STATUS: {
        return {...state,logged:false,username:null}
      }
      case SET_USERNAME_STATUS: {
        const {username} = payload;
        // console.log(username)
        return {...state,logged:true,username:username}
      }

      default: {
        return { ...state };
      }
    }
  };
  
  export default rootReducer;