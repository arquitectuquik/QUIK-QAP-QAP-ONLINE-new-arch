//StatusBox for javascript - requires Bootstrap and jQuery.
//copyright AeZ - 2016.

//	val: 	the aspect and behaviour of the box, acepted values: success,warning,loading,info.
//	val2:	null so far.
//	val3:	the custom text, default content on null.
//	val4:	wheter the box is going to be added or removed, acepted values: add,remove. Add on null.
//	val5:	custom timer to make the box disappear, 3 seconds on null.

function statusBox(val,val2,val3,val4,val5) {
	
	//check for jQuery
	if(!window.jQuery) {
		alert('jQuery no parece est�r instalado correctamente, por favor verifique su instalaci�n de jQuery antes de uesar statusBox.');
		throw "jQuery has not been found.";
	}
	
	//check for Bootstrap
	if (!typeof $().modal == 'function') {
		alert('Bootstrap no parece est�r instalado correctamente, por favor verifique su instalaci�n de Bootstrap antes de uesar statusBox.');
		throw "Bootstrap has not been found.";	
	}	
	
	//define the main div css
	var cssClass = [{
		"position":"fixed",
		"right":"0",
		"bottom":"0",
		"z_index":"9999",
		"margin":"10px 10px 10px 10px",
		"width":"300px"
	}];
	
	//check if the main div already exists, if not, create it and assign it's id, css and item counter
	if (document.getElementById('statusBox')) {
		var mainDiv = document.getElementById('statusBox');
		var isMainDivOnUse = true;
	} else {
		var mainDiv = document.createElement("div");
			mainDiv.setAttribute('id','statusBox');
			mainDiv.setAttribute('style','position:'+cssClass[0].position+';right:'+cssClass[0].right+';bottom:'+cssClass[0].bottom+';z-index:'+cssClass[0].z_index+';margin:'+cssClass[0].margin+';width:'+cssClass[0].width+';');
			mainDiv.dataset.activeItems = 0;
		var isMainDivOnUse = false;	
		
		document.getElementsByTagName('body')[0].appendChild(mainDiv);
		
	}
	
	//create the inner divs
	var loadingBox = document.createElement('div');
	var successBox = document.createElement('div');
	var warningBox = document.createElement('div');
	var infoBox = document.createElement('div');
	
	//assign the id,css and active items to the inner divs.
		loadingBox.setAttribute('id','statusBox_loadingBox');
		successBox.setAttribute('id','statusBox_successBox');
		warningBox.setAttribute('id','statusBox_warningBox');
		infoBox.setAttribute('id','statusBox_infoBox');
		
		loadingBox.setAttribute('class','col-xs-12');
		successBox.setAttribute('class','col-xs-12');
		warningBox.setAttribute('class','col-xs-12');
		infoBox.setAttribute('class','col-xs-12');
		
		loadingBox.dataset.activeItems = 0;
		successBox.dataset.activeItems = 0;
		warningBox.dataset.activeItems = 0;
		infoBox.dataset.activeItems = 0;
	
	//check if the requested innerdiv is already on use
	if (document.getElementById('statusBox_'+val.toLowerCase()+'Box')) {
		var requestedInnerDiv = document.getElementById('statusBox_'+val.toLowerCase()+'Box');	
	} else {
		//define which inner div is needed and create it's desired content, and whether or not the content must disappear after the timeout event.
		switch(val.toLowerCase()) {
			case'loading':
				var requestedInnerDiv = loadingBox;
				var innerDivCssClass = 'alert-info';
					
				//verify if there's any custom text to introduce into the box's text.
				if (val3.toLowerCase() == 'null') {
					innerDivContentText = "Cargando...";
				} else {
					innerDivContentText = val3;
				}
					
				var removeAfterTimeOut = false;
				
			break;
			case'success':
				var requestedInnerDiv = successBox;
				var innerDivCssClass = 'alert-success';
					
				//verify if there's any custom text to introduce into the box's text.
				if (val3.toLowerCase() == 'null') {
					innerDivContentText = "Se ha completado la tarea exitosamente.";
				} else {
					innerDivContentText = val3;
				}
				
				var removeAfterTimeOut = true;
				
			break;
			case'warning':
				var requestedInnerDiv = warningBox;
				var innerDivContent = document.createElement("div");
				var innerDivCssClass = 'alert-warning';
					
				//verify if there's any custom text to introduce into the box's text.
				if (val3.toLowerCase() == 'null') {
					innerDivContentText = "La tarea no se ha completado exitosamente.";
				} else {
					innerDivContentText = val3;
				}
				
				var removeAfterTimeOut = true;
				
			break;
			case'info':
				var requestedInnerDiv = infoBox;
				var innerDivContent = document.createElement("div");
				var innerDivCssClass = 'alert-info';
					
				//verify if there's any custom text to introduce into the box's text.
				if (val3.toLowerCase() == 'null') {
					innerDivContentText = "Se ha encontrado una excepci�n, por favor comuniquese con el administrador de la aplicaci�n.";
				} else {
					innerDivContentText = val3;
				}
				
				var removeAfterTimeOut = true;
							
			break;
		}
		
		mainDiv.appendChild(requestedInnerDiv);
		
	}		
	
	//create and assign the attributes to the inner div content
	var innerDivContent = document.createElement("div");
		innerDivContent.setAttribute('class','alert '+innerDivCssClass+' col-xs-12');
		innerDivContent.setAttribute('style','font-weight: bold; box-shadow: 2px 2px 2px #333333;');
		innerDivContent.setAttribute('role','alert');
		innerDivContent.innerHTML = innerDivContentText;	
	
	//add or remove the items
	if (val4.toLowerCase() == 'remove') {
		$(requestedInnerDiv).find('div').remove();
		
		var innerDivItemCounter = parseInt($(requestedInnerDiv).attr('data-active-items'),10);
		var mainDivItemCounter = parseInt($(mainDiv).attr('data-active-items'),10);
		
			mainDivItemCounter = (mainDivItemCounter - 1);
			innerDivItemCounter = (innerDivItemCounter - 1);
		
		//verify if there are any items inside the inner div, if not, remove it.
		if (innerDivItemCounter == 0) {
			$(mainDiv).find(requestedInnerDiv).remove();
		} else {
			$(requestedInnerDiv).attr('data-active-items',innerDivItemCounter);			
		}		
		
		//verify if there are any items inside the main div, if not, remove it.
		if (mainDivItemCounter == 0) {
			$(mainDiv).remove();
		} else {
			$(mainDiv).attr('data-active-items',mainDivItemCounter);			
		}

	} else {			
		
		var innerDivItemCounter = parseInt($(requestedInnerDiv).attr('data-active-items'),10);
		var mainDivItemCounter = parseInt($(mainDiv).attr('data-active-items'),10);
		
			mainDivItemCounter = (mainDivItemCounter + 1);
			innerDivItemCounter = (innerDivItemCounter + 1);		
		
		//special case for loading type so it doesn't add more than one loading box.
		if (val.toLowerCase() == 'loading' && innerDivItemCounter > 1) {
			//
		} else {
			requestedInnerDiv.appendChild(innerDivContent);				
		}
			
		
		$(requestedInnerDiv).attr('data-active-items',innerDivItemCounter);
		$(mainDiv).attr('data-active-items',mainDivItemCounter);				
		
		//assign the timeout event if needed
		if (removeAfterTimeOut) {
			autoTimeOut(innerDivContent,val5,mainDivItemCounter,innerDivItemCounter);
		}				
		
	}
	
	//creating the timeout event
	function autoTimeOut(item,timer,itemRemoved1,itemRemoved2) {
		
		if (timer.toLowerCase() == 'null') {
			var timeValue = 5000;
		} else {
			var timeValue = timer;
		}
		
		setTimeout(function() {
			$(item).remove();
			itemRemoved1 = (itemRemoved1 - 1);
			itemRemoved2 = (itemRemoved2 - 1);

			//verify if there are any items inside the inner div, if not, remove it.
			if (itemRemoved2 == 0) {
				$(mainDiv).find(requestedInnerDiv).remove();
			} else {
				$(requestedInnerDiv).attr('data-active-items',itemRemoved2);			
			}		
			
			//verify if there are any items inside the main div, if not, remove it.
			if (itemRemoved1 == 0) {
				$(mainDiv).remove();
			} else {
				$(mainDiv).attr('data-active-items',itemRemoved1);	
			}
			
		},timeValue);
	}
}