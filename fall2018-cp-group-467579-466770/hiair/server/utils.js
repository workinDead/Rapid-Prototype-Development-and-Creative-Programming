// Modularize to generateWebAppURL and improve code structure
// update according to flightConfigType 
// import { FLIGHT_API_CURRENCY } from './constants';

// import {FLIGHT_API_CURRENCY} from './constants'
// console.log(FLIGHT_API_CURRENCY);
const url = require('url');
const config = require('./config');

module.exports = {
  generateWebAppURL: function(flightConfigData) {
    const baseUrlConfig = config.baseUrl;
    const APIkey = config.APIkey;
    const queryConfig = config.query;
    const constants = config.constants;

    // console.log('flightConfigData:',flightConfigData);
    let requestQuery = { token: APIkey };
    let path = '';
    requestQuery[queryConfig.origin] = flightConfigData.origin;
    requestQuery[queryConfig.destination] = flightConfigData.destination;
    // requestQuery[queryConfig.month] = flightConfigData.month;
    requestQuery[queryConfig.currency] = constants.currency;

    
    if(flightConfigData.tripType){
      // roundway
      path =baseUrlConfig.roundwaypath;
      requestQuery[queryConfig.depart_date] = flightConfigData.month;
      requestQuery[queryConfig.return_date] = flightConfigData.end_of_period;
    }else{
      // oneway
      path =baseUrlConfig.path;
      requestQuery[queryConfig.month] = flightConfigData.month;
    }
    console.log("generateWebAppURL:",requestQuery,path)

    // if (locationConfigType !== 'coordinates') {
    //   requestQuery[queryConfig[locationConfigType]] = locationConfigData;
    // } else {
    //   if (locationConfigData.latitude) {
    //     requestQuery[queryConfig.coordinates.latitude] = locationConfigData.latitude;
    //   }

    //   if (locationConfigData.longitude) {
    //     requestQuery[queryConfig.coordinates.longitude] = locationConfigData.longitude;
    //   }
    // }

    return url.format({
      protocol: baseUrlConfig.protocol,
      hostname: baseUrlConfig.hostname,
      pathname: path,
      query: requestQuery,
    });
  },
};