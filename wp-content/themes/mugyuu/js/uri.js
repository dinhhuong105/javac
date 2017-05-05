var Uri = function(uri) {
	this.uri = uri;
	this.segments = null;
	this.query = null;
	arguments.callee.buildQuery = function(object) {
		var string = '';
		var params = [];
		for(var key in object) {
			params.push(key + '=' + object[key]);
		}
		return params.join('&');
	};
};
Uri.prototype.parse = function() {
	this.segments = this.uri.split('?');
	var query = {};
	if(this.segments[1] !== undefined) {
		var params = this.segments[1].split('&');
		for(var i in params) {
			var param = params[i].split('=');
			var key = (param[0] !== undefined) ? param[0] : null;
			var value = (param[1] !== undefined) ? param[1] : null;
			query[key] = value;
		}
	}
	return {
		'uri': this.uri,
		'without_query': this.segments[0],
		'query': query,
		'query_string': this.segments[1]
	};
};
