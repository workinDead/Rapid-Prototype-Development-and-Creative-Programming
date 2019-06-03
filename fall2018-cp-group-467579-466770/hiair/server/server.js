// const express = require('express')
// const bodyParser = require('body-parser')
// const morgan = require('morgan')
// const session = require('express-session') // to know if a browser has made a request to us before
// const dbConnection = require('./database') 
// const MongoStore = require('connect-mongo')(session) // connect-mongo stores session info in db in order for more than one user at a time
// const passport = require('./passport');
// const app = express()

// // Import the library:


// const PORT = 8080

// console.log("server post username");
// // Route requires
// require('./routes/SearchFlights')(app)
// const user = require('./routes/user')
// Log the req.session
// app.use( (req,res,next)=>{
// 	console.log('req.session',req.session);
// 	return next();
// })

// // MIDDLEWARE
// app.use(morgan('dev'))
// app.use(
// 	bodyParser.urlencoded({
// 		extended: false
// 	})
// )
// app.use(bodyParser.json())

// // Sessions
// app.use(
// 	session({
// 		secret: 'workindead', //pick a random string to make the hash that is generated secure
// 		store: new MongoStore({ mongooseConnection: dbConnection }),
// 		resave: false, //required: not resave to the session store unless modified
// 		saveUninitialized: false //required: an unintialized session is an unmodified one
// 	})
// )

// // Passport: initialize the passport session and start the passport session
// app.use(passport.initialize())
// app.use(passport.session()) // calls the serializeUser(store the user id to req.session.passport.user = {id:'...'}) and deserializeUser (check if this user is save in db)

// // Routes
// app.use('/user', user)

// // Starting Server   
// app.listen(PORT, () => {
// 	console.log(`App listening on PORT: ${PORT}`)
// })

// test request API
const express = require('express')
const app = express()
const port = 8080 
const cors = require('cors')
const bodyParser = require('body-parser')
const morgan = require('morgan')
const session = require('express-session') // to know if a browser has made a request to us before
const dbConnection = require('./database') 
const MongoStore = require('connect-mongo')(session) // connect-mongo stores session info in db in order for more than one user at a time
const passport = require('./passport');

// app.use(express.urlencoded({extended:true}))
   // Log the req.session
   app.use( (req,res,next)=>{
	console.log('req.session',req.session);
	return next();
})
// MIDDLEWARE
app.use(morgan('dev'))
app.use(
	bodyParser.urlencoded({
		extended: false
	})
)
app.use(bodyParser.json())

// Sessions
app.use(
	session({
		secret: 'workindead', //pick a random string to make the hash that is generated secure
		store: new MongoStore({ mongooseConnection: dbConnection }),
		resave: false, //required: not resave to the session store unless modified
		saveUninitialized: false //required: an unintialized session is an unmodified one
	})
)
// Passport: initialize the passport session and start the passport session
app.use(passport.initialize())
app.use(passport.session()) // calls the serializeUser(store the user id to req.session.passport.user = {id:'...'}) and deserializeUser (check if this user is save in db)

// app.use(express.json())
app.use(cors())

// Import Routes directory
require('./routes')(app)
// require('./loginServer')(app)

app.get('/',(req,res)=>{
	res.send('PORT 8080');
})

app.listen(port,(err)=>{
	if(err){console.log(err)};
	console.log('Listening on port ' + port);
})
