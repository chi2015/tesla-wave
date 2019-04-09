var CoilRouter = Backbone.Router.extend({
	routes : {
		"" : "goToMain",
		"buy" : "goToBuy",
		"buy/:id" : "goToBuy",
		"art" : "goToArt",
		"art/:num" : "goToArt",
		"art/:num/:page" : "goToArt",
		"gallery" : "goToGallery",
		"gallery/photos" : "goToPhotos",
		"gallery/videos" : "goToVideos",
		"gallery/video/:id" : "goToVideo",
		"contact" : "goToContact",
	//	"order" : "goToOrder",
	//	"order/:id" : "goToOrder",
	//	"sent" : "goToSent"
	},
	localNavigate : function(route) {
		this[this.routes[route]]();
	},
	goToMain : function() {
		CoilModel.goToPage('Main');
	},
	goToBuy : function(id) { 
		
		if (!id) id = 0;
		CoilModel.currentProduct('');
		CoilModel.currentProductId(0);
		CoilModel.goToPage('Buy'); 
	
		if (CoilModel.products().length < 1)
		{
			CoilModel.initProductData('list', id, 'buy');
		}
		else {
			CoilModel.goToProductPage(id);
		}
	},
	goToArt : function(num, page) { 
		CoilModel.goToPage('Art');
		CoilModel.goToArticle(CoilModel.articles[num || 1]);
		CoilModel.currentArticlePage(page || 1);
	},
	goToGallery : function() { 
		CoilModel.goToPage('Gallery');
		CoilModel.galleryType('MainGallery');
		CoilModel.galleryTitle('Фото');
	},
	goToPhotos : function() {
		CoilModel.goToPage('Gallery');
		CoilModel.galleryType('PhotoGallery');
		if (CoilModel.galleryPhotos().length < 1) CoilModel.initProductData("gallery_photo");
		CoilModel.galleryTitle('Фото');
	},
	goToVideos : function() {
		CoilModel.goToPage('Gallery');
		CoilModel.galleryType('VideoGallery');
		if (CoilModel.galleryVideos().length < 1) CoilModel.initProductData("gallery_video");
		else CoilModel.setCurrentGalleryVideo(0);
		CoilModel.galleryTitle('Видео');
	},
	goToVideo : function(id) {
		CoilModel.goToVideo(id);
	},
	goToContact : function() {
		CoilModel.goToPage('Contact');
	},
	goToOrder : function(id) 
	{
		if (CoilModel.products().length < 1)
		{
			CoilModel.initProductData('list', id || 69, 'order');
		}
		else {
			CoilModel.currentProductId(id || 69);
			CoilModel.goToPage('Order');
		}
		
		CoilModel.orderStatus('Cart');
	},
	goToSent : function() {
		//CoilModel.goToPage('Order'); /*for debug */
		//CoilModel.orderStatus('Sent');
		if (CoilModel.orderStatus()!='Sent') document.location.href = "/order";
	}
});

var CoilModel = {};

CoilModel.mainText = ko.observable('');
CoilModel.currentPage = ko.observable('');

CoilModel.currentArticle = ko.observable('Tesla');
CoilModel.currentArticlePage = ko.observable(1);
CoilModel.nextArticlePage = function() { return parseInt(CoilModel.currentArticlePage())+1; }
CoilModel.prevArticlePage = function() { return parseInt(CoilModel.currentArticlePage())-1; }

CoilModel.orderStatus = ko.observable('Cart');
CoilModel.currentProduct = ko.observable('');

CoilModel.galleryType = ko.observable('MainGallery');
CoilModel.galleryTitle = ko.observable('Фото');

CoilModel.orderFIO = ko.observable('');
CoilModel.orderPhone = ko.observable('');
CoilModel.orderEmail = ko.observable('');
CoilModel.orderDeliveryType = ko.observable('Самовывоз');
CoilModel.orderCount = ko.observable(1);
CoilModel.orderComments = ko.observable('');

CoilModel.productPics = ko.observableArray([]);
CoilModel.currentProductPic = ko.observable(0);

CoilModel.galleryPhotos = ko.observableArray([]);
CoilModel.currentGalleryPhoto = ko.observable(0);
CoilModel.currentStartGalleryPhoto = ko.observable(0);
CoilModel.galleryPhotosOnPage = 10;

CoilModel.galleryVideos = ko.observableArray([]);
CoilModel.currentGalleryVideo = ko.observable(0);

CoilModel.bigProductPics = ko.observableArray([]);

CoilModel.mainProductData = ko.observable();
CoilModel.bigProductData = ko.observable();
    
CoilModel.products = ko.observableArray();
CoilModel.currentProductId = ko.observable(0);

CoilModel.videoDesc = ko.observable('');

CoilModel.navigateToBuy = function() { CoilModel.navigateTo("buy"); }
CoilModel.navigateToArt = function() { CoilModel.navigateTo("art"); }
CoilModel.navigateToGallery = function() { CoilModel.navigateTo("gallery"); }
CoilModel.navigateToPhotos = function() { CoilModel.navigateTo("gallery/photos"); }
CoilModel.navigateToVideos = function() { CoilModel.navigateTo("gallery/videos"); }
CoilModel.navigateToContact = function() { CoilModel.navigateTo("contact"); }
CoilModel.navigateToOrder = function() { CoilModel.navigateTo("order"); }

