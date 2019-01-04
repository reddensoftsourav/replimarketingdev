/* Image Map Pro */

/* Floor Plan */

add_action( 'wp_ajax_return_plan_shortcode_via_ajax', 'return_plan_shortcode_via_ajax' );
add_action( 'wp_ajax_nopriv_return_plan_shortcode_via_ajax', 'return_plan_shortcode_via_ajax' );
function return_plan_shortcode_via_ajax(){

	$options = get_option( 'image-map-pro-wordpress-admin-options' );
	$saves = $options['saves'];

	$shapename = $_POST['shapeName'];

	foreach($saves as $key => $value){

		if( $value['meta']['shortcode'] ==  $shapename){
			$shapeId = $key;
		}

	}

	$save = $saves[$shapeId];
	$str = $save[json];
	$str = preg_replace('/\\\"/',"\"", $str);

	echo $str;
	
	exit();
}

// Floor Availability as per API Call

add_action( 'wp_ajax_return_plan_availability_via_ajax', 'return_plan_availability_via_ajax' );
add_action( 'wp_ajax_nopriv_return_plan_availability_via_ajax', 'return_plan_availability_via_ajax' );
function return_plan_availability_via_ajax(){

	$options = get_option( 'image-map-pro-wordpress-admin-options' );
	$saves = $options['saves'];

	$shapename = $_POST['shapeName'];

	foreach($saves as $key => $value){

		if( $value['meta']['shortcode'] ==  $shapename){
			$shapeId = $key;
		}

	}

	$clickedfloorvalue = substr($shapename, 9);

	$response = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&apitoken=OTc2ODI%3d-ypOsYE8hSPU%3d&propertyCode=%20p0562827');

	$responses = json_decode($response,true);
	$availablefloor = array();
	$count = 0;
	foreach($responses as $response){
		$ApartmentName = $response['ApartmentName'];
		$floorname = substr($ApartmentName, 0,2);

		if($clickedfloorvalue == $floorname){
			$availablefloor[$count] = $response;
			$count++;
		}
		
	}
	
	$str = '';
	$str .= count($availablefloor).' Available Units';
	if( count($availablefloor) > 0 ){
		$str .= '<div id="unit-list" data-units-available="'.count($availablefloor).'">';
		foreach($availablefloor as $avlblefloor){
		$str .= '<label id="'.$avlblefloor[PropertyId].'" class="unit-search-result unit-item" data-unit-id="'.$avlblefloor[PropertyId].'">';
		$str .= '<div class="unit-search-image">';
		$str .= '<img src="http://skyhousebuckhead.com/wp-content/themes/skyhouse_buckhead_full/assets/floorplans/png/floorplan'.$avlblefloor[FloorplanName].'.png" class="attachment-unit-search size-unit-search wp-post-image" alt="">
		</div>';
		$str .= '<div class="unit-search-content">';
		$str .= '<strong>Home Information</strong>';
		$str .= '<br>';
		$str .= 'Home'. $avlblefloor[ApartmentName];
		$str .= '<br>';
		$str .= $avlblefloor[Beds].' Bedroom, '.$avlblefloor[Baths].' Bath';
		$str .= '<br>';
		$str .= $avlblefloor[SQFT].'square feet';
		$str .= '<br>';
		$str .= 'Floor Plan: '.$avlblefloor[FloorplanName];
		$str .= '<br>';
		$str .= '<span class="unit-price">$'.number_format($avlblefloor[MinimumRent], 2).'</span>';
		$str .= '<div class="availability">';
		$str .= '<strong>Availability</strong>';
		$str .= '<br>'.$avlblefloor[AvailableDate];
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</label>';
	    }
		$str .= '</div>';
		
	}

	echo $str;

	exit();
}

// Floor Availability Selected Data

