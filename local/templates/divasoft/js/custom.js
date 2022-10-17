$(document).on("keyup", "#dadata-inn, #soa-property-10", function()
{
	var inn = $(this).val();
	
	var id = $(this).attr("id");
	
	if(inn.length > 3)
	{
		$.post(
            "/local/ajax/dadata.php",
            {
            	"inn": inn,
            	"id": id
            },
            function(result)
            {
            	$(".suggestion-dropdown__item").not(".suggestion-zero").remove();
            	
            	if(result.status.value)
            	{
            		$.each(result.data, function(index, val) { 
						var clone = $(".suggestion-zero").clone(true);
						$(clone).removeClass("suggestion-zero");
						$(clone).attr("data-info", JSON.stringify(val["value"]));
						$(clone).find(".suggestion-dropdown__address").html(val["name"]);
						$(clone).find(".suggestion-dropdown__other").html(val["text"]);
						$(clone).appendTo(".suggestion-dropdown__list");
						$(clone).show();
					});
					
            		$(".suggestion-dropdown").show();
            	}
            	else
            	{
            		var clone = $(".suggestion-zero").clone(true);
					$(clone).removeClass("suggestion-zero");
					$(clone).find(".suggestion-dropdown__address").html("Ничего не найдено!");
					$(clone).find(".suggestion-dropdown__other").html("Введите корректный ИНН");
					$(clone).appendTo(".suggestion-dropdown__list");
					$(clone).show();
					
					$(".suggestion-dropdown").show(); 
            	}
                   
            },
            "json"
        );
		
		
	}
	else
	{
		$(".suggestion-dropdown__item").not(".suggestion-zero").remove();
	}
});

$(document).on("click", ".suggestion-dropdown__item", function()
{
	var info = jQuery.parseJSON($(this).attr("data-info"));
	
	if($("#dadata-inn"))
		$("#dadata-inn").val(info["bxu-uf_inn"]);
	
	$(".suggestion-dropdown").hide();
	$.each(info, function(index, val) {
		$(".reg-ur-form").find('[name="'+index+'"]').val(val);
		$(".reg-ur-form").find('[name="'+index+'"]').parent().addClass("in-focus");
	});
	//debugger
});