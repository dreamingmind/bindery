//----------------------------------------------------------------

//                Configuration

//----------------------------------------------------------------

var zoomAreaWidth = '400px';

var zoomAreaHeight = '400px';

var loadingImg = '/images/throbber.gif';

var thumbFadeSpeed = 9;



//----------------------------------------------------------------

//                Global Variables

//----------------------------------------------------------------

//Instances Handler

var ZoomsInstances = new Array();

//Detect Browser

var Rb_UA = 'msie';

var Br = navigator.userAgent.toLowerCase();



if(Br.indexOf("opera")!=-1) {

	Rb_UA = 'opera';

}

else if(Br.indexOf("msie")!=-1) {

	Rb_UA = 'msie';

}

else if(Br.indexOf("safari")!=-1) {

	Rb_UA = 'safari';

}

else if(Br.indexOf("mozilla")!=-1) {

	Rb_UA = 'gecko';

}

//----------------------------------------------------------------

//                Functions

//----------------------------------------------------------------

function $rz(ID) {

	if (document.getElementById) {

		return document.getElementById(ID);

	}else if (document.all){

		return document.all[ID];

	}else if (document.layers) {

		return document.layers[ID];

	}else {

		return false;

	}

};

function GetStyle(El,StyleProp) {

	if(El.currentStyle) {

		var y = El.currentStyle[StyleProp];

		y = parseInt(y)? y : '0px';

	}else if(window.getComputedStyle) {

		var css = document.defaultView.getComputedStyle(El,null);

		var y = css ? css[StyleProp] : null;

	} else {

		y = El.style[StyleProp];

		y = parseInt(y) ? y : '0px';

	}

	return y;

};

function GetBounds(El) {

	if(El.getBoundingClientRect) {

		var r = El.getBoundingClientRect();

		var wx = 0;

		var wy = 0;

		if(document.body && (document.body.scrollLeft || document.body.scrollTop)) {

			wy = document.body.scrollTop;

			wx = document.body.scrollLeft;

		} else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {

			wy = document.documentElement.scrollTop;

			wx = document.documentElement.scrollLeft;

		}

		return {'left':r.left + wx,'top':r.top+wy,'right':r.right+wx,'bottom':r.bottom+wy}

	}

};

function GetEventBounds(El) {

	var x = 0;

	var y = 0;

	if(Rb_UA == 'msie') {

		y = El.clientY;

		x = El.clientX;

		if(document.body && (document.body.scrollLeft||document.body.scrollTop)) {

			y = El.clientY+document.body.scrollTop;

			x = El.clientX+document.body.scrollLeft;

		} else if(document.documentElement&&(document.documentElement.scrollLeft||document.documentElement.scrollTop)) {

			y = El.clientY+document.documentElement.scrollTop;

			x = El.clientX+document.documentElement.scrollLeft;

		}

	} else {

		y = El.clientY;

		x = El.clientX;

		y += window.pageYOffset;

		x += window.pageXOffset;

	}

	return { 'x':x,'y':y }

};

function CreateMethodReference(Obj,MethodName) {

	Args=[];

	for(var i=2; i <arguments.length; i++)

		Args.push(arguments[i]);

	return function() {

		Obj[MethodName].apply(Obj, Concat(Args,arguments));

	}

};

function Concat() {

	var Result=[];

	for(var i=0; i<arguments.length; i++)

		for(var j=0; j<arguments[i].length; j++)

			Result.push(arguments[i][j]);

	return Result;

};

//----------------------------------------------------------------

//                Rbista Zoom

//----------------------------------------------------------------

var Rb_zoom = function(SImgContID, SImgID, ZImgContID, ZImgID, Position){

    //Objects

	this.SImgCont = $rz(SImgContID);

	this.SImg = $rz(SImgID);

	this.ZImgCont = $rz(ZImgContID);

	this.ZImg = $rz(ZImgID);

	//Posistions an Dims

	this.Position = Position;

	this.ZImgSizeX = 0;

	this.ZImgSizeY = 0;

	this.ZImgContStyleTop = '0px';

	this.SImgSizeX = 0;

	this.SImgSizeY = 0;

	this.popupSizeX = 20;

	this.popupSizey = 20;

	this.positionX = 0;

	this.positionY = 0;

	//Indices

	this.Pop = 0;

	this.SafariImgLoaded = false;

	this.NeedCalcul = false;

	this.LoadingImg = null;

	//Instance manger

	ZoomsInstances.push(this);

	this.CheckCoordsRef = CreateMethodReference(this,"CheckCoords");

	this.MouseMoveRef = CreateMethodReference(this,"MouseMove");

};

