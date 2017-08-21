window.onload=function(){
		var pos = document.getElementById("student_resit").offsetTop;
		var head = document.getElementById("student_resit").getElementsByTagName("thead");
		var eft = document.getElementById("student_resit").offsetLeft;
		var tablewidth = document.getElementById("student_resit").offsetWidth;
		var cellwidth = document.getElementsByTagName("td")[0].offsetWidth;
		document.getElementsByTagName("th")[0].style.width = cellwidth+"px";
		var cln = head[0].cloneNode(true);
		document.getElementById("student_resit").appendChild(cln);
		cln.classList.add("ccc");
		cln.style.width=tablewidth+"px";
		window.onscroll=function(){
				var a = eft-document.body.scrollLeft;
				b(pos,cln,a);
				
				
			};	
	};
		function b(postop,cln,posleft){
			
			
			if(document.body.scrollTop>postop){
				
				cln.style.left= posleft+"px";
				cln.classList.add("sticky");
			}else{
				cln.classList.remove("sticky");
				
			}
		}