$(function() {
	$('.js-spa-modal-city').on('click.modal', function(e) {

		function CitySelect(initElement) {
			var that = this,
				$modalWrap = $('#'+$(initElement).attr('data-spa-target')),
				$modalWindow = $modalWrap.find('.spa-modal-city-content'),
				$searchBlock = $modalWrap.find('.spa-modal-city-search'),
				$input = $modalWrap.find('.spa-modal-city-search__input'),
				$dropdown = $modalWrap.find('.spa-modal-city-search__dropdown'),
				$defaultLoc = $modalWrap.find('.spa-modal-city-list__text'),
				$button = $modalWrap.find('.spa-modal-city-button'),
				$close = $modalWrap.find('.spa-modal-city-close'),
				$messanger = $modalWrap.find('.spa-modal-city-error'),
				$notFound = $modalWrap.find('.spa-modal-city-search__not-found'),
				clsDropdownElems = 'spa-modal-city-search__item',
				lastRequestStr = '',
				$elemsWhereInsertName = $('[data-spa-location="name"]');


			this.init = function() {
				$('body').css('padding-right', '17px');
				$('body').css('overflow-y', 'hidden');
				$modalWrap.show();

				// for default cities list
				$defaultLoc.on('click.select', function() {
					$input.data('city-id', $(this).data('city-id'));
					$input.val($(this).text());
					
					that.save();
					that.close();
				});

				// for button
				$button.on('click.select', function() {
					var $city = that.findCity($input.val());

					if($city) {
						$input.data('city-id', $city.data('city-id'));
						$input.val($city.text());
					}

					that.save();
				});

				// for search
				$input.keyup(function() {
					if($(this).val() == '') {
						$dropdown.hide();
						return false;
					}
					$messanger.slideUp(200);
					that.search();
				}).focus(function() {
					var $items = $dropdown.children();
					for(var i = 0; i < $items.length; i++) {
						if($items.eq(i).css('display') == 'block' && $input.val() != '') {
							$dropdown.show();
							return false;
						}
					}
				});

				$modalWindow.on('click.closeDropdown', function(e) {
					if(!$searchBlock.is(e.target) && $searchBlock.has(e.target).length === 0) {
						$dropdown.hide();
					}
				});

				setTimeout(function() {
					$(document).on('click.closeModal', function(e) {

						if($close.is(e.target) || (!$modalWindow.is(e.target) && $modalWindow.has(e.target).length === 0)) {
							that.close();
						}
					});
				},0);

			}

			this.close = function() {
				$('body').css('padding-right', '');
				$('body').css('overflow-y', '');
				$(document).off('click.closeModal');
				$modalWrap.hide();
				$dropdown.hide();
				$input.val('');
			}

			this.search = function(str) {
				var data = '';

				if(that.isNarrowingQuery($input.val()) != -1 && lastRequestStr != '') {
					that.filterList($input.val());
					return false;
				}

				data += 'action=find';
				data += '&search_str=' + $input.val();
				lastRequestStr = $input.val();

				$.post(
					BX.message('SPA_PATH_SELECT_CITY'),
					data,
					function(data) {
						$dropdown.children('.'+clsDropdownElems).remove();

						if(data['status'] == 'success') {
							$messanger.slideUp(200);
							$notFound.hide();

							for(var i = 0; i < data['cities'].length; i++) {
								$dropdown.append(
									'<div class="'+clsDropdownElems+'" data-city-id="'+data['cities'][i]['ID']+'">'+data['cities'][i]['NAME_RU']+'</div>'
								);
							}

							// for dropdown list elements
							$('.'+clsDropdownElems).on('click.select', function() {
								$input.data('city-id', $(this).data('city-id'));
								$input.val($(this).text());
								$('.'+clsDropdownElems).hide();
								$dropdown.hide();
							});

						} else if(data['status'] == 'not_found') {
							if($notFound.is(':hidden'))
								$notFound.show();
						}

						$dropdown.show();
					},
					'json'
				);

			}

			this.save = function() {
				var data = '';

				data += 'action=set';
				data += '&city_id=' + $input.data('city-id');
				data += '&city_name=' + $input.val();

				$.post(
					BX.message('SPA_PATH_SELECT_CITY'),
					data,
					function(data) {

						if(data['status'] == 'success') {
							$messanger.slideUp(200);

							$elemsWhereInsertName.text(data['city_name']);

							$(document).trigger('click.closeModal');

						} else if(data['status'] == 'error') {

							$messanger.text(data['message']).slideDown(100);
						}

					},
					'json'
				);
			}

			this.findCity = function(str) {
				$items = $('.'+clsDropdownElems+':visible');
				str = str.toLowerCase();

				for(var i = 0; i < $items.length; i++) {
					var itemName = $items.eq(i).text().toLowerCase();

					if(itemName == str) return $($items.eq(i));
				}

				return false;
			}

			this.isNarrowingQuery = function(str) {
				var currStr = str.toLowerCase(),
					oldStr = lastRequestStr.toLowerCase();

				return currStr.indexOf(oldStr);
			}

			this.filterList = function(str) {
				$items = $('.'+clsDropdownElems);
				str = str.toLowerCase();

				var areItems = false;

				for(var i = 0; i < $items.length; i++) {
					var itemName = $items.eq(i).text().toLowerCase();

					if(itemName.indexOf(str) != -1) {
						$items.eq(i).show();
						if(!areItems) areItems = true;
					} else {
						$items.eq(i).hide();
					}
				}

				if(!areItems) {
					$notFound.show();
				} else {
					$notFound.hide();
				}

				$dropdown.show();
			}

		}

		var controller = new CitySelect(this);
		controller.init();

		e.preventDefault();
	});
});