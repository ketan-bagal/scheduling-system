
$("#tableform").on({
    mouseenter: function () {
		$(this).append('<a><button class="btn_delete" >delete</button></a>');
		$(this).find('.btn_delete').css('display', 'inline');
		$(this).find('.btn_delete').css('left', '550px');
        $("p").css("background","yellow");
    },
    mouseleave: function () {
        $("p").css("background","green");
		$(this).find('.btn_delete').remove();
    }
}, "tr.extracourse");
$('#tableform').on('click', '.btn_delete', function(){
   var rowindex = $(this).parents("tr").index();
   var semester = $(this).parents("tr").attr("class").split(" ")[0];
   var courseindex = $(this).parents("tr").children().eq(0).text();
   var numofcourse = $('.'+semester).length;
   var selectnamevalue = $('.'+semester).eq(courseindex-1).children().eq(1).find("select").attr("name");
    var check=confirm('Are you sure you wish to remove the record from  ?');
    if(check){
		document.getElementById("tableform").deleteRow(rowindex);
		var semesfirst = document.getElementsByClassName(semester+" first")
		var thtag = semesfirst[0].getElementsByTagName("th");
		var num = thtag[0].getAttribute("rowspan");
		var addnum = --num;
		thtag[0].setAttribute("rowspan",addnum);
		thtag[1].setAttribute("rowspan",addnum);
		
		if(numofcourse!=courseindex){
			var total = numofcourse-courseindex;
			var count = 1;
			for(count;count<= total;count++){
				$('.'+semester).eq(courseindex-1).children().eq(0).text(courseindex);
				 $('.'+semester).eq(courseindex-1).children().eq(1).find("select").attr("name",selectnamevalue++);
				courseindex++;
			}
			
		}
		}
});