Rb_zoom.prototype = {

	//------------------------------------------

	StartLoading : function() {

		this.LoadingImg = document.createElement('IMG');

		this.LoadingImg.src = loadingImg;

		this.LoadingImg.style.position = 'absolute';

		this.LoadingImg.style["opacity"] = .5;

		this.LoadingImg.style["-moz-opacity"] = .5;

		this.LoadingImg.style["-html-opacity"] = .5;

		this.LoadingImg.style["filter"] = "alpha(Opacity=50)";

		this.LoadingImg.style.left = (parseInt(this.SImg.width) / 2 - parseInt(this.LoadingImg.width)/2)+'px';

		this.LoadingImg.style.top = (parseInt(this.SImg.height) / 2 - parseInt(this.LoadingImg.height)/2)+'px';

		this.SImgCont.appendChild(this.LoadingImg);

	},

	InitZoom : function() {

		if(!this.LoadingImg && !this.ZImg.complete && this.SImg.width != 0 && this.SImg.height != 0) this.StartLoading();

		if(Rb_UA == 'safari') {

			if(!this.SafariImgLoaded) {

				Rb_addEventListener(this.ZImg,"load",CreateMethodReference(this,"InitZoom"));

				this.SafariImgLoaded = true;

				return;

			}

		}else {

			if(!this.ZImg.complete || !this.SImg.complete) {

				setTimeout(CreateMethodReference(this,"InitZoom"),100);

				return;

			}

		}



		this.ZImg.style.borderWidth = '0px';

		this.ZImg.style.padding = '0px';

		this.ZImgSizeX = this.ZImg.width;

		this.ZImgSizeY = this.ZImg.height;

		this.SImgSizeX = this.SImg.width;

		this.SImgSizeY = this.SImg.height;



		if(this.ZImgSizeX == 0 || this.ZImgSizeY == 0 || this.SImgSizeX == 0 || this.SImgSizeY == 0) {

			setTimeout(CreateMethodReference(this,"InitZoom"),100);

			return;

		}



		if(Rb_UA == 'opera'||(Rb_UA == 'msie' && !(document.compatMode && 'backcompat'==document.compatMode.toLowerCase()))) {

			this.SImgSizeX -= parseInt(GetStyle(this.SImg,'paddingLeft'));

			this.SImgSizeX -= parseInt(GetStyle(this.SImg,'paddingRight'));

			this.SImgSizeY -= parseInt(GetStyle(this.SImg,'paddingTop'));

			this.SImgSizeY -= parseInt(GetStyle(this.SImg,'paddingBottom'));

		}

		if(this.LoadingImg) {

			this.SImgCont.removeChild(this.LoadingImg);

			this.LoadingImg = null;

		}

		this.SImgCont.style.width = this.SImg.width+'px';

		this.ZImgCont.style.top = '-10000px';



		var r = GetBounds(this.SImg);

		if(!r) {

			this.ZImgCont.style.left = this.SImgSizeX + parseInt(GetStyle(this.SImg,'borderLeftWidth')) + parseInt(GetStyle(this.SImg,'borderRightWidth')) + parseInt(GetStyle(this.SImg,'paddingLeft')) + parseInt(GetStyle(this.SImg,'paddingRight')) + 15 + 'px';

		}

		else {

			this.ZImgCont.style.left = (r['right']-r['left'] + 15)+'px';

		}

		switch(this.Position) {

			case'left':

				this.ZImgCont.style.left = '-'+(15+parseInt(this.ZImgCont.style.width))+'px';

			break;

			case'bottom':

				if(r) {

					this.ZImgContStyleTop = r['bottom']-r['top']+15+'px';

				} else {

					this.ZImgContStyleTop = this.SImg.height+15+'px';

				}

				this.ZImgCont.style.left = '0px';

			break;

			case'top':

				this.ZImgContStyleTop = '-'+(15+parseInt(this.ZImgCont.style.height))+'px';

				this.ZImgCont.style.left = '0px';

			break;

		}

		if(this.Pop) {

			this.RecPopUpDim();

			return;

		}

		this.InitZoomCont();

		this.InitPopUp();

		Rb_addEventListener(window.document,"mousemove",this.CheckCoordsRef);

		Rb_addEventListener(this.SImgCont,"mousemove",this.MouseMoveRef);



	},

	InitZoomCont : function() {

		var ZImgSrc = this.ZImg.src;



		if( this.ZImgSizeY < parseInt(this.ZImgCont.style.height) )

			this.ZImgCont.style.height = this.ZImgSizeY+'px';



		if( this.ZImgSizeX < parseInt(this.ZImgCont.style.width) )

			this.ZImgCont.style.width = this.ZImgSizeX+'px';



		while(this.ZImgCont.firstChild)

			this.ZImgCont.removeChild(this.ZImgCont.firstChild);



		if(Rb_UA == 'msie') {

			var IFrame = document.createElement("IFRAME");

			IFrame.style.left = '0px';

			IFrame.style.top = '0px';

			IFrame.style.position = 'absolute';

			IFrame.src = "javascript:''";

			IFrame.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';

			IFrame.style.width = this.ZImgCont.style.width;

			IFrame.style.height = this.ZImgCont.style.height;

			IFrame.frameBorder = 0;

			this.ZImgCont.appendChild(IFrame);

		}



		var AR = document.createElement("DIV");

		AR.style.overflow = "hidden";

		this.ZImgCont.appendChild(AR);

		this.ZImg = document.createElement("IMG");

		this.ZImg.src = ZImgSrc;

		this.ZImg.style.position = 'relative';

		this.ZImg.style.borderWidth = '0px';

		this.ZImg.style.padding = '0px';

		this.ZImg.style.left = '0px';

		this.ZImg.style.top = '0px';

		AR.appendChild(this.ZImg);



	},

	InitPopUp : function() {

		this.Pop = document.createElement("DIV");

		this.Pop.className = 'RbZoomPop';

		this.Pop.style.zIndex = 10;

		this.Pop.style.visibility = 'hidden';

		this.Pop.style.position = 'absolute';

		this.Pop.style["opacity"] = .5;

		this.Pop.style["-moz-opacity"] = .5;

		this.Pop.style["-html-opacity"] = .5;

		this.Pop.style["filter"] = "alpha(Opacity=50)";

		this.SImgCont.appendChild(this.Pop);

		this.RecPopUpDim();

		this.SImgCont.unselectable="on";

		this.SImgCont.style.MozUserSelect = "none";

		this.SImgCont.onselectstart = function() {return false;};

		this.SImgCont.oncontextmenu = function() {return false;};

	},

	RecPopUpDim : function () { //Cheked

		this.popupSizeX = parseInt(this.ZImgCont.style.width) / ( this.ZImgSizeX / this.SImgSizeX);

		this.popupSizeY = parseInt(this.ZImgCont.style.height) / ( this.ZImgSizeY / this.SImgSizeY);



		if(this.popupSizeX > this.SImgSizeX)

			this.popupSizeX = this.SImgSizeX;



		if(this.popupSizeY > this.SImgSizeY)

		 	this.popupSizeY = this.SImgSizeY;



		this.popupSizeX = Math.round(this.popupSizeX);

		this.popupSizeY = Math.round(this.popupSizeY);

		if(!(document.compatMode&&'backcompat'==document.compatMode.toLowerCase())) {

			var bw = parseInt(GetStyle(this.Pop,'borderLeftWidth'));

			this.Pop.style.width = (this.popupSizeX-2 * bw) + 'px';

			this.Pop.style.height = (this.popupSizeY-2 * bw) + 'px';

		} else {

			this.Pop.style.width = this.popupSizeX+'px';

			this.Pop.style.height = this.popupSizeY+'px';

		}

	},

	CheckCoords : function(El) {

		var r = GetEventBounds(El);

		var x = r['x'];

		var y = r['y'];

		var SmallY = 0;

		var SmallX = 0;

		var Tag = this.SImg;

		while(Tag && Tag.tagName!="BODY" && Tag.tagName != "HTML") {

			SmallY += Tag.offsetTop;

			SmallX += Tag.offsetLeft;

			Tag = Tag.offsetParent;

		}

		if(Rb_UA == 'msie') {

			var r = GetBounds(this.SImg);

			SmallX = r['left'];

			SmallY = r['top'];

		}

		SmallX += parseInt(GetStyle(this.SImg,'borderLeftWidth'));

		SmallY += parseInt(GetStyle(this.SImg,'borderTopWidth'));

		if(Rb_UA != 'msie'||!(document.compatMode&&'backcompat'==document.compatMode.toLowerCase())) {

			SmallX += parseInt(GetStyle(this.SImg,'paddingLeft'));

			SmallY += parseInt(GetStyle(this.SImg,'paddingTop'))

		}

		if(x > parseInt(SmallX + this.SImgSizeX)) {

			this.HideRect();

			return false;

		}

		if(x < parseInt(SmallX)) {

			this.HideRect();

			return false;

		}

		if(y > parseInt(SmallY+this.SImgSizeY)) {

			this.HideRect();

			return false;

		}

		if(y < parseInt(SmallY)) {

			this.HideRect();

			return false;

		}

		if(Rb_UA == 'msie') {

			this.SImgCont.style.zIndex = 1;

		}

		return true	;

	},

	HideRect : function() {

		if(this.Pop) this.Pop.style.visibility = "hidden";

		this.ZImgCont.style.top = '-10000px';

		if(Rb_UA == 'msie') {

			this.SImgCont.style.zIndex = 0;

		}

	},

	MouseMove : function(El) {

		Rb_stopEventPropagation(El);

		for(i=0; i < ZoomsInstances.length; i++)

			if(ZoomsInstances[i] != this)

				ZoomsInstances[i].CheckCoords(El);



		if(this.NeedCalcul) return;

		if(!this.CheckCoords(El)) return;

		this.NeedCalcul = true;



		var SmallImg = this.SImg;

		var SmallX = 0;

		var SmallY = 0;

		if(Rb_UA == 'gecko' || Rb_UA == 'opera' || Rb_UA == 'safari') {

			var Tag = SmallImg;

			while(Tag.tagName!="BODY" && Tag.tagName!="HTML") {

				SmallY += Tag.offsetTop;

				SmallX += Tag.offsetLeft;

				Tag=Tag.offsetParent;

			}

		} else {

			var r = GetBounds(this.SImg);

			SmallX = r['left'];

			SmallY = r['top'];

		}

		SmallX += parseInt(GetStyle(this.SImg,'borderLeftWidth'));

		SmallY += parseInt(GetStyle(this.SImg,'borderTopWidth'));

		if(Rb_UA != 'msie' || !(document.compatMode&&'backcompat'==document.compatMode.toLowerCase())) {

			SmallX += parseInt(GetStyle(this.SImg,'paddingLeft'));

			SmallY += parseInt(GetStyle(this.SImg,'paddingTop'));

		}

		var r = GetEventBounds(El);

		var x = r['x'];

		var y = r['y'];

		this.positionX = x - SmallX;

		this.positionY = y - SmallY;



		if( (this.positionX+this.popupSizeX/2) >= this.SImgSizeX)

			this.positionX=this.SImgSizeX-this.popupSizeX/2;



		if( (this.positionY + this.popupSizeY / 2 ) >= this.SImgSizeY)

			this.positionY = this.SImgSizeY-this.popupSizeY/2;



		if((this.positionX - this.popupSizeX / 2 ) <= 0)

			this.positionX = this.popupSizeX / 2;



		if((this.positionY - this.popupSizeY / 2 ) <= 0)

			this.positionY = this.popupSizeY / 2;

		//setTimeout(CreateMethodReference(this,"ShowRect"),10);

		this.ShowRect();

	},

	ShowRect : function() {

		var Pleft = this.positionX - this.popupSizeX / 2;

		var Ptop = this.positionY - this.popupSizeY / 2;

		var PerX = Pleft * (this.ZImgSizeX / this.SImgSizeX);

		var PerY = Ptop * (this.ZImgSizeY / this.SImgSizeY);



		if(document.documentElement.dir == 'rtl')

			PerX = (this.positionX + this.popupSizeX/ 2-this.SImgSizeX ) * (this.ZImgSizeX/this.SImgSizeX);

		Pleft += parseInt(GetStyle(this.SImg,'borderLeftWidth'));

		Ptop += parseInt(GetStyle(this.SImg,'borderTopWidth'));

		if(Rb_UA != 'msie'||!(document.compatMode&&'backcompat'==document.compatMode.toLowerCase())) {

			Pleft += parseInt(GetStyle(this.SImg,'paddingLeft'));

			Ptop += parseInt(GetStyle(this.SImg,'paddingTop'));

		}



		this.Pop.style.left = Pleft+'px';

		this.Pop.style.top = Ptop+'px';



		this.Pop.style.visibility = "visible";

		if((this.ZImgSizeX - PerX) < parseInt(this.ZImgCont.style.width))

			PerX = this.ZImgSizeX - parseInt(this.ZImgCont.style.width);



		if(this.ZImgSizeY > (parseInt(this.ZImgCont.style.height))) {

			if((this.ZImgSizeY-PerY) < (parseInt(this.ZImgCont.style.height))) {

				PerY = this.ZImgSizeY - parseInt(this.ZImgCont.style.height);

			}

		}

		this.ZImg.style.left = (-PerX)+'px';

		this.ZImg.style.top = (-PerY)+'px';

		this.ZImgCont.style.top = this.ZImgContStyleTop;

		this.ZImgCont.style.display = 'block';

		this.ZImgCont.style.visibility = 'visible';

		this.ZImg.style.display = 'block';

		this.ZImg.style.visibility = 'visible';

		this.NeedCalcul = false;

	},

	Fade : function(Mode,Obj,CallBack) {

		var Opacity = (Mode == "Out") ? 100 : 0;

		var Speed = (thumbFadeSpeed > 10 || thumbFadeSpeed <= 0) ? 2 : thumbFadeSpeed;

		if(Rb_UA == 'msie') Speed += 7;

		setTimeout(function(){

			if(Mode == "Out") Opacity = ((Opacity - Speed) < 0) ? 0 : (Opacity - Speed);

			else  Opacity  = ((Opacity + Speed) > 100) ? 100 : (Opacity + Speed);

			with (Obj.style) {

				opacity = Opacity / 100;

				MozOpacity = Opacity / 100;

				KhtmlOpacity = Opacity / 100;

				filter = 'alpha(opacity=' + Opacity + ')';

			}

			if ((Opacity > 0 && Mode == "Out") || (Opacity < 100 && Mode == "In")) setTimeout(arguments.callee, 1);

			else {

				if(CallBack != null) CallBack.call(this);

			}

		}, 1);

	},

	ChangeZoom : function(NewZImgSrc, NewSImgSrc) {

		if(!this.Pop) return;

		//Stop events and remove squar

		Rb_removeEventListener(window.document,"mousemove", this.CheckCoordsRef);

		Rb_removeEventListener(this.SImgCont,"mousemove", this.MouseMoveRef);

		this.SImgCont.removeChild(this.Pop);

		this.Pop = null;

		//Update Zoom Image

		var NewZImg = document.createElement("IMG");

		NewZImg.id= this.ZImg.id;

		NewZImg.src = NewZImgSrc;

		this.ZImg.parentNode.replaceChild(NewZImg,this.ZImg);

		this.ZImg = NewZImg;

		this.ZImg.style.position = 'relative';

		//Update Small Image

		var NewSImg = document.createElement("IMG");

		//Reset Opacity

		with (NewSImg.style) {

			opacity = 0;

			MozOpacity = 0;

			KhtmlOpacity = 0;

			filter = 'alpha(opacity=0)';

		}

		NewSImg.id= this.SImg.id;

		NewSImg.src = NewSImgSrc;

		var Instance = this;

		this.Fade('Out',this.SImg,function(){

			Instance.SImg.parentNode.replaceChild(NewSImg,Instance.SImg);

			Instance.Fade('In',NewSImg,null);

			Instance.SImg = NewSImg;

			Instance.SImg.style.position = 'relative';

			//Init The zoom

			Instance.SafariLoad = false;

			Instance.NeedCalcul = false;

			Instance.InitZoom();

			Instance.SImgCont.href = NewZImgSrc;

		});//end Fade

	}

};

