<link rel='stylesheet' id='image-map-pro-dist-css-css'  href='<?php echo get_home_url() ?>/wp-content/plugins/image-map-pro-wordpress/css/image-map-pro.min.css?ver=4.4.5' type='text/css' media='' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type='text/javascript' src='<?php echo get_home_url() ?>/wp-includes/js/admin-bar.min.js?ver=5.0.2'></script>
	<script type='text/javascript' src='<?php echo get_home_url() ?>/wp-includes/js/wp-embed.min.js?ver=5.0.2'></script>
	<script type='text/javascript' src='<?php echo get_home_url() ?>/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
	<script type='text/javascript' src='<?php echo get_home_url() ?>/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
	<script type='text/javascript' src='<?php echo get_home_url() ?>/wp-content/plugins/image-map-pro-wordpress/js/image-map-pro.min.js?ver=4.4.5'></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  	<script type="text/javascript">
  		(function($, window, document, undefined) {

  			

  			$.imageMapProEventClickedShape = function(imageMapName, shapeName) {

  				if( imageMapName == 'skyhousebuckhead' ){ 

					console.log('imageMapName: '+imageMapName);  
					console.log('shapeName: '+shapeName);

					var preSelectedFloor = $("#selectedfloor").val();
					if(preSelectedFloor !== ''){
						$.imageMapProUnhighlightShape(imageMapName, preSelectedFloor);
					}

					$.imageMapProHighlightShape(imageMapName, shapeName);
					$("#selectedfloor").val(shapeName);

					floordata = {
								action: 'return_plan_shortcode_via_ajax',
								shapeName: shapeName
							}
							jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",floordata,function(response) {
								$("#results-availability-map").imageMapPro(JSON.parse(response));

							});

					availabilitydata = {
										action: 'return_plan_availability_via_ajax',
										shapeName: shapeName
									}
									jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",availabilitydata,function(response) {
										$("#unit-search-results-container").html(response);
									});



					availabilityselecteddata = {
										action: 'return_plan_availability_selected_via_ajax',
										shapeName: shapeName
									}
									jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",availabilityselecteddata,function(response) {
										$("#availablefloor").val(response);
										arr = response.split(',');
										for(i=0; i < arr.length; i++){
										    console.log(arr[i]);
										    $.imageMapProHighlightShape(shapeName, arr[i]);
										}


									});
				}
			 }


			 $.imageMapProEventOpenedTooltip = function(imageMapName, shapeTitle) {

			 	$('.tooltip-'+shapeTitle).html('Loading....');

			 	if(imageMapName !== 'skyhousebuckhead'){

				 	tooltipdata = {
									action: 'return_tooltip_via_ajax',
									imageMapName: imageMapName,
									shapeName: shapeTitle
								   }
					jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",tooltipdata,function(response) {
						if(response == ''){
							$.imageMapProHideTooltip(imageMapName, shapeTitle);
						}else{
							$('.tooltip-'+shapeTitle).html(response);
						}
				 	});

				}
			}



  		})(jQuery, window, document);

  		jQuery( document ).ready(function() {

  			
  			/*Levelwise Search*/
    		jQuery('select#level').change(function() {

    			jQuery('#name option:first').prop('selected',true);
    			jQuery('#price option:first').prop('selected',true);

			    //Use $option (with the "$") to see that the variable is a jQuery object
			    var $option = jQuery(this).find('option:selected');
			    //Added with the EDIT
			    var shapeName = 'sb-floor-'+$option.val();//to get content of "value" attrib
				var imageMapName = 'skyhousebuckhead';
				
				floordata = {
							action: 'return_plan_shortcode_via_ajax',
							shapeName: shapeName
						}
						jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",floordata,function(response) {
							jQuery("#results-availability-map").imageMapPro(JSON.parse(response));

						});

				availabilitydata = {
									action: 'return_plan_availability_via_ajax',
									shapeName: shapeName
								}
								jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",availabilitydata,function(response) {
									jQuery("#unit-search-results-container").html(response);
								});

				

			});


			/* Floor-Planwise Search*/
			jQuery('select#name').change(function() {

				jQuery('#level option:first').prop('selected',true);
    			jQuery('#price option:first').prop('selected',true);

    			//Use $option (with the "$") to see that the variable is a jQuery object
			    var $option = jQuery(this).find('option:selected');
			    //Added with the EDIT
			    var floorplan = $option.val();//to get content of "value" attrib

			    availabilitydata = {
									action: 'return_floor_availability_via_ajax',
									floorplan: floorplan
								}
								jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",availabilitydata,function(response) {
									jQuery("#results-availability-map").html('');
									jQuery("#unit-search-results-container").html(response);
								});
			});

			/* Price Search */
			jQuery('select#price').change(function() {

				jQuery('#level option:first').prop('selected',true);
    			jQuery('#name option:first').prop('selected',true);

    			//Use $option (with the "$") to see that the variable is a jQuery object
			    var $option = jQuery(this).find('option:selected');
			    var price = $option.val();//to get content of "value" attrib

			    availabilitydata = {
									action: 'return_price_availability_via_ajax',
									price: price
								}
								jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",availabilitydata,function(response) {
									jQuery("#results-availability-map").html('');
									jQuery("#unit-search-results-container").html(response);
								});

			});

			/* On Reset omit the result */

			jQuery(":reset").click(function() {
  				jQuery("#results-availability-map").html('');
				jQuery("#unit-search-results-container").html('');
  			})


    	

		});
  	</script>
