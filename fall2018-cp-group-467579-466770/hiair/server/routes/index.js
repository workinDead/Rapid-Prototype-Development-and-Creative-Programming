// index.js: add scripts to run server and client from root directory

require('module-alias/register'); // module-alias: a better way to import module without complicated relative/absolute path

const fs = require('fs');

module.exports = (app) => { // this line of code exists as the first line of code to export module
  // require all API endpoints
  fs.readdirSync(`${__dirname}/api/`).forEach((file) => { //  we want to become available in other files to the exports object:
    require(`./api/${file.substr(0, file.indexOf('.'))}`)(app);
    console.log(file)

  });
  console.log('routes -> index.js running')
};

// !Attention: The keyword require returns an object, which references the value of module.exports for a given file. If a developer unintentionally or intentionally re-assigns module.exports to a different object or different data structure, then any properties added to the original module.exports object will be unaccessible.