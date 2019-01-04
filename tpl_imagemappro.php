<?php
/* Template Name: Image Map pro*/

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<h2>Image Map Pro</h2>
			<div class="container">
  				<div class="row">
    				<div class="col-sm-6">
    					<?php echo do_shortcode('[skyhousebuckhead]'); ?>
    				</div>
    				<div class="col-sm-6">
    					<div id="search-floorplans">
					<form id="unit-search-criteria" action="" method="">
						<h2>Search Criteria</h2>
						<p>Search for available homes from one of the criteria below, or scroll over a floor to the left.</p>
						<div id="search-fields">
							<div class="input-container">
								<select id="name">
									<option value="none">FLOOR PLAN</option>
									<option value="1">1 Bedroom, 1 Bath</option>
									<option value="2">2 Bedroom, 2 Bath</option>
									<option value="3">3 Bedroom, 3 Bath</option>
									<option value="studio">Studio</option>
								</select>
							</div>
							<div class="input-container">
								<select id="level">
									<option value="none">LEVEL</option>
									<option value="02">Level 02</option>
									<option value="03">Level 03</option>
									<option value="04">Level 04</option>
									<option value="05">Level 05</option>
									<option value="06">Level 06</option>
									<option value="07">Level 07</option>
									<option value="08">Level 08</option>
									<option value="09">Level 09</option>
									<option value="10">Level 10</option>
									<option value="11">Level 11</option>
									<option value="12">Level 12</option>
									<option value="13">Level 13</option>
									<option value="14">Level 14</option>
									<option value="15">Level 15</option>
									<option value="16">Level 16</option>
									<option value="17">Level 17</option>
									<option value="18">Level 18</option>
									<option value="19">Level 19</option>
									<option value="20">Level 20</option>
									<option value="21">Level 21</option>
									<option value="22">Level 22</option>
									<option value="23">Level 23</option>
									<option value="24">Level 24</option>
									<option value="25">Level 25</option>
								</select>
							</div>
							<div class="input-container">
								<select id="price">
									<option value="none">Price</option>
									<option value="1000-1499">$1000-$1499</option>
									<option value="1500-1999">$1500-$1999</option>
									<option value="2000-2499">$2000-$2499</option>
									<option value="2500-2999">$2500-$2999</option>
									<option value="3000">$3000+</option>
								</select>
							</div>
							<div class="input-container"> </div>
						</div>
						<input type="hidden" name="unit-search" value="true">
						<button type="reset" class="button" id="clear"><span class="inside">Reset</span></button>
						<button type="button" class="button" id="submit"><span class="inside">Submit</span></button>
						<div id="unit-search-results"> </div>
						<div id="results-availability-map" class="clear"></div>
						<div id="unit-search-results-container"></div>
						<div id="selected"><input type="hidden" name="selectedfloor" id="selectedfloor" value=""></div>
						<div id="available"><input type="hidden" name="availablefloor" id="availablefloor" value=""></div>
						<div id="approximate">Please note: square footage, dimensions and views are approximate</div>
					</form>
				</div>

		</main><!-- #main -->
	</section><!-- #primary -->
    				</div>
    			</div>
    		</div>
<?php
get_footer();
