<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) ?>


<div class="filterHor">
    <div class="filterHor__title">Для подбора <?=$arResult['PAGE_NAME']?> выберите марку, модель, год выпуска или кузов</div>
    <div class="filterHor__list">
        <div class="filterHor__item">
            <select id="marka_avto" class="simple-select jq-filter-marka">
            	<option value="0">Марка</option>
            	<?foreach($arResult["MARKA_AVTO"] as $item):?>
                	<option value="<?=strtolower($item)?>"><?=$item?></option>
                <?endforeach?>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="model_avto" class="simple-select jq-filter-model">
            	<option value="0">Модель</option>
                <?foreach($arResult["MODEL_AVTO"] as $item):?>
                	<option 
                		value="<?=strtolower($item["VALUE"])?>" 
                		data-parrent="<?=strtolower($item["PARRENT"])?>"
                		style="display: none;">
                			<?=$item["VALUE"]?>
                	</option>
                <?endforeach?>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="god_vypuska" class="simple-select jq-filter-link">
                <option value="0">Год</option>
                <?foreach($arResult["GOD_VYPUSKA"] as $item):?>
                	<option 
                		class="link_filter"
                		value="<?=strtolower($item["VALUE"])?>" 
                		data-parrent="<?=strtolower($item["PARRENT"])?>" 
                		data-link="<?=$item["LINK"]?>"
                		style="display: none;">
                			<?=$item["VALUE"]?>
                	</option>
                <?endforeach?>
            </select>
        </div>
        <div class="filterHor__item">
            <select id="kuzov" class="simple-select jq-filter-link">
                <option value="0">Кузов</option>
                <?foreach($arResult["KUZOV"] as $item):?>
                	<option 
	                	value="<?=strtolower($item["VALUE"])?>" 
	                	data-parrent="<?=strtolower($item["PARRENT"])?>" 
	                	data-link="<?=$item["LINK"]?>"
	                	style="display: none;">
                			<?=$item["VALUE"]?>
                	</option>
                <?endforeach?>
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
		
		$.each(selected,function(key,val){
			$('#'+key).find('option[value="'+val+'"]').attr('selected', 'selected');
			
			if(key == "marka_avto")
			{
				$('.jq-filter-model').find('[data-parrent="'+val+'"]').show();
			}
			
			if(key == "model_avto")
			{
				$('.jq-filter-link').find('[data-parrent="'+val+'"]').show();
			}
		});
		
		
		
		$('.jq-filter-model').on('change', function(e) {
			var model = $(this).find(':selected').val();
			
			if(model == 0)
			{
				$('.jq-filter-link').find('option[value="0"]').attr('selected', 'selected');
			}
			else
			{
				$('.jq-filter-link').find('option').removeAttr('selected');
				$('.jq-filter-link').find('option[value="0"]').attr('selected', 'selected');
				$('.jq-filter-link').find('option').hide();
				$('.jq-filter-link').find('[data-parrent="'+model+'"]').show();
			}
		})
		
		$('.jq-filter-marka').on('change', function(e) {
			var marka = $(this).find(':selected').val();
			
			if(marka == 0)
			{
				$('.simple-select').find('option').removeAttr('selected');
				$('.simple-select').find('option[value="0"]').attr('selected', 'selected');
				$('.simple-select').find('option').hide();
				$(this).find('option').show();
				link = link_def;
			}
			else
			{
				$('.jq-filter-model').find('option').removeAttr('selected');
				$('.jq-filter-model').find('option[value="0"]').attr('selected', 'selected');
				
				$('.jq-filter-link').find('option').removeAttr('selected');
				$('.jq-filter-link').find('option[value="0"]').attr('selected', 'selected');
				$('.jq-filter-link').find('option').hide();
				
				$('.jq-filter-model').find('option').hide();
				$('.jq-filter-model').find('[data-parrent="'+marka+'"]').show();
			}
		})
		
		var link_def = '<?=$arResult['DEF_PAGE']?>',
			link = '<?=$arResult['DEF_PAGE']?>';
		
		$('.jq-filter-link').on('change', function(e) {
			link = $(this).find(':selected').data('link');
			
			if($(this).attr('id') == "kuzov")
			{
				$('#god_vypuska').find('option').removeAttr('selected');
				$('#god_vypuska').find('option[value="0"]').attr('selected', 'selected');
			}
			
			if($(this).attr('id') == "god_vypuska")
			{
				$('#kuzov').find('option').removeAttr('selected');
				$('#kuzov').find('option[value="0"]').attr('selected', 'selected');
			}
		})
		
		$('.filterHor__btn').on('click', function(e) {
			location.href=link;
		})
	});
	
</script>










