<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
	$country_name = $loc->lookup($this->util->realIP(), IP2Location::COUNTRY_NAME);
	
	$nations = $this->m_visa_fee->voa_nations();
	$visa_types = $this->m_visa_type->items(NULL, 1);
	$visit_purposes = $this->m_visit_purpose->items(NULL, 1);
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
?>

<script type="text/javascript" src="<?=JS_URL?>e-visa-step1.js"></script>

<div class="container">
	<!-- breadcrumb -->
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	<!-- end breadcrumb -->
	<div class="tab-step clearfix">
		<h1 class="note">Vietnam E-Visa Application Form</h1>
		<ul class="style-step d-none d-sm-none d-md-block">
			<li class="active"><font class="number">1.</font> Visa Options</li>
			<li><font class="number">2.</font> Login Account</li>
			<li><font class="number">3.</font> Review & Payment</li>
			<li><font class="number">4.</font> Completed</li>
		</ul>
	</div>
	<div class="applyform">
		<form id="frmApply" class="form-horizontal" role="form" action="<?=BASE_URL_HTTPS."/apply-e-visa/step2.html"?>" method="POST">
			<div class="row clearfix">
				<div class="col-md-7">
					<div class="panel-options">
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Number of visa <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="group_size" name="group_size" class="form-control group_size">
									<option value="1">1 Applicant</option>
									<? for ($i=2; $i<=15; $i++) { ?>
									<option value="<?=$i?>"><?=$i?> Applicants</option>
									<? } ?>
								</select>
								<script> $('#group_size').val('<?=$vev->group_size?>'); </script>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Type of visa <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="visa_type" name="visa_type" class="form-control visa_type">
									<option value="1ms">1 month single</option>
								</select>
								<script> $('#visa_type').val('<?=$vev->visa_type?>'); </script>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Purpose of visit <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="visit_purpose" name="visit_purpose" class="form-control visit_purpose">
									<option value="">Please select...</option>
									<option value="For tourist">For tourist</option>
									<option value="For business">For business</option>
								</select>
								<script> genVisitOptions(); $('#visit_purpose').val('<?=$vev->visit_purpose?>'); </script>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Arrival date <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
<!-- 								<input class="form-control arrival_date" name="arrival_date" type="date" value="<?//=date('Y-m-d',strtotime("+4 days"))?>"> -->
								<div class="row">
									<div class="col-sm-4 col-xs-4">
										<select id="arrivalyear" name="arrivalyear" class="form-control arrival_year">
											<option value="">Year...</option>
											<? for ($y=date("Y"); $y<=date("Y")+3; $y++) { ?>
											<option value="<?=$y?>"><?=$y?></option>
											<? } ?>
										</select>
										<script> $("#arrivalyear").val("<?=$step1->arrivalyear?>"); </script>
									</div>
									<div class="col-sm-4 col-xs-4">
										<select id="arrivalmonth" name="arrivalmonth" class="form-control arrival_month">
											<option value="">Month...</option>
											<? for ($m=1; $m<=12; $m++) { ?>
											<option value="<?=$m?>"><?=date('M', mktime(0, 0, 0, $m, 10))?></option>
											<? } ?>
										</select>
										<script> $("#arrivalmonth").val("<?=$step1->arrivalmonth?>"); </script>
									</div>
									<div class="col-sm-4 col-xs-4">
										<select id="arrivaldate" name="arrivaldate" class="form-control arrival_date">
											<option value="">Day...</option>
											<? for ($d=1; $d<=31; $d++) { ?>
											<option value="<?=$d?>"><?=$d?></option>
											<? } ?>
										</select>
										<script> $("#arrivaldate").val("<?=$step1->arrivaldate?>"); </script>
									</div>
								</div>
								<div class="processing-note">
									When you arrive Vietnam?
								</div>
							</div>
						</div>
