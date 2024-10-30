

jQuery( function( $ ) {

	/**
	 * Variations Price Matrix actions
	 */
	var cf7cc_frontend = {

		/**
		 * Initialize variations actions
		 */
		init: function() {
			$(document).on('change', '.cf7cc-fields', this.cal_formulas);

			this.cal_formulas();
			//$(".slider").slider().slider("float");
		},
		
		cal_formulas: function() {
			var fields = [];

			$(".cf7cc-fields").each(function () {
				var type = $(this).attr('type');
				var name = $(this).attr('name');

	       		if( type == "checkbox" || type == "radio"  ) {
	       			var name = name.replace("[]", "");
	       			fields.push(name);
	       		}else{
	       			fields.push(name);
	       		}
			});

			fields = cf7cc_frontend.remove_duplicates(fields);
			console.log(fields);

			var fields_regexp = new RegExp( '(' + fields.join("|") + ')');
			$index = 0;
			$( ".cf7cc-totals" ).each(function( index ) {
				var formulas = $(this).attr('data-formulas');

				if( formulas ) {
					var test = formulas;
					formulas = '(' + formulas + ')';

					while ( match = fields_regexp.exec( formulas ) ) {
						var type = $("input[name=" + match[0] + "]").attr("type");
						if( type === undefined ) {
							var type = $("input[name='" + match[0] + "[]']").attr("type");
						}
						if( type =="checkbox" ){
							var val = 0;
							$("input[name='" + match[0] + "[]']:checked").each(function () {
								val += new Number($(this).val());
							});
							
						}else if( type == "radio"){
							var val = $("input[name='" + match[0] + "']:checked").val();

						}else if( type === undefined ){
							var val = $("select[name=" + match[0] + "]").val();	
						}else{
							var val = $("input[name=" + match[0] + "]").val();
						}
						if(!$.isNumeric(val)){
							val = 0;
						}
						test = test.replace( match[0], val );
						formulas = formulas.replace( match[0], val ); 
					}

					console.log(formulas);
					try{
						var r = eval( formulas );
						total = r;
					}
					catch(e) {
						alert( "Error:" + formulas );
					}
					
					if( $index == 0 ){
						$(this).val(total);
						$(this).parent().find('.cf7-calculated-name').html('$' + total);
					}else{
						total = "(Pro Version)";
						$(this).val(total);
						$(this).parent().find('.cf7-calculated-name').html(total);
					}
					$index++;

				}

			});
			
		},

		remove_duplicates(arr) {
		    var obj = {};
		    var field_arr = [];
		    for (var i = 0; i < arr.length; i++) {
		        obj[arr[i]] = true;
		    }
		    for (var key in obj) {
		    	field_arr.push(key);
		    }
		    return field_arr;
		}
	}
	
	cf7cc_frontend.init();
});