CoilModel.navigateTo = function(route) {
	if (local_version) { CoilModel.router.localNavigate(route); }
	else CoilModel.router.navigate( "/"+route, {trigger : true});
}


CoilModel.initMainText = function() {
	var _self = this;
	$.ajax({
		url: "http://tesla-wave.ru/server/hello.php",
		type: "POST",
		dataType: "json",
		data: { },
		cache: true,
		success: function(result)
		{
			if (result.text) _self.mainText(result.text);
		}
	});
}

CoilModel.getProductIndexById = function(id)
{
	for (var i=0; i<this.products().length; i++)
	{
		if (this.products()[i].product_id == id) return i;
	}
	
	return -1;
}
    
CoilModel.orderCost = function() {
	return typeof(this.products()[this.getProductIndexById(this.currentProductId())])!='undefined' ? parseFloat(this.products()[this.getProductIndexById(this.currentProductId())].price).toFixed(0)*this.orderCount() : 0;
}
    
CoilModel.orderProductName = function() {
	return typeof(this.products()[this.getProductIndexById(this.currentProductId())])!='undefined' ? this.products()[this.getProductIndexById(this.currentProductId())].name : '';
}
    
CoilModel.getColorClassByState = function(state)
{
	switch(parseInt(state))
	{
		case 5: 
		case 6:
		case 7: return 'state-green';
		case 8:
		case 9:  return 'state-red';
		case 10: return 'state-orange';
	}
}

CoilModel.setEmbedVideoIntoBlock = function(block_id, video_code)
{
	$('#'+block_id).html('<embed width="100%" height="100%" allowfullscreen="true" allowscriptaccess="always" wmode="transparent" type="application/x-shockwave-flash" src="http://www.youtube.com/v/'+video_code+'?fs=1&amp;hl=ru_RU&amp;autoplay=0&amp;rel=0"></embed>');
}

CoilModel.setCurrentGalleryVideo = function(i)
{
	this.currentGalleryVideo(i);
	this.setEmbedVideoIntoBlock('gallery-embed-video', this.galleryVideos()[i].name.substring(6));
}

CoilModel.initProductData = function(action_name, product_id, go_to)
{
	if (typeof(product_id) == 'undefined') var product_id = 0;
	if (typeof(go_to) == 'undefined') var go_to = false;
	
	var _self = this;
	 $.ajax({
		url: "http://tesla-wave.ru/server/product.php",
		data: {action: action_name, product_id : product_id},
		type: "POST",
		dataType: "json",
		cache: false,
		success: function(result) {
			 switch(action_name)
			 {
				case 'list':
					 _self.products(result);
					 for (var i=0; i< _self.products().length; i++)
					 {
						_self.products()[i].photos = ko.observableArray([]);
						_self.products()[i].video = ko.observable('');
						_self.products()[i].videoDesc = ko.observable();
					 }
					 if (product_id) {
							switch (go_to)
							{
								case 'buy': 
									_self.goToProductPage(product_id); 
									break;
								case 'video':
									_self.currentProductId(product_id);
									_self.initProductData('video', product_id);
									break;
								case 'order':
									_self.currentProductId(product_id);
									_self.goToPage('Order');
									break;
							}
					 } 
					 break;
				case 'photos':
					_self.products()[_self.getProductIndexById(product_id)].photos(result);
					_self.productPics(result);
					break;
				case 'video':
					_self.products()[_self.getProductIndexById(product_id)].video(result[0].name.substring(6));
					_self.products()[_self.getProductIndexById(product_id)].videoDesc(result[0].text);
					_self.setEmbedVideoIntoBlock('embed-video', _self.products()[_self.getProductIndexById(product_id)].video());
					_self.videoDesc(_self.products()[_self.getProductIndexById(product_id)].videoDesc());
					break;
				case 'pics':
					 _self.productPics(result);
					 _self.currentProductPic(0);
					 break;
				case 'big_pics':
					 _self.bigProductPics(result);
					 break;
				case 'main':
					 _self.mainProductData(result[0]);
					 break;
				case 'big':
					_self.bigProductData(result[0]);
					 break;
				case 'gallery_photo':
					_self.galleryPhotos(result);
					_self.currentGalleryPhoto(0);
					break;
				case 'gallery_video':
					_self.galleryVideos(result);
					_self.setCurrentGalleryVideo(0);
					break;
			 }
		}
	});
}

CoilModel.setCurrentProductPic = function(i)
{
	this.currentProductPic(i);
}

CoilModel.setCurrentGalleryPhoto = function(i)
{
	this.currentGalleryPhoto(i);
}

CoilModel.goToPage = function(page_name)
{
	 $('#embed-video').html('');
	 $('#embed-video-big').html('');
	 $('#gallery-embed-video').html('');

	 this.currentPage(page_name);
}

CoilModel.goToMain = function()
{
	if (!local_version) CoilModel.router.navigate("/", {trigger: true});
}

