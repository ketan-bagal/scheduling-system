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

function confirmAction (id,table,pkname) {
    var did;
    var check=confirm('Are you sure you wish to remove the record from '+table+' ? \nPlease check first related data is deleted, if you fail to delete the record. ');
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

$('tr.data').each(function() {
	var id = $(this).attr('value');
	var table = document.getElementById('current_table').value;
  var pkname = document.getElementById('current_table_pkname').value;
	$(this).append('<a href=javascript:confirmAction("'+id+'","'+table+'","'+pkname+'")><button class="btn_delete" >delete</button></a>');
});

$('tr.data').mouseover(function() {

	$(this).find('.btn_delete').css('display', 'inline');
}).mouseout(function() {

	$(this).find('.btn_delete').css('display', 'none');
});
