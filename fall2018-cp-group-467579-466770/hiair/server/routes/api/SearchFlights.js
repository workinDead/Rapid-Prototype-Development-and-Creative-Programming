// Restructure server api and add more flight config for flight app

// const fetch = require('node-fetch');

// module.exports = (app) => {
//   // This module will eventually be imported elsewhere making the routes available for use.
  
//   let origin;
// 	let destination;
// 	let begin_of_period;
// 	let end_of_period;

// 	app.post('/search-oneway', (req, res) => {
// 		console.log('hello post')
// 		origin = req.body.origin;
// 		destination = req.body.destination;
// 		begin_of_period = req.body.begin_of_period;
// 		end_of_period = req.body.end_of_period;
		
	
// 		// validate input 
// 		res.redirect('/search')
// 		// if(!zipcode || zipcode.length < 5 || zipcode.length > 5) {
// 		// 	res.redirect('/error');
// 		// } else { 
// 		// 	res.redirect('/current-weather');
// 		// }
// 	})

//   // 优化时可根据检索调整url
// 	app.get('/search-oneway-flight', (req, res) => {
// 		console.log('hello get')
// 		origin = req.body.origin;
// 		destination = req.body.destination;
// 		begin_of_period = req.body.begin_of_period;
// 		end_of_period = req.body.end_of_period;
		
// 		//build api URL with user zip
// 		const baseUrl = 'http://api.travelpayouts.com/v2/prices/month-matrix?currency=usd';	 // default currency (usd)
// 		const apiId = '&token=05e3bc7638aa0782d866a2453b20834f';

//     // customize url based on query
// 		const userQuery = (url1, url2, query) => {

// 		   let newUrl = url1 + query + url2;
// 		   return newUrl;
// 		};	
//     const query = `&origin=${origin}&destination=${destination}&month=${begin_of_period}`
// 		const apiUrl = userQuery(baseUrl, apiId, query);
//     console.log("apiUrl: ",apiUrl)

// 		fetch(apiUrl)
// 		.then(res => res.json())
// 		.then(data => {
// 			if(Object.keys( data.data ).length!==0){
// 				res.send({ data });
// 			}else{
// 				console.log('no data return')
// 			}
// 			console.log(data.data)
// 		})
// 		.catch(err => {
// 			res.redirect('/error');
// 		});

// 	})

// }


// test SearchFlight 2018-11-26

const fetch = require('node-fetch');
const generateWebAppURL = require('../../utils').generateWebAppURL;

module.exports = (app) => {

  app.post('/search-flight', (req, res) => {
    console.log(req)
    const requestBody = req.body;
    const apiUrl = generateWebAppURL(requestBody.flightData);
    console.log('SearchFlights.js: ',apiUrl)
    fetch(apiUrl)
      .then(res => res.json())
      .then(data => {
        console.log(data);
        res.send({ data });
      })
      .catch(err => {
        res.redirect('/error');
      });
  });
};