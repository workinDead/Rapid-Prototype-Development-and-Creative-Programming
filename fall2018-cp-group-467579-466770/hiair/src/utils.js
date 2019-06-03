// utils.js: Integrate flight app with redux saga

import { FLIGHT_API_ENDPOINT } from './constants';
// ICONS
// import ThunderStormIcon from './views/assets/weather_icons/01W.svg';
// import RainIcon from './views/assets/weather_icons/02W.svg';
// import SnowIcon from './views/assets/weather_icons/03W.svg';
// import ClearIcon from './views/assets/weather_icons/04W-DAY.svg';
// import CloudsIcon from './views/assets/weather_icons/05W.svg';
// import NoLocationFound from './views/assets/no-location.svg';

export function flightAppAPI(requestHeaders, requestBody, callback) {
  console.log('calling flightAppAPI')
  console.log(requestHeaders,requestBody,callback);

  fetch(FLIGHT_API_ENDPOINT, {
    method: 'POST',
    mode: 'cors',
    body: JSON.stringify(requestBody),
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(res => res.json()).then(res => callback(false, res))
}


// export function weatherIcon(weatherId) {
//   if (weatherId <= 232) {
//     return ThunderStormIcon;
//   } else if (weatherId >= 300 && weatherId <= 531) {
//     return RainIcon;
//   } else if (weatherId >= 600 && weatherId <= 622) {
//     return SnowIcon;
//   } else if (weatherId === 800) {
//     return ClearIcon;
//   } else if (weatherId >= 801 && weatherId <= 804) {
//     return CloudsIcon;
//   }

//   return NoLocationFound;
// }