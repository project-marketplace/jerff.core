<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="spa-modal-select-city" class="spa-modal-city" style="display: none;">
	<div class="spa-modal-city-wrap">
		<div class="spa-modal-city-content">
			<div class="spa-modal-city-close" title="Закрыть"></div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 hidden-xs">
						<div class="spa-modal-city-marker"></div>
					</div>
					<div class="col-sm-9 col-xs-12">
						<div class="spa-modal-city-title">Укажите ваш<br/>город доставки</div>
						<div class="spa-modal-city-error"></div>
						<div class="spa-modal-city-search">
							<input
								type="text"
								class="spa-modal-city-search__input"
								name="city"
								value=""
								data-city-id=""
								placeholder="Название города"
								autocomplete="off"
							>
							<div class="spa-modal-city-search__dropdown" style="display: none;">
								<div class="spa-modal-city-search__not-found" style="display: none;">Совпадений не найдено</div>
							</div>
						</div>

						<div class="spa-modal-city-list">

		                	<?if(is_array($arResult['DEFAULT_CITIES'])):?>

							<div class="spa-modal-city-list__title">Например:</div>

		                    <?foreach($arResult['DEFAULT_CITIES'] as $arCity):?>
		                    <div class="spa-modal-city-list__item">
		                    	<span class="spa-modal-city-list__text" data-city-id="<?=$arCity['ID']?>"><?=$arCity['NAME']?></span>
		                    </div>
		                    <?endforeach;?>

		                    <?endif;?>

			            </div>
						
						<div class="spa-modal-city-button-wrap">
			            	<div class="spa-modal-city-button">Сохранить</div>
			            </div>
		            </div>
	            </div>
	        </div>
		</div>
	</div>
</div>

<script>
	BX.message({
		SPA_PATH_SELECT_CITY: '<?=$templateFolder?>/ajax.php'
	});
</script>