//----------------------------------------------------------------

//                Events Handlers Functions

//----------------------------------------------------------------

function Rb_addEventListener(Obj,Event,Listener) {

	if(Rb_UA == 'gecko'|| Rb_UA == 'opera'||Rb_UA == 'safari') {

		try {

			Obj.addEventListener(Event,Listener,false);

		} catch(e) {}

	} else if(Rb_UA == 'msie') {

		Obj.attachEvent("on"+Event,Listener);

	}

};

function Rb_removeEventListener(Obj,Event,Listener) {

	if(Rb_UA == 'gecko'|| Rb_UA == 'opera'||Rb_UA == 'safari') {

		Obj.removeEventListener(Event,Listener,false);

	} else if(Rb_UA == 'msie') {

		Obj.detachEvent("on"+Event,Listener);

	}

};

function Rb_stopEventPropagation(El) {

	if(Rb_UA == 'gecko'|| Rb_UA == 'opera'||Rb_UA == 'safari') {

		El.cancelBubble=true;

		El.preventDefault();

		El.stopPropagation();

	} else if(Rb_UA == 'msie') {

		window.event.cancelBubble = true;

	}

};

//----------------------------------------------------------------

//                Onload Functions

//----------------------------------------------------------------

function BasName(Path) {

	return unescape(Path).replace(/^.*[\/\\]/g, '')

};