add_action( 'wp_ajax_return_plan_availability_selected_via_ajax', 'return_plan_availability_selected_via_ajax' );
add_action( 'wp_ajax_nopriv_return_plan_availability_selected_via_ajax', 'return_plan_availability_selected_via_ajax' );
function return_plan_availability_selected_via_ajax(){

	$options = get_option( 'image-map-pro-wordpress-admin-options' );
	$saves = $options['saves'];

	$shapename = $_POST['shapeName'];

	foreach($saves as $key => $value){

		if( $value['meta']['shortcode'] ==  $shapename){
			$shapeId = $key;
		}

	}

	$clickedfloorvalue = substr($shapename, 9);

	$response = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&apitoken=OTc2ODI%3d-ypOsYE8hSPU%3d&propertyCode=%20p0562827');

	$responses = json_decode($response,true);
	$availablefloor = array();
	$count = 0;
	foreach($responses as $response){
		$ApartmentName = $response['ApartmentName'];
		$floorname = substr($ApartmentName, 0,2);

		if($clickedfloorvalue == $floorname){
			$availablefloor[$count] = 'floor'.$clickedfloorvalue.'-flat'.$ApartmentName;
			$count++;
		}
		
	}

	echo $array = implode(",", $availablefloor);

	exit();
	
}

// Floor Availability Selected Data

add_action( 'wp_ajax_return_tooltip_via_ajax', 'return_tooltip_via_ajax' );
add_action( 'wp_ajax_nopriv_return_tooltip_via_ajax', 'return_tooltip_via_ajax' );
function return_tooltip_via_ajax(){

	$shapename = substr($_POST['shapeName'], 12);

	$response = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&apitoken=OTc2ODI%3d-ypOsYE8hSPU%3d&propertyCode=%20p0562827');

	$responses = json_decode($response,true);
	$availablefloor = array();

	foreach($responses as $response){
		$ApartmentName = $response['ApartmentName'];
		if($ApartmentName == $shapename){


			/*print '<pre>';
			print_r($response[ApartmentName]);
			print '</pre>';*/
			$str = '<p><strong class="unit">Unit '.$response[ApartmentName].'</strong></p>';
			$str .= '<p><strong class="avlbl">Available '.$response[AvailableDate].'</strong></p>';
			$str .= '<p>'.$response[Beds].' Bed / '.$response[Baths].' Bath </p>';
			$str .= '<p>'.$response[SQFT].' square feet</p>';
			$str .= '<p> $'.number_format($response[MinimumRent], 2).' / Month</p>';

			echo $str;

			continue;
		}
		
	}

	exit();
}


/////////////////// Floor Planwise Search ////////////////////////
// Floor Availability as per API Call

add_action( 'wp_ajax_return_floor_availability_via_ajax', 'return_floor_availability_via_ajax' );
add_action( 'wp_ajax_nopriv_return_floor_availability_via_ajax', 'return_floor_availability_via_ajax' );
function return_floor_availability_via_ajax(){

	$floorplan = $_POST['floorplan'];


	$response = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&apitoken=OTc2ODI%3d-ypOsYE8hSPU%3d&propertyCode=%20p0562827');

	$responses = json_decode($response,true);
	$availablefloor = array();
	$count = 0;
	foreach($responses as $response){
		$ApartmentBed = $response['Beds'];

		if($ApartmentBed == $floorplan){
			$availablefloor[$count] = $response;
			$count++;
		}
		
	}
	
	$str = '';
	$str .= count($availablefloor).' Available Units';
	if( count($availablefloor) > 0 ){
		$str .= '<div id="unit-list" data-units-available="'.count($availablefloor).'">';
		foreach($availablefloor as $avlblefloor){
		$str .= '<label id="'.$avlblefloor[PropertyId].'" class="unit-search-result unit-item" data-unit-id="'.$avlblefloor[PropertyId].'">';
		$str .= '<div class="unit-search-image">';
		$str .= '<img src="http://skyhousebuckhead.com/wp-content/themes/skyhouse_buckhead_full/assets/floorplans/png/floorplan'.$avlblefloor[FloorplanName].'.png" class="attachment-unit-search size-unit-search wp-post-image" alt="">
		</div>';
		$str .= '<div class="unit-search-content">';
		$str .= '<strong>Home Information</strong>';
		$str .= '<br>';
		$str .= 'Home'. $avlblefloor[ApartmentName];
		$str .= '<br>';
		$str .= $avlblefloor[Beds].' Bedroom, '.$avlblefloor[Baths].' Bath';
		$str .= '<br>';
		$str .= $avlblefloor[SQFT].'square feet';
		$str .= '<br>';
		$str .= 'Floor Plan: '.$avlblefloor[FloorplanName];
		$str .= '<br>';
		$str .= '<span class="unit-price">$'.number_format($avlblefloor[MinimumRent], 2).'</span>';
		$str .= '<div class="availability">';
		$str .= '<strong>Availability</strong>';
		$str .= '<br>'.$avlblefloor[AvailableDate];
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</label>';
	    }
		$str .= '</div>';
		
	}

	echo $str;
	exit();
} 