<!-- 						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Exit date <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<input class="form-control exit_date" name="exit_date" type="date" value="<?=date('Y-m-d',strtotime("+5 days"))?>">
							</div>
						</div> -->
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Arrival airport <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="arrival_port" name="arrival_port" class="form-control frm-input arrival_port">
									<option value="0" selected="selected">Please select...</option>
									<? $ports = array('Airport','Landport','Seaport'); for ($i=1; $i <= 3 ; $i++) {
											$info = new stdClass();
											$info->category_id = $i;
											$arrival_ports = $this->m_arrival_port->items($info, 1);
										?>
									<optgroup label="<?=$ports[$i-1]?>">
										<? foreach ($arrival_ports as $arrival_port) { ?>
										<option value="<?=$arrival_port->short_name?>"><?=$arrival_port->airport?></option>
										<? } ?>
									</optgroup>
									<? } ?>
								</select>
								<script> $('#arrival_port').val('<?=$vev->arrival_port?>'); </script>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Exit through checkpoint <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="exit_port" name="exit_port" class="form-control frm-input exit_port">
									<option value="0" selected="selected">Please select...</option>
									<? $ports = array('Airport','Landport','Seaport'); for ($i=1; $i <= 3 ; $i++) {
											$info = new stdClass();
											$info->category_id = $i;
											$arrival_ports = $this->m_arrival_port->items($info, 1);
										?>
									<optgroup label="<?=$ports[$i-1]?>">
										<? foreach ($arrival_ports as $arrival_port) { ?>
										<option value="<?=$arrival_port->short_name?>"><?=$arrival_port->airport?></option>
										<? } ?>
									</optgroup>
									<? } ?>
								</select>
								<script> $('#exit_port').val('<?=$vev->exit_port?>'); </script>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4">
								<label class="control-label">Processing time <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<div class="radio">
									<label>
										<input id="processing_time_normal" note-id="processing-time-normal-note" class="processing_time" type="radio" name="processing_time" value="Normal" <?=($vev->processing_time=="Normal"?"checked='checked'":"")?>/>
										Normal (Guaranteed 3 working days)
									</label>
									<a class="glyphicon glyphicon-question-sign tooltip-marker hidden" data-toggle="popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="We guarantee delivery of approval letter in <?=((strtoupper($country_name)=='VIET NAM')?'2 working days':'1 working day')?> by email."></a>
									<div id="processing-time-normal-note" class="processing-option display-none">
										<div class="processing-note">
											We guarantee delivery of approval letter in 3 working days by email.
										</div>
									</div>
								</div>
								<div class="radio" style="margin-top: 5px">
									<label>
										<input id="processing_time_urgent" note-id="processing-time-urgent-note" class="processing_time" type="radio" name="processing_time" value="Urgent" <?=($vev->processing_time=="Urgent"?"checked='checked'":"")?>/>
										Urgent (within 1 working day)
									</label>
									<a class="glyphicon glyphicon-question-sign tooltip-marker hidden" data-toggle="popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="<p>It is effective for whom needs visa urgently. The approval letter will be sent via email in <span class='text-color-red'>4 to 8 working hours</span>. The extra charge is from <b><?="$".$this->m_visa_fee->cal_visa_fee("1ms", 1, "Urgent","","","",$vev->booking_type_id)->rush_fee?> $</b>/person.</p><p><b><u>Notice</u></b>: In case you apply on Saturday, Sunday or Vietnam public holiday, it will be processed the next business day.</p>"></a>
									<div id="processing-time-urgent-note" class="processing-option display-none">
										<div class="processing-note">
											It is effective for who needs visa in urgent. We will send the approval letter by email in <span class="text-color-red">1 working days</span>. If you apply on a Saturday, Sunday or holiday, it will be processed the next business day. The extra charge is from <b>19 $</b>/person.
										</div>
									</div>
								</div>
								<div class="radio" style="margin-top: 5px">
									<label>
										<input id="processing_time_emergency" note-id="processing_time_emergency-note" class="processing_time" type="radio" name="processing_time" value="Emergency" <?=($vev->processing_time=="Emergency"?"checked='checked'":"")?>/>
										<span><strong>Emergency (Within 4 hours)</strong></span>
									</label>
									<div id="processing_time_emergency-note" class="processing-option none">
										<div class="processing-note">
											Similar to Urgent option except it only takes <span class="red">4 hours</span>. The extra charge is from <b><?=$this->m_visa_fee->cal_visa_fee("1ms", 1, "Emergency","","","",$vev->booking_type_id)->rush_fee?> $</b>/person. You should call our hotline <a class="red" title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to confirm the application has been received and acknowledged to process immediately. You are subject to pay stamping fee at the airports. (You can apply supper urgent case on weekend/holiday for arrival date is next Monday or next business day.)
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row form-group" style="padding-top: 20px; padding-bottom: 20px;">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-8">
								<button class="btn btn-danger btn-next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="panel-fees">
						<div class="panel-body">
							<ul>
								<li class="clearfix hidden">
									<label>Passport holder:</label>
									<span class="passport_holder_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Number of persons:</label>
									<span class="group_size_t"></span>
								</li>
								<li class="clearfix">
									<label>Type of visa:</label>
									<span class="visa_type_t"></span>
								</li>
								<li class="clearfix">
									<label>Purpose of visit:</label>
									<span class="visit_purpose_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Visa stamping fee:</label>
									<span class="stamping_fee price"></span>
								</li>
								<li class="clearfix">
									<label>Visa service fee:</label>
									<span class="service_fee price"></span>
								</li>
								<li class="clearfix" id="processing_time_li">
									<label class="tl_process">Processing fee:</label>
									<span class="processing_t price"></span>
								</li>
								<li class="clearfix" id="promotion_li" style="background-color: #F8F8F8;">
									<div id="promotion-box-input" >
										<div class="row clearfix">
											<label class="col-md-5">Got a promotion code?</label>
											<div class="col-md-7">
												<div class="input-group">
													<input type="text" class="promotion-input form-control" id="promotion-input" name="promotion-input" value=""/>
													<span class="input-group-btn" style="float: none;">
														<button type="button" class="btn btn-danger btn-apply-code">APPLY</button>
													</span>
												</div>
												<div class="promotion-error red none">Code invalid. Please try again!</div>
											</div>
										</div>
									</div>
									<div class="clearfix" id="promotion-box-succed" style="display: <?=(!empty($vev->discount) || !empty($vev->member_discount))?'block':'none'?>">
										<label class="left">Promotion discount:</label>
										<span class="promotion_t price"></span>
									</div>
								</li>
								<li class="total clearfix">
									<div class="clearfix">
										<br>
										<label class="pull-left text-color-red">TOTAL FEE:</label>
										<div class="pull-right subtotal-price">
											<div class="price-block ">
												<span class="price total_price"></span>
											</div>
										</div>
									</div>
									<!-- <div class="text-left" style="font-size: 14px;">
										<i class="stamping_fee_included display-none">(<a target="_blank" title="stamping fee" href="<?=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
										<i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i>
									</div> -->
								</li>
							</ul>
							<div class="form-group d-block d-sm-none" style="padding-top: 15px;">
								<div class="text-center">
									<button class="btn btn-danger btn-next btn-1x" type="submit">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></button>
								</div>
							</div>
						</div>
						<div class="payment-methods">
							<img alt="" src="<?=IMG_URL?>payment-methods.jpg">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="shopperapproved d-block d-sm-block d-md-none text-center">
		<h2 class="text-center home-sub-heading">Testimonial</h2>
		<a class="sa-medal" title="Customer ratings" target="_blank" rel="noopener" href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/">
			<img alt="Customer ratings" class="medal-red lazy" src="<?=IMG_URL?>medal-red.png" style="display: inline;">
			<?
				ini_set('default_socket_timeout', 3);
				$sa_content = file_get_contents('https://www.shopperapproved.com/feeds/schema.php/?siteid=24798&token=sfx0VK6J');
				//$sa_total = substr($sa_content, strpos($sa_content, '<span itemprop="ratingCount">')+strlen('<span itemprop="ratingCount">'), 3);
				$str = explode('based on', $sa_content);
				$str = explode(' ', $str[1]);
				$sa_total = $str[1];
			?>
			<span class="sa-total"><?=$sa_total?></span>
		</a>
	</div>
	<div class="testimonial d-none d-sm-none d-md-block">
		<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
			<h2 class="text-center home-sub-heading">Testimonial</h2>
			<h3 class="text-center" style="color: #AAA;">A few words of our travellers.</h3>
			<div class="cluster-content">
				<div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_horizontal sa_count5 sa_rounded sa_colorBlack sa_borderGray sa_bgWhite sa_showdate sa_jMY"></div><script type="text/javascript">var sa_interval = 10000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/3.0/24798.js'); shopper_first = true; </script><div style="text-align:right;"><a href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/" target="_blank" rel="nofollow" class="sa_footer"><img class="sa_widget_footer" alt="Customer reviews" src="//www.shopperapproved.com/widgets/widgetfooter-darklogo.png" style="border: 0;"></a></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	<? if ($this->session->flashdata('session-expired')) { ?>
		messageBox("INFO", "Session Expired", "<?=$this->session->flashdata('session-expired')?>");
	<? } ?>
});
</script>