// Modularize url and improve code structure
// update according to flight needed data 

module.exports = {
    baseUrl: {
      protocol: 'http',
      hostname: 'api.travelpayouts.com',
      // onewaypath:'/v2/prices/month-matrix',
      roundwaypath:'/v2/prices/week-matrix',
      path: '/v2/prices/month-matrix',

    },
  
    query: {
      currency:'currency',
      origin:'origin',
      destination:'destination',
      month:'month',
      depart_date:'depart_date',
      return_date:'return_date'
    //   coordinates: {
    //     latitude: 'lat',
    //     longitude: 'lon',
    //   },
    },
    constants:{
      currency:'usd'
    },
    
    APIkey: '05e3bc7638aa0782d866a2453b20834f',
  };