<?

ob_start();

?>

<!-- 5. $JQUERY_VALIDATION =========================================================================

				jQuery Validation
-->
				<!-- Javascript -->
				<script>
					init.push(function () {
						$("#jq-validation-phone").mask("(999) 999-9999");
						$('#jq-validation-select2').select2({ allowClear: true, placeholder: 'Select a country...' }).change(function(){
							$(this).valid();
						});
						$('#jq-validation-select2-multi').select2({ placeholder: 'Select gear...' }).change(function(){
							$(this).valid();
						});

						// Add phone validator
						$.validator.addMethod(
							"phone_format",
							function(value, element) {
								var check = false;
								return this.optional(element) || /^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(value);
							},
							"Invalid phone number."
						);

						// Setup validation
						$("#jq-validation-form").validate({
							ignore: '.ignore, .select2-input',
							focusInvalid: false,
							rules: {
								'jq-validation-email': {
								  required: true,
								  email: true
								},
								'jq-validation-password': {
									required: true,
									minlength: 6,
									maxlength: 20
								},
								'jq-validation-password-confirmation': {
									required: true,
									minlength: 6,
									equalTo: "#jq-validation-password"
								},
								'jq-validation-required': {
									required: true
								},
								'jq-validation-url': {
									required: true,
									url: true
								},
								'jq-validation-phone': {
									required: true,
									phone_format: true
								},
								'jq-validation-select': {
									required: true
								},
								'jq-validation-multiselect': {
									required: true,
									minlength: 2
								},
								'jq-validation-select2': {
									required: true
								},
								'jq-validation-select2-multi': {
									required: true,
									minlength: 2
								},
								'jq-validation-text': {
									required: true
								},
								'jq-validation-simple-error': {
									required: true
								},
								'jq-validation-dark-error': {
									required: true
								},
								'jq-validation-radios': {
									required: true
								},
								'jq-validation-checkbox1': {
									require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
								},
								'jq-validation-checkbox2': {
									require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
								},
								'jq-validation-policy': {
									required: true
								}
							},
							messages: {
								'jq-validation-email': 'Hei?!',
								'jq-validation-policy': 'You must check it!'
							}
						});
					});
				</script>
				<!-- / Javascript -->

				<div id="Form1" class="panel">
					<div class="panel-heading">
						<span class="panel-title">jQuery Validation</span>
					</div>
					<div class="panel-body">
						
						<form id="jq-validation-form" class="form-horizontal" >						
		
								<div class="row">										

									<div class="col-sm-3">

										<div class="form-group">
											<label for="jq-validation-email" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-9 has-feedback">												
												<input type="text" class="form-control" id="jq-validation-email" name="jq-validation-email" placeholder="Email" title="Exemplo de tooltip 1.">
												<span class="fa fa-envelope form-control-feedback"></span>
											</div>
										</div>

									</div>

									<div class="col-sm-3">

										<div class="form-group">
											<label for="jq-validation-email" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-9 has-feedback">
												<input type="text" class="form-control" id="jq-validation-email" name="jq-validation-email" placeholder="Email" title="Exemplo de tooltip 2.">
												<span class="fa fa-user form-control-feedback"></span>
											</div>
										</div>

									</div>									

									<div class="col-sm-6">

										<div class="form-group">
											<label for="jq-validation-email" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="jq-validation-email" name="jq-validation-email" placeholder="Email">
											</div>
										</div>

									</div>									

								</div>

							<div class="form-group">
								<label for="jq-validation-password" class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="jq-validation-password" name="jq-validation-password" placeholder="Password">
									<p class="help-block">Example block-level help text here.</p>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-password-confirmation" class="col-sm-3 control-label">Confirm password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="jq-validation-password-confirmation" name="jq-validation-password-confirmation" placeholder="Confirm password">
									<p class="help-block">Example block-level help text here.</p>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-required" class="col-sm-3 control-label">Required</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="jq-validation-required" name="jq-validation-required" placeholder="Required">
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-url" class="col-sm-3 control-label">URL</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="jq-validation-url" name="jq-validation-url" placeholder="Url">
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-phone" class="col-sm-3 control-label">Phone</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="jq-validation-phone" name="jq-validation-phone" placeholder="Phone: (999) 999-9999">
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-select" class="col-sm-3 control-label">Select Box</label>
								<div class="col-sm-9">
									<select class="form-control" id="jq-validation-select" name="jq-validation-select">
										<option value="">Select gear...</option>
										<optgroup label="Climbing">
											<option value="pitons">Pitons</option>
											<option value="cams">Cams</option>
											<option value="nuts">Nuts</option>
											<option value="bolts">Bolts</option>
											<option value="stoppers">Stoppers</option>
											<option value="sling">Sling</option>
										</optgroup>
										<optgroup label="Skiing">
											<option value="skis">Skis</option>
											<option value="skins">Skins</option>
											<option value="poles">Poles</option>
										</optgroup>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-multiselect" class="col-sm-3 control-label">Multiselect</label>
								<div class="col-sm-9">
									<select class="form-control" name="jq-validation-multiselect" id="jq-validation-multiselect" multiple="multiple">
										<optgroup label="Climbing">
											<option value="pitons">Pitons</option>
											<option value="cams">Cams</option>
											<option value="nuts">Nuts</option>
											<option value="bolts">Bolts</option>
											<option value="stoppers">Stoppers</option>
											<option value="sling">Sling</option>
										</optgroup>
										<optgroup label="Skiing">
											<option value="skis">Skis</option>
											<option value="skins">Skins</option>
											<option value="poles">Poles</option>
										</optgroup>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-select2" class="col-sm-3 control-label">Select2</label>
								<div class="col-sm-9">
									<select class="form-control" name="jq-validation-select2" id="jq-validation-select2">
										<option></option>
										<option value="AF">Afghanistan</option>
										<option value="AX">&Aring;land Islands</option>
										<option value="AL">Albania</option>
										<option value="DZ">Algeria</option>
										<option value="AS">American Samoa</option>
										<option value="AD">Andorra</option>
										<option value="AO">Angola</option>
										<option value="AI">Anguilla</option>
										<option value="AQ">Antarctica</option>
										<option value="AG">Antigua and Barbuda</option>
										<option value="AR">Argentina</option>
										<option value="AM">Armenia</option>
										<option value="AW">Aruba</option>
										<option value="AU">Australia</option>
										<option value="AT">Austria</option>
										<option value="AZ">Azerbaijan</option>
										<option value="BS">Bahamas</option>
										<option value="BH">Bahrain</option>
										<option value="BD">Bangladesh</option>
										<option value="BB">Barbados</option>
										<option value="BY">Belarus</option>
										<option value="BE">Belgium</option>
										<option value="BZ">Belize</option>
										<option value="BJ">Benin</option>
										<option value="BM">Bermuda</option>
										<option value="BT">Bhutan</option>
										<option value="BO">Bolivia, Plurinational State of</option>
										<option value="BA">Bosnia and Herzegovina</option>
										<option value="BW">Botswana</option>
										<option value="BV">Bouvet Island</option>
										<option value="BR">Brazil</option>
										<option value="IO">British Indian Ocean Territory</option>
										<option value="BN">Brunei Darussalam</option>
										<option value="BG">Bulgaria</option>
										<option value="BF">Burkina Faso</option>
										<option value="BI">Burundi</option>
										<option value="KH">Cambodia</option>
										<option value="CM">Cameroon</option>
										<option value="CA">Canada</option>
										<option value="CV">Cape Verde</option>
										<option value="KY">Cayman Islands</option>
										<option value="CF">Central African Republic</option>
										<option value="TD">Chad</option>
										<option value="CL">Chile</option>
										<option value="CN">China</option>
										<option value="CX">Christmas Island</option>
										<option value="CC">Cocos (Keeling) Islands</option>
										<option value="CO">Colombia</option>
										<option value="KM">Comoros</option>
										<option value="CG">Congo</option>
										<option value="CD">Congo, the Democratic Republic of the</option>
										<option value="CK">Cook Islands</option>
										<option value="CR">Costa Rica</option>
										<option value="CI">C&ocirc;te d'Ivoire</option>
										<option value="HR">Croatia</option>
										<option value="CU">Cuba</option>
										<option value="CY">Cyprus</option>
										<option value="CZ">Czech Republic</option>
										<option value="DK">Denmark</option>
										<option value="DJ">Djibouti</option>
										<option value="DM">Dominica</option>
										<option value="DO">Dominican Republic</option>
										<option value="EC">Ecuador</option>
										<option value="EG">Egypt</option>
										<option value="SV">El Salvador</option>
										<option value="GQ">Equatorial Guinea</option>
										<option value="ER">Eritrea</option>
										<option value="EE">Estonia</option>
										<option value="ET">Ethiopia</option>
										<option value="FK">Falkland Islands (Malvinas)</option>
										<option value="FO">Faroe Islands</option>
										<option value="FJ">Fiji</option>
										<option value="FI">Finland</option>
										<option value="FR">France</option>
										<option value="GF">French Guiana</option>
										<option value="PF">French Polynesia</option>
										<option value="TF">French Southern Territories</option>
										<option value="GA">Gabon</option>
										<option value="GM">Gambia</option>
										<option value="GE">Georgia</option>
										<option value="DE">Germany</option>
										<option value="GH">Ghana</option>
										<option value="GI">Gibraltar</option>
										<option value="GR">Greece</option>
										<option value="GL">Greenland</option>
										<option value="GD">Grenada</option>
										<option value="GP">Guadeloupe</option>
										<option value="GU">Guam</option>
										<option value="GT">Guatemala</option>
										<option value="GG">Guernsey</option>
										<option value="GN">Guinea</option>
										<option value="GW">Guinea-Bissau</option>
										<option value="GY">Guyana</option>
										<option value="HT">Haiti</option>
										<option value="HM">Heard Island and McDonald Islands</option>
										<option value="VA">Holy See (Vatican City State)</option>
										<option value="HN">Honduras</option>
										<option value="HK">Hong Kong</option>
										<option value="HU">Hungary</option>
										<option value="IS">Iceland</option>
										<option value="IN">India</option>
										<option value="ID">Indonesia</option>
										<option value="IR">Iran, Islamic Republic of</option>
										<option value="IQ">Iraq</option>
										<option value="IE">Ireland</option>
										<option value="IM">Isle of Man</option>
										<option value="IL">Israel</option>
										<option value="IT">Italy</option>
										<option value="JM">Jamaica</option>
										<option value="JP">Japan</option>
										<option value="JE">Jersey</option>
										<option value="JO">Jordan</option>
										<option value="KZ">Kazakhstan</option>
										<option value="KE">Kenya</option>
										<option value="KI">Kiribati</option>
										<option value="KP">Korea, Democratic People's Republic of</option>
										<option value="KR">Korea, Republic of</option>
										<option value="KW">Kuwait</option>
										<option value="KG">Kyrgyzstan</option>
										<option value="LA">Lao People's Democratic Republic</option>
										<option value="LV">Latvia</option>
										<option value="LB">Lebanon</option>
										<option value="LS">Lesotho</option>
										<option value="LR">Liberia</option>
										<option value="LY">Libyan Arab Jamahiriya</option>
										<option value="LI">Liechtenstein</option>
										<option value="LT">Lithuania</option>
										<option value="LU">Luxembourg</option>
										<option value="MO">Macao</option>
										<option value="MK">Macedonia, the former Yugoslav Republic of</option>
										<option value="MG">Madagascar</option>
										<option value="MW">Malawi</option>
										<option value="MY">Malaysia</option>
										<option value="MV">Maldives</option>
										<option value="ML">Mali</option>
										<option value="MT">Malta</option>
										<option value="MH">Marshall Islands</option>
										<option value="MQ">Martinique</option>
										<option value="MR">Mauritania</option>
										<option value="MU">Mauritius</option>
										<option value="YT">Mayotte</option>
										<option value="MX">Mexico</option>
										<option value="FM">Micronesia, Federated States of</option>
										<option value="MD">Moldova, Republic of</option>
										<option value="MC">Monaco</option>
										<option value="MN">Mongolia</option>
										<option value="ME">Montenegro</option>
										<option value="MS">Montserrat</option>
										<option value="MA">Morocco</option>
										<option value="MZ">Mozambique</option>
										<option value="MM">Myanmar</option>
										<option value="NA">Namibia</option>
										<option value="NR">Nauru</option>
										<option value="NP">Nepal</option>
										<option value="NL">Netherlands</option>
										<option value="AN">Netherlands Antilles</option>
										<option value="NC">New Caledonia</option>
										<option value="NZ">New Zealand</option>
										<option value="NI">Nicaragua</option>
										<option value="NE">Niger</option>
										<option value="NG">Nigeria</option>
										<option value="NU">Niue</option>
										<option value="NF">Norfolk Island</option>
										<option value="MP">Northern Mariana Islands</option>
										<option value="NO">Norway</option>
										<option value="OM">Oman</option>
										<option value="PK">Pakistan</option>
										<option value="PW">Palau</option>
										<option value="PS">Palestinian Territory, Occupied</option>
										<option value="PA">Panama</option>
										<option value="PG">Papua New Guinea</option>
										<option value="PY">Paraguay</option>
										<option value="PE">Peru</option>
										<option value="PH">Philippines</option>
										<option value="PN">Pitcairn</option>
										<option value="PL">Poland</option>
										<option value="PT">Portugal</option>
										<option value="PR">Puerto Rico</option>
										<option value="QA">Qatar</option>
										<option value="RE">R&eacute;union</option>
										<option value="RO">Romania</option>
										<option value="RU">Russian Federation</option>
										<option value="RW">Rwanda</option>
										<option value="BL">Saint Barth&eacute;lemy</option>
										<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
										<option value="KN">Saint Kitts and Nevis</option>
										<option value="LC">Saint Lucia</option>
										<option value="MF">Saint Martin (French part)</option>
										<option value="PM">Saint Pierre and Miquelon</option>
										<option value="VC">Saint Vincent and the Grenadines</option>
										<option value="WS">Samoa</option>
										<option value="SM">San Marino</option>
										<option value="ST">Sao Tome and Principe</option>
										<option value="SA">Saudi Arabia</option>
										<option value="SN">Senegal</option>
										<option value="RS">Serbia</option>
										<option value="SC">Seychelles</option>
										<option value="SL">Sierra Leone</option>
										<option value="SG">Singapore</option>
										<option value="SK">Slovakia</option>
										<option value="SI">Slovenia</option>
										<option value="SB">Solomon Islands</option>
										<option value="SO">Somalia</option>
										<option value="ZA">South Africa</option>
										<option value="GS">South Georgia and the South Sandwich Islands</option>
										<option value="ES">Spain</option>
										<option value="LK">Sri Lanka</option>
										<option value="SD">Sudan</option>
										<option value="SR">Suriname</option>
										<option value="SJ">Svalbard and Jan Mayen</option>
										<option value="SZ">Swaziland</option>
										<option value="SE">Sweden</option>
										<option value="CH">Switzerland</option>
										<option value="SY">Syrian Arab Republic</option>
										<option value="TW">Taiwan, Province of China</option>
										<option value="TJ">Tajikistan</option>
										<option value="TZ">Tanzania, United Republic of</option>
										<option value="TH">Thailand</option>
										<option value="TL">Timor-Leste</option>
										<option value="TG">Togo</option>
										<option value="TK">Tokelau</option>
										<option value="TO">Tonga</option>
										<option value="TT">Trinidad and Tobago</option>
										<option value="TN">Tunisia</option>
										<option value="TR">Turkey</option>
										<option value="TM">Turkmenistan</option>
										<option value="TC">Turks and Caicos Islands</option>
										<option value="TV">Tuvalu</option>
										<option value="UG">Uganda</option>
										<option value="UA">Ukraine</option>
										<option value="AE">United Arab Emirates</option>
										<option value="GB">United Kingdom</option>
										<option value="US">United States</option>
										<option value="UM">United States Minor Outlying Islands</option>
										<option value="UY">Uruguay</option>
										<option value="UZ">Uzbekistan</option>
										<option value="VU">Vanuatu</option>
										<option value="VE">Venezuela, Bolivarian Republic of</option>
										<option value="VN">Viet Nam</option>
										<option value="VG">Virgin Islands, British</option>
										<option value="VI">Virgin Islands, U.S.</option>
										<option value="WF">Wallis and Futuna</option>
										<option value="EH">Western Sahara</option>
										<option value="YE">Yemen</option>
										<option value="ZM">Zambia</option>
										<option value="ZW">Zimbabwe</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-select2-multi" class="col-sm-3 control-label">Select2 Multiple</label>
								<div class="col-sm-9">
									<select class="form-control" name="jq-validation-select2-multi" id="jq-validation-select2-multi" multiple="multiple">
										<optgroup label="Climbing">
											<option value="pitons">Pitons</option>
											<option value="cams">Cams</option>
											<option value="nuts">Nuts</option>
											<option value="bolts">Bolts</option>
											<option value="stoppers">Stoppers</option>
											<option value="sling">Sling</option>
										</optgroup>
										<optgroup label="Skiing">
											<option value="skis">Skis</option>
											<option value="skins">Skins</option>
											<option value="poles">Poles</option>
										</optgroup>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="jq-validation-text" class="col-sm-3 control-label">Text</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="jq-validation-text" id="jq-validation-text"></textarea>
									<p class="help-block">Example block-level help text here.</p>
								</div>
							</div>

							<!-- To use simple error template, just add '.simple' class to the .form-group -->
							<div class="form-group simple">
								<label for="jq-validation-simple-error" class="col-sm-3 control-label">Simple error</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="jq-validation-simple-error" name="jq-validation-simple-error" placeholder="Required">
								</div>
							</div>

							<!-- To use dark error template, just add '.dark' class to the .form-group -->
							<div class="form-group dark">
								<label for="jq-validation-dark-error" class="col-sm-3 control-label">Dark error</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="jq-validation-dark-error" name="jq-validation-dark-error" placeholder="Required">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Radios</label>
								<div class="col-sm-9">
									<div class="radio">
										<label>
											<input type="radio" name="jq-validation-radios" value="1" class="px">
											<span class="lbl">Option one is this and that—be sure to include why it's great</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="jq-validation-radios" value="2" class="px">
											<span class="lbl">Option two can be something else and selecting it will deselect option one</span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="jq-validation-checkbox1" class="px"> <span class="lbl">Checkbox 1</span>
										</label>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="jq-validation-checkbox2" class="px"> <span class="lbl">Checkbox 2</span>
										</label>
									</div>
								</div>
							</div>

							<hr class="panel-wide">

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="jq-validation-policy" id="jq-validation-policy" class="px"> <span class="lbl">Confirm policy</span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<button type="submit" class="btn btn-primary">Sign in</button>
								</div>
							</div>
						</form>
					</div>
				</div>
<!-- /5. $JQUERY_VALIDATION -->

<?

	$html = ob_get_clean();
	return utf8_encode($html);

?>