$('tr.data').mouseover(function() {

	$(this).find('.button_delete').css('display', 'inline');
}).mouseout(function() {

	$(this).find('.button_delete').css('display', 'none');
});


function confirmAction (id,table,pkname) {
    var did;
    var check=confirm('Are you sure you wish to remove the record '+id+' from '+table+' ?');
             if (check) {
               xmlhttp1 = new XMLHttpRequest();
               xmlhttp1.open("GET","../php_script/check_delete.php?id="+id+"&table="+table+"&pkname="+pkname,false);
               xmlhttp1.send();
               did=xmlhttp1.responseText;
			   
			   
            if (did == "ture") {
               reset();
               alertify.set({ delay: 10000 });
         			alertify.success("Delete successfully!");
              $('#tables_refresh').empty().load(window.location.href + '#student_resit');
        
            }else if (did == "false") {
					
               reset();
         			alertify.error("Fail to delete!");
					

             }
          }
}

function reset () {
  $("#toggleCSS").attr("href", "../themes/alertify.default.css");
  alertify.set({
    labels : {
      ok     : "OK",
      cancel : "Cancel"
    },
    delay : 5000,
    buttonReverse : false,
    buttonFocus   : "ok"
  });
}