CoilModel.goToVideo = function(product_id)
{
	//this.setEmbedVideoIntoBlock('embed-video', '_qsecGIEEDo');
	this.goToPage('Video');
	
	if (typeof(this.products()[this.getProductIndexById(product_id)])=='undefined')
	{
		this.initProductData('list', product_id, 'video');
	}
	else
	if (this.products()[this.getProductIndexById(product_id)].video() == '')
	{
		this.initProductData('video', product_id);
	}
	else { 
		this.setEmbedVideoIntoBlock('embed-video', this.products()[this.getProductIndexById(product_id)].video());
		this.videoDesc(this.products()[this.getProductIndexById(product_id)].videoDesc());
	}
}

CoilModel.navigateToProduct = function(id) {
	this.navigateTo('buy/'+id);
}

CoilModel.goToProductPage = function(product_id)
{
	if (typeof(CoilModel.products()[CoilModel.getProductIndexById(product_id)]) == 'undefined') return;
	var is_big = CoilModel.products()[CoilModel.getProductIndexById(product_id)].is_big;
	
	if (is_big == 1)
	{
		this.goToBigCoil();
		this.currentProductId(0);
	}
	else
	{
		if (this.products()[this.getProductIndexById(product_id)].photos().length < 1) 
		{
			this.initProductData('photos', product_id);
		}
		else
		{
			this.productPics(this.products()[this.getProductIndexById(product_id)].photos());
		}
		
		this.currentProduct(''); 
		this.currentProductPic(0);
		this.currentProductId(product_id);
		
	}
}

CoilModel.articles = [0,'Tesla','Amper','Coil'];

CoilModel.getArticleIndex = function(article) {
	
	
	for (var i=0; i<CoilModel.articles.length; i++)
		if (CoilModel.articles[i] == article) return i;
}

CoilModel.goToArticle = function(art_name)
{
	this.currentArticle(art_name);
	this.currentArticlePage(1);
}

CoilModel.goToTeslaArticle = function()
{
	 this.navigateTo('art/1');
}

CoilModel.goToAmperArticle = function()
{
	 this.navigateTo('art/2');
}

CoilModel.goToCoilArticle = function()
{
	 this.navigateTo('art/3');
}

CoilModel.goToPrevPage = function()
{
	var new_page = 	parseInt(this.currentArticlePage()) - 1;
	this.navigateTo('art/'+this.getArticleIndex(this.currentArticle())+'/'+new_page);
}

CoilModel.goToNextPage = function()
{
	var new_page = 	parseInt(this.currentArticlePage()) + 1;
	this.navigateTo('art/'+this.getArticleIndex(this.currentArticle())+'/'+new_page);
}

CoilModel.sendOrder = function()
{
	var _self = this;

	if (_self.orderEmail() == '' && _self.orderPhone() == '')
	{
		alert('Укажите E-mail или телефон!');
		return;
	}

	if (_self.orderEmail() != '' && !_self.orderEmail().match("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$"))
	{
		alert('Введен некорректный E-mail!');
		return;
	}


	$.ajax({
		url: "http://tesla-wave.ru/server/sendmail.php",
		type: "POST",
		dataType: "json",
		data: { fio: _self.orderFIO(),
				phone: _self.orderPhone(),
				email: _self.orderEmail(),
				delivery_type: _self.orderDeliveryType(),
				count: _self.orderCount(),
				comments: _self.orderComments(),
				subject: "Заказ товара",
				cost: _self.orderCost(),
				name: _self.orderProductName()
				},
		cache: false,
		success: function(result)
			{
				if (result["status"] == 'ok')
				{
					_self.orderStatus("Sent");
					_self.navigateTo("sent");
					_self.orderCount(1);
				}
				else if (result.status == 'error')
				{
					 alert(result.desc);
				}
				else
				{
					alert('Системная ошибка!');
				}
			}
		});


}

CoilModel.goToBuyCoil = function()
{
	if (this.productPics().length < 1) this.initProductData("pics");
	if (typeof(this.bigProductData()) == 'undefined') this.initProductData("main");
	this.currentProduct('Coil');
}

CoilModel.goToRentCoil = function()
{
	this.currentProduct('Rent');
}

CoilModel.goToBigCoil = function()
{
	if (typeof(this.bigProductData()) == 'undefined') this.initProductData("big");
	if (this.bigProductPics().length < 1) this.initProductData("big_pics");
	this.setEmbedVideoIntoBlock('embed-video-big', '4l2Hhohw0Hg');

	this.currentProduct('BigCoil');
}

CoilModel.checkOrderStatus = ko.computed(function() { if (this.currentPage()!='Order') this.orderStatus('Cart');}, CoilModel);
//global_watch = CoilModel;
CoilModel.initMainText();
ko.applyBindings(CoilModel);

$(document).ready(function() {

	$('.image-popup-fit-width').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		image: {
			verticalFit: false
		}
	});

	CoilModel.router = new CoilRouter();
	if (!local_version) Backbone.history.start({pushState: true, root: '/'});
	
	$('#form-send-order').submit(function() {
		CoilModel.sendOrder();
		return false;
	});
});
