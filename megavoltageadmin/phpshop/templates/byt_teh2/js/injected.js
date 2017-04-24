var __AlterGeo__Chrome_Ext__ = function()
{
	
	var plugin = null;
	
	this.Init = function()
	{
		try
		{
			var emb = document.createElement('embed');
			emb.setAttribute('type', 'application/altergeoproject');
			emb.setAttribute('id', '__altergeo_plugin__');
			emb.setAttribute('width', '0px');
			emb.setAttribute('height', '0px');
			emb.setAttribute('hidden', 'true');
				
			document.body.appendChild(emb);
			plugin = document.getElementById("__altergeo_plugin__");
		}catch(e){}
	}
	
	this.__defineGetter__("doctype", function () {return plugin.doctype});
	this.__defineGetter__("sd", function () {return plugin.sd;});
	this.__defineGetter__("apikey", function () {return plugin.apikey;});
	this.__defineGetter__("uuid", function () {return plugin.uuid;});
	this.__defineGetter__("version", function () {return plugin.version;});
	this.__defineGetter__("locationprovider", function () {return plugin.locationprovider;});
	
	this.__defineSetter__("doctype", function (value) {return plugin.doctype = value;});
	this.__defineSetter__("apikey", function (value) {return plugin.apikey = value;});
	
	
	this.Init();
	
	
	this.getCurrentPosition = function(onSuccess, onError)
	{
		if(onError != undefined)
			plugin.GetCurrentPosition(onSuccess, onError);
		else
			plugin.GetCurrentPosition(onSuccess);
	}
	
	this.setLocation = function(lat, lng, zoom, onSuccess)
	{
		onSuccessFeedback = onSuccess;
		
		plugin.SetLocation(lat, lng, zoom, onSuccess);
	}
	
	this.prepare = function(onSuccess, onError)
	{
		if(onError != undefined)
			plugin.prepare(onSuccess, onError);
		else
			plugin.prepare(onSuccess);
	}
}

try
{
	window.__defineGetter__('_altergeo_bho', function() {
		return window.altergeo_bho || (window.altergeo_bho = new __AlterGeo__Chrome_Ext__()) 
	});
}catch(e){}



