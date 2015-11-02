moveto=function(url){
	    $("body").fadeOut(300);
		top.location=url;
}



addproduct =function(){
	$('html, body').animate({
	scrollTop: 0
	}, 1000);

	var taxes;
	$('.req').removeClass('error');
	if($('#prod_title').val()==''){
		$('#prod_title').addClass('error');
	}	
	if($('#prod_price').val()==''){
		$('#prod_price').addClass('error');
	}	
	if($('#prod_qty').val()==''){
		$('#prod_qty').addClass('error');
	}	
	jQuery.each($('.sometax:checked'), function() {
		 taxes=taxes+','+$(this).val();
	});
		if($('.req').hasClass('error')){	
		}else{
			$.ajax({
			   type: "POST",
			   url: "inc/addprod.php",
			   data: "action=add&title="+$('#prod_title').val()+"&description="+$('#prod_description').val()+"&price="+$('#prod_price').val()+"&qty="+$('#prod_qty').val()+"&taxes="+taxes,
			   success: function(msg){
					$('#prod_qty').val(1);$('#prod_price').val('');$('#prod_title').val('');$('#prod_description').val('');
					$('#ajaxreturn').html(msg);
			   }
			 });
		}
	return false;
}

addtax =function(){
	$('.req').removeClass('error');
	if($('#tax_name').val()==''){
		$('#tax_name').addClass('error');
	}	
	if($('#tax_value').val()==''){
		$('#tax_value').addClass('error');
	}	
			if ($('#default:checked').val() !== undefined) {
				def=1;
			}else{
				def=0;
			}
			
 		if($('.req').hasClass('error')){	
		}else{
			$.ajax({
			   type: "POST",
			   url: "inc/addtax.php",
			   data: "action=add&name="+$('#tax_name').val()+"&value="+$('#tax_value').val()+"&default="+def,
			   success: function(msg){
					$('#tax_name').val('');$('#tax_value').val('');$('#default').removeAttr('checked');
					$('#ajaxresponse').html(msg);
			   }
			 });
		} 
	return false;
}

edit2tax =function(id){
	$('.req2').removeClass('error');
	if($('#name2').val()==''){
		$('#name2').addClass('error');
	}	
	if($('#value2').val()==''){
		$('#value2').addClass('error');
	}	
 		if($('.req2').hasClass('error')){	
		}else{
			if ($('#default2:checked').val() !== undefined) {
				def=1;
			}else{
				def=0;
			}
			$.ajax({
			   type: "POST",
			   url: "inc/addtax.php",
			   data: "action=update&id="+id+"&name="+$('#name2').val()+"&value="+$('#value2').val()+"&default="+def,
			   success: function(msg){
					$('#ajaxresponse').html(msg);
			   }
			 });
		} 
	return false;
}

deltax = function(id){
if(confirm('Are you sure you want to delete this Tax?')){
			$.ajax({
			   type: "POST",
			   url: "inc/addtax.php",
			   data: "action=delete&id="+id,
			   success: function(msg){
					$('#ajaxresponse').html(msg);
			   }
			 });
}			 
			 return false;
}

delpay = function(id){
if(confirm('Are you sure you want to delete this Payment?')){
			$.ajax({
			   type: "POST",
			   url: "inc/addpayment.php",
			   data: "action=delete&id="+id,
			   success: function(msg){
					$('#ajaxresponse').html(msg);
			   }
			 });
}			 
			 return false;
}

edittax = function(id){
			$.ajax({
			   type: "POST",
			   url: "inc/addtax.php",
			   data: "edit="+id,
			   success: function(msg){
					$('#ajaxresponse').html(msg);
			   }
			 });			 
			 return false;
}


refresh_prods =function(){
			$.ajax({
			   type: "POST",
			   url: "inc/addprod.php",
			   data: "action=refresh",
			   success: function(msg){
					$('#ajaxreturn').html(msg);
			   }
			 });
}

deleteprod =function(id){
			$.ajax({
			   type: "POST",
			   url: "inc/addprod.php",
			   data: "action=delete&id="+id,
			   success: function(msg){
					$('#ajaxreturn').html(msg);
			   }
			 });
}

update_prod =function(id,rule){
			$.ajax({
			   type: "POST",
			   url: "inc/addprod.php",
			   data: "action=update&rule="+rule+"&id="+id,
			   success: function(msg){
					$('#ajaxreturn').html(msg);
			   }
			 });
}

function dump(arr,level) {
var dumped_text = "";
if(!level) level = 0;

//The padding given at the beginning of the line.
var level_padding = "";
for(var j=0;j<level+1;j++) level_padding += "    ";

if(typeof(arr) == 'object') { //Array/Hashes/Objects
 for(var item in arr) {
  var value = arr[item];
 
  if(typeof(value) == 'object') { //If it is an array,
   dumped_text += level_padding + "'" + item + "' ...\n";
   dumped_text += dump(value,level+1);
  } else {
   dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
  }
 }
} else { //Stings/Chars/Numbers etc.
 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
}
return dumped_text;
} 