function addClick(id){
    var xhr = getXMLHttpRequest(); // Pour récupérer un objet XMLHTTPRequest
    // -- bordel habituel (readyState == 4, etc, etc.)
    xhr.open('GET', 'click.php?id=' + id, true);
    xhr.send(null);
}

function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}

function displayRowClass(tableId,rowClass,Nb){
  var table = document.getElementById(tableId);
  var display = 'none';
  var ClassName = rowClass + Nb;
  for(i in table.rows){
    row = table.rows[i];
    if(row.className == ClassName){
      if(row.style.display == 'none'){
        /**Test si c'est IE ou pas*/
        display = document.all != undefined ? 'block' : 'table-row';
      } else {
        display = 'none';
      }
      row.style.display = display;
    }
    /*
    if(rowClass == 'child'){
      if(row.idName == ClassName){
        row.style.display = 'none'; 
      }
    }*/
  }
}

function swapImg(swap){
  obj=document.getElementById(swap);
  obj.src=!(obj.src==img_minus)? img_minus : img_plus;  
}