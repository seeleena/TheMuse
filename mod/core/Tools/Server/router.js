var fs = require("fs");

function route(pathname, request, response) {
	if (pathname == "/index.html") {
		fs.readFile(__dirname + "/index.html", 
		function(error, data) {
			if (error) {
				response.writeHead(500);
				return response.end("Error loading " + pathname);
			}
			response.writeHead(200);
			response.end(data);
		});
	}
	else {
		response.writeHead(404);
		response.end("There's no such resource here at this time.");
	}
}

exports.route = route;