function InitThumbs(Obj, BlockID, CurImgID) {

	var Ele = $rz(BlockID).getElementsByTagName("A");

	for(var i=0;i < Ele.length; i++) {

		if(Ele[i].rel != '' && Ele[i].href != '') {

			Ele[i].className = (BasName(Ele[i].rel) == BasName($rz(CurImgID).src)) ? 'Current' : '';

			//Load Images in the background

			var Img = document.createElement("IMG");

			Img.src = Ele[i].rel;

			Img.style.position = 'absolute';

			Img.style.left = '-10000px';

			Img.style.top = '-10000px';

			document.body.appendChild(Img);

			Img = document.createElement("IMG");

			Img.src = Ele[i].href;

			Img.style.position = 'absolute';

			Img.style.left = '-10000px';

			Img.style.top = '-10000px';

			document.body.appendChild(Img);

			Rb_addEventListener(Ele[i],"click",function(e) {

					var e = e ? e : window.event;

   					var Target = e.target != null ? e.target : e.srcElement;

					if(Target.nodeName == 'IMG') Target = Target.parentNode;

					Obj["ChangeZoom"].call(Obj,Target.href, Target.rel);

					for(var j=0;j < Ele.length; j++)

						Ele[j].removeAttribute("class");

					Target.className = 'Current';

					Target.style.outline = '0';

					if(Rb_UA == 'msie') this.blur();

					Rb_stopEventPropagation(e);

					return false;

				}

			);//end Rb_addEventListener

		}

	}

};

