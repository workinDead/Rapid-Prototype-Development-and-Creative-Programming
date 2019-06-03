// index.js: Integrate react-redux in flight app
import React from 'react';
import ReactDOM from 'react-dom';
import './views/css/index.css'; // 到底是import 哪个css
import './views/css/App.css'; // 到底是import 哪个css
import { BrowserRouter as Router, Route } from 'react-router-dom' 


// redux initialization
import { Provider } from 'react-redux';

// Store
import store from './store/index';

// Views
import { App, ErrorDisplay } from './views/Components/index';
import { Order, Home, CurrentFlight,Payout,LoginForm,SignupForm } from './views/Containers/index';



ReactDOM.render(
	// 之后可以写在APP.js里
	<Provider store={store}>
	  <Router>
		<App>

		  <Route exact path='/' component={Home}/>
			<Route exact path='/signup' component={SignupForm}/>
			<Route path='/login' component={LoginForm}/>
			<Route path='/order' component={Order}/>

		  <Route exact path='/current-flight' component={CurrentFlight}/>
		  <Route exact path='/error' component={ErrorDisplay}/>
			<Route exact path='/payout' component={Payout}/>

		</App>
	  </Router>
	</Provider>
	, document.getElementById('root'));
  
  // registerServiceWorker(); // eslint-disable-line no-undef
// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
// serviceWorker.unregister(); // eslint-disable-line no-undef

