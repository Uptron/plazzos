"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;
	
	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard_v1', {
			startStep: 1
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		})

		// Change event
		wizard.on('change', function(wizard) {
			setTimeout(function() {
				KTUtil.scrollTop();	
			}, 500);
		});
	}	

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {	
				//= Step 1
				issuing_office: {
					required: true 
				},
				place_of_inspection: {
					required: true
				},
				prev_reg_country: {
					required: true
				},

				//= Step 2
				insurance_company: {
					required: true
				},
				policy_number: {
					required: true
				},
				expiry_date: {
					required: true
				},
				color: {
					required: true
				},
				yom: {
					required: true
				},
				reg_date: {
					required: true
				},
				engine_no: {
					required: true
				},
				chasis_no: {
					required: true
				},
				engine_rating: {
					required: true
				},
				odometer_reading: {
					required:true
				},
				serial_no: {
					required:true
				},
				anti_theft: {
                    required:true
				},

				//= Step 3
				windscreen: {
					required: true
				},
				audio: {
					required: true
				},
				alarm: {
					required: true
				},
				examiner_opinion: {
					required:true
				},
				forced_sale_value:{
					required:true
				},

				//= Step 4
				bodywork: {
					required: true 
				},
				mechanical: {
					required: true
				},
				steering_and_suspension: {
					required: true
				},
				braking_system: {
					required: true
				},
				electrical_system: {
					required: true
				},
				wheels:{
					required:true
				},
				added_equipment:{
					required:true
				},
				remarks:{
					required:true
				},
				modifications_noted:{
					required:true
				},
				special_remarks:{
					required:true
				},
				general_condition:{
					required:true
				}
			},
			
			// Display error  
			invalidHandler: function(event, validator) {	 
				KTUtil.scrollTop();

				swal({
					"title": "", 
					"text": "There are some errors in your submission. Please correct them.", 
					"type": "error",
					"confirmButtonClass": "btn btn-secondary"
				});
			},

			// Submit valid form
			submitHandler: function (form) {
				
			}
		});   
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {
			e.preventDefault();

			if (validator.form()) {
				// See: src\js\framework\base\app.js
				KTApp.progress(btn);
				//KTApp.block(formEl);

				// See: http://malsup.com/jquery/form/#ajaxSubmit
				formEl.ajaxSubmit({
					success: function() {
						KTApp.unprogress(btn);
						//KTApp.unblock(formEl);

						swal({
							"title": "", 
							"text": "The valuation has been successfully submitted!",
							"type": "success",
							"confirmButtonClass": "btn btn-secondary"
						});

						window.location.href='/valuer/valuation-requests';
						return false;
					}
				});
			}
		});
	}

	return {
		// public functions
		init: function() {
			wizardEl = KTUtil.get('kt_wizard_v1');
			formEl = $('#kt_form');

			initWizard(); 
			initValidation();
			//initSubmit();
		}
	};
}();

jQuery(document).ready(function() {	
	KTWizard1.init();
});