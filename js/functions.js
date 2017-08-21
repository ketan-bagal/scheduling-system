function highlightEdit(editableObj) {
	$(editableObj).css("background","#FFF");
}

function saveInlineEdit(editableObj,column,id,table) {
	// no change change made then return false
	if($(editableObj).attr('data-old-value') === editableObj.innerHTML)
	return false;
	// send ajax to update value
	$(editableObj).css("background","#FFF url(../pic/loader.gif) no-repeat right");
	$.ajax({
		url: "saveInlineEdit.php",
		cache: false,
		data:'&column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&table='+table,
		success: function(response)  {
			console.log(response);
			// set updated value as old value
			$(editableObj).attr('data-old-value',editableObj.innerHTML);
			$(editableObj).css("background","#FDFDFD");
		}
   });
}

function filter(filterValue,location,filterKey) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
          if (filterValue == "all") {
            window.location.href = "./admin_edit"+location+".php";
          }else
          {
            window.location.href = "./admin_edit"+location+".php?"+filterKey+"id=" + filterValue;
          }
	}