function FindZooms() {

	var Ele = window.document.getElementsByTagName("A");

	for(var i=0;i < Ele.length; i++) {

		if(Ele[i].className == "RbZoom") {

		   //Detect the real first child (Fixe FF Probleme)

			var FirstChild = Ele[i].childNodes[0];

			var j = 1;

			while(FirstChild.nodeType != 1) FirstChild = Ele[i].childNodes[j++];



			if(FirstChild.nodeName != "IMG") {

				alert('Invalid Zoom Object !');

				continue;

			}



			var RandID = Math.round(Math.random()*1000000);

			Rb_addEventListener(Ele[i],"click",function(event) {

					if(Rb_UA == 'msie') this.blur();

					Rb_stopEventPropagation(event);

					return false;

				}

			);//end Rb_addEventListener

			Ele[i].id = 'RbZoom_' + RandID;

			Ele[i].style.position = "relative";

			//Detect Position

			Re = new RegExp(/position(\s+)?:(\s+)?(\w+)/i);

			Matches = Re.exec(Ele[i].rel);

			var Position = 'right';

			if(Matches) {

				switch(Matches[3]) {

					case'left':

						Position = 'left';

					break;

					case'bottom':

						Position = 'bottom';

					break;

					case'top':

						Position = 'top';

					break;

				}

			}

			FirstChild.id = "SImg_" + RandID;//Small Image ID

			//Create Zoom Container

			var ZoomCont = document.createElement("DIV");

			ZoomCont.id = "ZCont_" + RandID;

			ZoomCont.style.width = zoomAreaWidth;

			ZoomCont.style.height = zoomAreaHeight;

			ZoomCont.style.overflow = 'hidden';

			ZoomCont.className = 'RbZoomImageCont';

			ZoomCont.style.zIndex = 100;

			ZoomCont.style.visibility = 'hidden';

			ZoomCont.style.position = 'absolute';

			ZoomCont.style.top = '-10000px';

			ZoomCont.style.left = '-10000px';

			//Create Zoom Image

			var ZoomImg = document.createElement("IMG");

			ZoomImg.id = "ZImg_" + RandID;

			ZoomImg.src = Ele[i].href;

			ZoomCont.appendChild(ZoomImg);

			Ele[i].appendChild(ZoomCont);



			var Zoom = new Rb_zoom('RbZoom_' + RandID, "SImg_" + RandID, "ZCont_" + RandID, "ZImg_" + RandID,Position);

			Zoom.InitZoom();



			//Thumbs Block Detection

			Re = new RegExp(/thumbs(\s+)?:(\s+)?(\w+)/i);

			Matches = Re.exec(Ele[i].rel);

			if(Matches != null && $rz(Matches[3])) InitThumbs(Zoom, Matches[3] , "SImg_" + RandID);

		}

	}

};

if(Rb_UA == 'msie') {

	try{

		document.execCommand("BackgroundImageCache",false,true);

	} catch(e){};

}



Rb_addEventListener(window,"load",FindZooms);