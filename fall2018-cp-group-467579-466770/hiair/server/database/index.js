//Connect to Mongo database

//Import the mongoose module
const mongoose = require('mongoose')

// Get Mongoose to use the global promise library
mongoose.Promise = global.Promise

//Set up default mongoose connection
const url = 'mongodb://127.0.0.1/hiair' 

mongoose.connect(url, { useNewUrlParser: true }).then(
    () => { 
        /** ready to use. The `mongoose.connect()` promise resolves to undefined. */ 
        console.log('Connected to Mongo');
    },
    err => {
         /** handle initial connection error */ 
         console.log('error connecting to Mongo: ')
         console.log(err);
         
        } 
  );


module.exports = mongoose.connection