
const bodyParser = require('body-parser')
const morgan = require('morgan')
const session = require('express-session') // to know if a browser has made a request to us before
const dbConnection = require('./database') 
const MongoStore = require('connect-mongo')(session) // connect-mongo stores session info in db in order for more than one user at a time
const passport = require('./passport');
const user = require('./routes/api/user')

const loginServer = app => {
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
    
    // app.use('/signu', user)
};

module.exports = loginServer;