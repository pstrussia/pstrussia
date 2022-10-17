<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) ?>


<div class="filterHor" id="filterHor">
    <div class="filterHor__title">Для подбора <?=$arResult['PAGE_NAME']?> выберите марку, модель, год выпуска или кузов</div>
    <div class="filterHor__list">
        <div class="filterHor__item">
            <select id="marka_avto" class="simple-select jq-filter-marka">
            	<option value="0">Марка</option>
            	<?foreach($arResult["ITEMS"]["MARKA_AVTO"] as $item):?>
                	<option 
	                	value="<?=$item["THIS"]["VALUE"]?>" 
	                	data-code="<?=$item["THIS"]["CODE"]?>" 
	                	data-prop_code="<?=$item["THIS"]["PROP_CODE"]?>"">
                			<?=$item["THIS"]["TEXT"]?>
                	</option>
                <?endforeach?>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="model_avto" class="simple-select jq-filter-model">
            	<option value="0">Модель</option>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="god_vypuska" class="simple-select jq-filter-link">
                <option value="0">Год</option>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="kuzov" class="simple-select jq-filter-link">
                <option value="0">Кузов</option>
            </select>
        </div>
        
        <div class="filterHor__item">
	        <div class="filterHor__btn">Применить</div>
	    </div>
        
    </div>
</div> 

<script>
	$(document).ready(function () {	
		
		var selected = '<?=json_encode($arResult["SELECTED"]);?>';
		selected = JSON.parse(selected);
		
		var items = '<?=json_encode($arResult["ITEMS"]);?>';
		items = JSON.parse(items);
		
		var section_code = '<?=$arParams["SECTION_CODE"]?>';
		
		console.log(items);
		
		function ajax()
		{
			var data = {};
			
			$("#filterHor option:selected").each(function (index, el){
				if($(el).val() != 0)
				{
					data[$(el).data("prop_code")] = $(el).val();
				}
			});
			console.log(data);
			
			BX.ajax.runComponentAction("diva:filter_model", "makeSmartUrl", {
			    mode: "class",
			    data: {"data": data, "section_code":section_code}
			}).then(function (response) {
			    window.location.href = response["data"];
			});
			
		}
		
		function dvs_clear(selector)
		{
			$(selector).each(function() {
				if($(this).val() != 0)
			    	$(this).remove();
			});
		}
		
		function dvs_add(selector, val, selected)
		{
			$(selector).append($('<option>', {
			    value: val["THIS"]["VALUE"],
			    text: val["THIS"]["TEXT"],
			}));
			
			$(selector+' option:last').attr('data-code', val["THIS"]["CODE"]);
			$(selector+'  option:last').attr('data-parrent', val["THIS"]["PARRENT"]);
			$(selector+' option:last').attr('data-prop_code', val["THIS"]["PROP_CODE"]);
			
			if(selected)
			{
				$(selector+' option:last').attr('selected', "selected");
			}
		}
		
		$('select').on('change', function(e) {
			var id = $(this).attr("id"),
				val = $(this).val(),
				parrent = $(this).find(':selected').data("parrent");
				code = $(this).find(':selected').data("code");
			
			if(id == "marka_avto")
			{
				if(val != 0)
				{
					dvs_clear("#model_avto option, #god_vypuska option, #kuzov option");
					
					$.each(items["MARKA_AVTO"][code]["CHILD"],function(key,val)
					{
						dvs_add('#model_avto', val);
					});
				}
				else
				{
					dvs_clear("#model_avto option, #god_vypuska option, #kuzov option");
				}
			}
			
			if(id == "model_avto")
			{
				if(val != 0)
				{
					dvs_clear("#god_vypuska option, #kuzov option");
					
					$.each(items["MARKA_AVTO"][parrent]["CHILD"][code]["CHILD"]["GOD_VYPUSKA"],function(key,val)
					{
						dvs_add('#god_vypuska', val);
					});
					
					$.each(items["MARKA_AVTO"][parrent]["CHILD"][code]["CHILD"]["KUZOV"],function(key,val)
					{
						dvs_add('#kuzov', val);
					});
				}
				else
				{
					dvs_clear("#god_vypuska option, #kuzov option");
				}
			}
			
			if(id == "god_vypuska")
			{
				$('#kuzov').find('option').removeAttr('selected');
				$('#kuzov').find('option[value="0"]').attr('selected', 'selected');
			}
			
			if(id == "kuzov")
			{
				$('#god_vypuska').find('option').removeAttr('selected');
				$('#god_vypuska').find('option[value="0"]').attr('selected', 'selected');
			}
			
		})
		
		$.each(selected,function(key,val){
			if(key == "marka_avto")
			{
				if(items["MARKA_AVTO"][val])
				{
					$.each(items["MARKA_AVTO"][val]["CHILD"],function(key,val1)
					{
						var selected = false;
						dvs_add('#model_avto', val1, selected);
					});
				}
			}

			if(key == "model_avto")
			{
				$.each(items["MARKA_AVTO"][selected["marka_avto"]]["CHILD"][val]["CHILD"]["GOD_VYPUSKA"],function(key,val1)
				{
					var selected = false;
					dvs_add('#god_vypuska', val1, selected);
				});
				$.each(items["MARKA_AVTO"][selected["marka_avto"]]["CHILD"][val]["CHILD"]["KUZOV"],function(key,val1)
				{
					var selected = false;
					dvs_add('#kuzov', val1, selected);
				});
			}
			
			$('#'+key).find('option[value="'+val+'"]').attr('selected', 'selected');
		});

		$('.filterHor__btn').on('click', function(e) {
			ajax();
		})
	});
	
</script>










