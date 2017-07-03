<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	

	if(!CModule::IncludeModule('Sale')) {
	    return false;
	}

	use \Bitrix\Sale\Location;

	$json = [];

    $json['module'] = 12;



	$action = $_POST['action'];

	if($action == 'find') {
		$search_str = $_POST['search_str'];

		// Select of cities
		$res = Location\LocationTable::getList(array(
			'filter' => array(
				'=NAME.LANGUAGE_ID' => LANGUAGE_ID,
				'=TYPE.NAME.LANGUAGE_ID' => LANGUAGE_ID,
				'=TYPE_NAME_RU' => 'Город',
				'%NAME_RU' => $search_str
			),
			'order' => array(
				'NAME_RU',
				'SORT' => 'asc'
			),
			'select' => array(
				'ID',
				'NAME_RU' => 'NAME.NAME',
				'TYPE_NAME_RU' => 'TYPE.NAME.NAME'
			)
		));

		while($city = $res->fetch())
			$json['cities'][] = $city;

		$json['status'] = ($json['cities']) ? 'success' : 'not_found';
		
	} else if($action == 'set') {
		$city_id = $_POST['city_id'];
		$city_name = $_POST['city_name'];

		$city = Location\LocationTable::getList(array(
		    'filter' => array(
		    	'=ID' => $city_id,
		        '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
		        '=TYPE.NAME.LANGUAGE_ID' => LANGUAGE_ID,
		        '=NAME_RU' => $city_name
		    ),
		    'select' => array(
		        'ID',
		        'NAME_RU' => 'NAME.NAME'
		    )
		))->fetch();

		if($city) {
			$_SESSION['LOCATION']['CURRENT_CITY'] = $city['NAME_RU'];
			$_SESSION['LOCATION']['ID'] = $city['ID'];

			$json['status'] = 'success';
			$json['city_id'] = $city['ID'];
			$json['city_name'] = $city['NAME_RU'];
		} else {
			$json['status'] = 'error';
			$json['message'] = 'Города нет в базе';
		}
	}

	echo json_encode($json);

?>