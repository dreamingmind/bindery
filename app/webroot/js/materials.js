// JavaScript Document

window.onload = initpage;

function initpage() {
	initProductChange();
	initBindingChange();
	//initClothOver();
	initMaterialAlert();
	initListNodes();
}

function initProductChange() {
	var clickPoints = document.getElementById('products').getElementsByTagName('input');
	var i = 0;
	while (i<clickPoints.length) {
		clickPoints[i++].onchange = doProductChange;
	}
}

function doProductChange() {
	document.getElementById('case').className = this.value;
}

function initBindingChange() {
	var clickPoints = document.getElementById('binding').getElementsByTagName('input');
	var i = 0;
	while (i<clickPoints.length) {
		clickPoints[i++].onchange = doBindingChange;
	}
}

function doBindingChange() {
	var productDiv = document.getElementById('case');
	if (this.value == 'full') {
		boards = document.getElementById('boards');
		productDiv.removeChild(boards);
		document.getElementById('spine').setAttribute('class','full');
		
		document.getElementById('boardsLabel').innerHTML="";
	} else {
		document.getElementById('spine').setAttribute('class','quarter');
		newDiv = document.createElement('div');
		newDiv.setAttribute('id','boards');
		productDiv.appendChild(newDiv);
	}
}
		
function initClothOver() {
	var li = document.getElementById('boardsM').getElementsByTagName('li');
	var i = 0;
	while (i<li.length) {
		li[i++].onmouseover = doClothOver;
	}
}

function doMaterialOver(target,fname,title) {
	var div = document.getElementById(target);
	if (div) {
		//var fname = this.src;
		//fname = fname.replace("thumbsize","fullsize");
		div.setAttribute("style","background-image:url("+fname+")");
	}
	label = (target=='spine') ? "Leather: " : "Cloth: ";
	document.getElementById(target+'Label').innerHTML = label + '<br /><strong>&nbsp;'+ title + '</strong>';
}

function displayFromSix(clickNode) {
	var divWorking = clickNode.parentNode.parentNode; //navigation = <li> --> <ul> --> <div>
	var targetDiv = (divWorking.id == 'spineM') ? document.getElementById('spine') : document.getElementById('boards')
	;
	targetDiv.setAttribute("style","background-image:url("+imagePath+'/'+clickNode.self.fn +'.jpg)');
	label = (targetDiv.id=='spine') ? "Leather: " : "Cloth: ";
	document.getElementById(targetDiv.id+'Label').innerHTML = label + '<br /><strong>&nbsp;'+ clickNode.self.ti + '</strong>';
}

function doMaterialClick(clickNode) {
	
	var divWorking = clickNode.parentNode.parentNode; //navigation = <li> --> <ul> --> <div>
	var sourceArray = (divWorking.id == 'spineM') ? leatherIn : clothIn ;
	var startNode = null; 
	var ulNew = null;
	var ulOld = null;
	var i = clickNode.id.substring(1,clickNode.id.length);
	var idNow = clickNode.id.substring(1,clickNode.id.length);
	var originalId = clickNode.id;
	
	while (idNow != 5) {
		startNode = (idNow > 5) ? divWorking.getElementsByTagName('ul')[0].firstChild.nxt : divWorking.getElementsByTagName('ul')[0].firstChild.prev;
		
		ulNew = assembleDisplayList(sourceArray,startNode);
		ulOld = divWorking.getElementsByTagName('ul')[0];
		divWorking.replaceChild(ulNew,ulOld);
		
		// Behavior modification processes
		idNow = clickNode.id.substring(1,clickNode.id.length);
		if (document.getElementById('step').checked) {
			alert('step-pause')
		}
		var loop = parseInt(document.getElementById('delay').value);
		loop = (loop == NaN || loop < 0) ? 0 : (loop > 10) ? 10 : loop;
		for (i=0; i<loop; i++) {
			document.getElementById(originalId);
			delay();
		}
		/*Run-away loop protection
		r = confirm("decide idNow (" + idNow + ") > 5");
		if (!r) { return false; }*/
	}
	displayFromSix(clickNode);
}

function delay() {
		for (var x=0; x<9999999; x++) {
			y='something';
		}
}
function initMaterialAlert() {
	var p;
	var caveat = document.getElementById('caveat');
	if (leatherAlert!="") {
		p = document.createElement('p');
		t = document.createTextNode(leatherAlert);
		p.appendChild(t);
		caveat.appendChild(p);
	}
	if (clothAlert!="") {
		p = document.createElement('p');
		t = document.createTextNode(clothAlert);
		p.appendChild(t);
		caveat.appendChild(p);
	}
}

function initListNodes() {
	buildListNodes(leatherIn,'l');
	buildListNodes(clothIn,'c');
	
	ulNew = assembleDisplayList(leatherIn,leatherIn[lStart].node);
	document.getElementById('spineM').appendChild(ulNew);
	displayFromSix(document.getElementById('l5'));


	ulNew = assembleDisplayList(clothIn,clothIn[cStart].node);
	document.getElementById('boardsM').appendChild(ulNew);
	displayFromSix(document.getElementById('c5'));
}

function assembleDisplayList(source,startNode) {
	var ulNode = document.createElement('ul');
	var j = 0;
	while (j < 11) {
		if (j==5) {
			startNode.setAttribute('class','displayed');
		} else {
			startNode.removeAttribute('class');
		}
		startNode.setAttribute('id',startNode.id.charAt(0)+j);
		ulNode.appendChild(startNode);
		j++;
		startNode = startNode.nxt;
	}
	return ulNode;
}
		

function buildListNodes(listData,id) {
	//<li id="1" title="Chestnut" style="background-image:url(_i/thumbsize/bone.jpg)">7</li>
	var target = "";
	for (var i = 0; i<listData.length; i++) {
		// construct this <li> node and store it in the array
		li = document.createElement('li');
		li.setAttribute('id',id+listData[i].id);
		li.setAttribute('title',listData[i].ti)
		li.setAttribute('style','background-image:url('+thumbPath+'/'+listData[i].fn+'.jpg)');
		target = (id=='c') ? 'boards' : 'spine' ;
		li.setAttribute('onclick','doMaterialClick(this)');
		//li.setAttribute('onclick','doMaterialOver(\''+target+'\',\''+imagePath+'/'+listData[i].fn+'.jpg\',\''+listData[i].ti+'\')');
		li.appendChild(document.createTextNode(parseInt(i)+1));
		listData[i].node = li;
	}
	for (var i = 0; i<listData.length; i++) {
		// store pointers to the previouse and next <li>s
		iNext = (i == listData.length-1) ? 0 : i+1;
		iPrev = (i == 0) ? listData.length-1 : i-1;
		listData[i].node.prev = listData[iPrev].node;
		listData[i].node.nxt = listData[iNext].node;
		listData[i].node.self = listData[i];
	}
	
}