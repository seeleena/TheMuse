var util = require('util');
var mongojs = require('mongojs');
var mongoURI = 'mongodb://localhost:27017/the-muse';
var mongoDB = null;

function getDB() {
  console.log('Getting MongoDB Connection.');
  listAllModules();
  if (mongoDB === null) {
    console.log('MongoDB is null. Connecting now.');
    mongoDB = mongojs(mongoURI, ['nodedata']).nodedata;
  }
  console.log('Returning MongoDB Connection');
  return mongoDB;
}

function listAllModules() {
  console.log('About to list all modules.');
  var fs = require('fs');
  var dirs = fs.readdirSync('node_modules');
  var data = {};
  dirs.forEach(function (dir) {
    try {
      var file = 'node_modules/' + dir + '/package.json';
      file = fs.readFileSync(file, 'utf8');
      var json = JSON.parse(file);
      var name = json.name;
      var version = json.version;
      data[name] = version;
    } catch (err) {
      console.log('Error getting modules: ' + err);
    }
  });
//   console.log('MongoJS Version: ' + data['mongojs']);
//   console.log('MongoDB Version: ' + data['mongodb']);
//   console.log('All versions:');
//   console.log(JSON.stringify(data));
}

function debugVar(name, value) {
  if (value != undefined) {
    console.log(
      '\n' +
        name +
        ':\n' +
        util.inspect(value, { showHidden: true, depth: null }) +
        '\n'
    );
  } else {
    console.log('\n' + name + ':\n[NULL]\n');
  }
}

exports.getDB = getDB;
exports.debugVar = debugVar;
