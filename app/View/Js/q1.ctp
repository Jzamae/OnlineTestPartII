<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>
$(document).ready(function(){

	$("#add_item_button").click(function(){	
		
		$.ajax({
            dataType: "html",
            type: "POST",
            evalScripts: true,
            url: 'q1',
            data: ({action:'add_empty_value'}),
            success: function (data){
            	
            	var r=$.parseJSON(data);
            	var row_id = r['id'];
				var description_name="data["+row_id+"][description]";
				var quantity_name="data["+row_id+"][quantity]";
				var unit_price_name="data["+row_id+"][unit_price]";

				$("table tbody").append('<tr id='+row_id+'><td></td><td name='+description_name+'></td><td name='+quantity_name+'></td><td name='+unit_price_name+'></td></tr>');
            }
        });

	});

	$('table').on("click", "td", function(event) {
	 var value=$(this).text();
	 var td_name=$(this).attr('name');
	 var is_contains_input=$(this).find('input').length;
	 var is_contains_textarea=$(this).find('textarea').length;
	 var tr_id=$(this).closest('tr').attr('id');

	 if(td_name.indexOf("description") >= 0){
	 	if(is_contains_textarea==0){
	 		$(this).text('');
	 		$(this).append('<textarea name='+td_name+' class="m-wrap  description required" rows="2" >'+value+'</textarea>');
	 	}
	 	if(is_contains_textarea==1 && !$(event.target).is('textarea')){
	 		value=$('textarea[name="'+td_name+'"]').val();
	 		$(this).find('textarea').remove();
	 		$(this).text(value);
	 		
	 		var data=({action:'update',id:tr_id,field:'description',field_value:value});
	 		update_ajax(data);
	 	}
	 	
	 }

	 if(td_name.indexOf("quantity") >= 0){
	 	if(is_contains_input==0){
	 		$(this).text('');
	 		$(this).append('<input name='+td_name+' value='+value+'>');
	 	}
	 	if(is_contains_input==1 && !$(event.target).is('input')){
	 		value=$('input[name="'+td_name+'"]').val();
	 		$(this).find('input').remove();
	 		$(this).text(value);

	 		var data=({action:'update',id:tr_id,field:'quantity',field_value:value});
	 		update_ajax(data);
	 	}
	 }

	 if(td_name.indexOf("unit_price") >= 0){
	 	if(is_contains_input==0){
	 		$(this).text('');
	 		$(this).append('<input name='+td_name+' value='+value+'>');
	 	}
	 	if(is_contains_input==1 && !$(event.target).is('input')){
	 		value=$('input[name="'+td_name+'"]').val();
	 		$(this).find('input').remove();
	 		$(this).text(value);

	 		var data=({action:'update',id:tr_id,field:'unit_price',field_value:value});
	 		update_ajax(data);

	 	}
	 }
   	});

   	function update_ajax(data){
   		$.ajax({
	            dataType: "html",
	            type: "POST",
	            evalScripts: true,
	            url: 'q1',
	            data: data,
	            success: function (data){
	            }
	        });
   	}
	
});
</script>
<?php $this->end();?>

