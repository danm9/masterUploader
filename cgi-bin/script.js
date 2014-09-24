$(document).ready(function(){

var $table_name = '';
var $field_index = 0;
var $max_fields = 1;


$("#table_selector").change(function(){
	var $selected = $("#table_selector option:selected").text();
	$table_name = $selected;
	$(".field_sel").remove()
	$("#add_field_button").remove()
	$("#remove_field_button").remove()
	$.ajax({
		url: "http://brockman-srv.mbb.sfu.ca/~B_Team_iMac/dan/webtools/masterUploader/cgi-bin/genFieldSelect.php",
		type: "POST",
		data: { selected_table: $selected, index: 1 }
	})
	.done(function(html){
		html += "<div class=\"spacer\"></div><div id=\"add_field_button\">+</div><div id=\"remove_field_button\">-</div>";
		$("#field_header").after(html);
		$field_index = 1;
		$max_fields = $("#field_selector_1 option").length;
		$("#add_field_button").click(function(){
			if ($field_index == $max_fields) {
				alert("All fields used!");
				return false;
			}
			toAdd = "<select class=\"field_sel\" id=\"field_selector_" + ($field_index + 1) + "\" form=\"mainform\">"
			$("#field_selector_" + $field_index + " option:not(:selected)").each(function(){
				toAdd += "<option value=\"" + $(this).text() + "\">" + $(this).text() + "</option>";
			});
			toAdd += "</select>";
			$("#field_selector_" + $field_index).after(toAdd);
			$field_index ++;
		});
		$("#remove_field_button").click(function(){
			if ($field_index == 1) {
				alert("Must have at least one field!");
				return false;
			}
			$("#field_selector_" + ($field_index)).remove();
			$field_index --;
		});
	});
});

$("#mainform").submit(function(e){
	e.preventDefault();
	var $i = 0;
	var $url = 'http://brockman-srv.mbb.sfu.ca/~B_Team_iMac/dan/webtools/masterUploader/cgi-bin/showPOST.php';
	var $fields = { textArea: $('#maininput').val(), table_name: $("#table_selector option:selected").val(), field_index: $field_index };
	$(".field_sel option:selected").each(function(){
		$fields["data_"+$i] = $(this).val();
		$i ++;
	});
	$.post($url, $fields)
	.done(function(data){
		var w = window.open()
		$(w.document.body).html("<HTML>" + data + "</HTML>");
	});
});

});