/////////////////// Pricewise Search ////////////////////////
// Floor Availability as per API Call

add_action( 'wp_ajax_return_price_availability_via_ajax', 'return_price_availability_via_ajax' );
add_action( 'wp_ajax_nopriv_return_price_availability_via_ajax', 'return_price_availability_via_ajax' );
function return_price_availability_via_ajax(){

	if($price !== 'none'){

	$price = explode('-',$_POST['price']);

	$response = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&apitoken=OTc2ODI%3d-ypOsYE8hSPU%3d&propertyCode=%20p0562827');

	$responses = json_decode($response,true);
	$availablefloor = array();
	$count = 0;
	foreach($responses as $response){
		$ApartmentRent = $response['MinimumRent'];

		if(isset($price[1])){
			$minprice = number_format((float)$price[0], 2, '.', '');
			$maxprice = number_format((float)$price[1], 2, '.', '');

			if($ApartmentRent >= $minprice && $ApartmentRent <= $maxprice){
				$availablefloor[$count] = $response;
				$count++;
			}

		}else{
			$maxprice = number_format((float)$price[0], 2, '.', '');

			if($ApartmentRent >= $maxprice){
				$availablefloor[$count] = $response;
				$count++;
			}
		}
		
	}
	
	$str = '';
	$str .= count($availablefloor).' Available Units';
	if( count($availablefloor) > 0 ){
		$str .= '<div id="unit-list" data-units-available="'.count($availablefloor).'">';
		foreach($availablefloor as $avlblefloor){
		$str .= '<label id="'.$avlblefloor[PropertyId].'" class="unit-search-result unit-item" data-unit-id="'.$avlblefloor[PropertyId].'">';
		$str .= '<div class="unit-search-image">';
		$str .= '<img src="http://skyhousebuckhead.com/wp-content/themes/skyhouse_buckhead_full/assets/floorplans/png/floorplan'.$avlblefloor[FloorplanName].'.png" class="attachment-unit-search size-unit-search wp-post-image" alt="">
		</div>';
		$str .= '<div class="unit-search-content">';
		$str .= '<strong>Home Information</strong>';
		$str .= '<br>';
		$str .= 'Home'. $avlblefloor[ApartmentName];
		$str .= '<br>';
		$str .= $avlblefloor[Beds].' Bedroom, '.$avlblefloor[Baths].' Bath';
		$str .= '<br>';
		$str .= $avlblefloor[SQFT].'square feet';
		$str .= '<br>';
		$str .= 'Floor Plan: '.$avlblefloor[FloorplanName];
		$str .= '<br>';
		$str .= '<span class="unit-price">$'.number_format($avlblefloor[MinimumRent], 2).'</span>';
		$str .= '<div class="availability">';
		$str .= '<strong>Availability</strong>';
		$str .= '<br>'.$avlblefloor[AvailableDate];
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</label>';
	    }
		$str .= '</div>';
		
	}
	
	}else{
		$str =='';
	}

	echo $str;
	exit();
} 
