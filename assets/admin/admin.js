jQuery( function( $ ) {

	/**
	 * CF7 Cost Calculator actions
	 */
	var bh_cf7cc_admin = {

		/**
		 * Initialize actions
		 */
		init: function() {
			$(document).on('click', 'input.cf7cc-insert-tag', this.insert_tags);
			$(document).on('click', 'input.cf7cc-insert-slider', this.insert_slider);
			$(document).on('click', 'input.cf7cc-insert-calculated', this.insert_calculated);
			
	

			this.load_form_tags();

			autosize($('textarea.textarea-autosize'));

			
			
		},


		
		insert_calculated: function() {
			var tag = '';
			var name = '';
			var shortcode = '';
			var shortcode_value = '';
			var shortcode_id = '';
			var shortcode_class = '';
			var $form = $( this ).closest( '.tag-generator-panel-cc' );
			var label = $form.find('#tag-generator-panel-label').val();
			var name_fields = $form.find('#tag-generator-panel-name').val();
			var id = $form.find('#tag-generator-panel-id').val();
			var data_class = $form.find('#tag-generator-panel-class').val();
			var formulas = $form.find('#tag-generator-panel-formulas').val();

			
			var shortcode_fields = $( this ).attr('data-shortcode');
			var type = $( this ).attr('data-type');
			
			if ( name_fields ) {
				name += name_fields;
			}else {
				name += type + '-' + Math.floor( Math.random() * 1000 );
			}
			
			if( id ) {
				shortcode_id += ' id:' + id;
			}
	
			if( data_class ) {
				shortcode_class += ' class:' + data_class;
			}
			
			shortcode = '[' + shortcode_fields + ' ' + name + shortcode_id + shortcode_class + ']';
			
			if( label ) {
				tag += '<label> ' + label + ' (required)' + "\n" + '    ' + shortcode + ' </label>'+ "\n\n";
			}else {
				tag += shortcode;
			}
			
			



            $.ajax({
                url: cf7cc.ajax_url,
                data: {
                    action: 'cf7cc_save_formulas',
                    formulas: formulas,
                    name: name,
                    form_id: $('#post_ID').val()
                },
                type: 'POST',
                datatype: 'json',
                success: function( rs ) {
                    if ( rs.complete != undefined ) {
                    	wpcf7.taggen.insert( tag );
                    	$.magnificPopup.close();
                    }
                },
                error:function(xhr, status, error){
                  var err = eval("(" + xhr.responseText + ")");
                  alert(error);
                }
            });

			//
			return false;
		},
		
		insert_slider: function() {
			var tag = '';
			var name = '';
			var shortcode = '';
			var shortcode_value = '';
			var shortcode_id = '';
			var shortcode_class = '';
			var $form = $( this ).closest( '.tag-generator-panel-cc' );
			var label = $form.find('#tag-generator-panel-label').val();
			var name_fields = $form.find('#tag-generator-panel-name').val();
			var id = $form.find('#tag-generator-panel-id').val();
			var data_class = $form.find('#tag-generator-panel-class').val();
			
			var minvalue = $('#tag-generator-panel-minvalue').val();
			var maxvalue = $('#tag-generator-panel-maxvalue').val();
			var default_fields = $('#tag-generator-panel-default').val();
			
			var shortcode_fields = $( this ).attr('data-shortcode');
			var type = $( this ).attr('data-type');
			
			if ( name_fields ) {
				shortcode += shortcode_fields + ' ' + name_fields;
			}else {
				shortcode += shortcode_fields + ' ' + type + '-' + Math.floor( Math.random() * 1000 );
			}
			
			if( id ) {
				shortcode_id += ' id:' + id;
			}
	
			if( data_class ) {
				shortcode_class += ' class:' + data_class;
			}
			
			if( ! minvalue ) {
				minvalue = 0;
			}
		
			if( ! maxvalue ) {
				maxvalue = 0;
			}

			if( default_fields ) {
				default_fields = ' "' + default_fields + '"';
			}
			shortcode = '[' + shortcode + shortcode_id + shortcode_class + ' min:' + minvalue + ' max:' + maxvalue + default_fields + ']';
			
			if( label ) {
				tag += '<label> ' + label + ' (required)' + "\n" + '    ' + shortcode + ' </label>'+ "\n\n";
			}else {
				tag += shortcode;
			}
			
			wpcf7.taggen.insert( tag );
			$.magnificPopup.close();
			return false;
		},
		
		insert_tags: function() {
			var tag = '';
			var name = '';
			var shortcode = '';
			var shortcode_value = '';
			var shortcode_id = '';
			var shortcode_class = '';
			var $form = $( this ).closest( '.tag-generator-panel-cc' );
			var label = $form.find('#tag-generator-panel-label').val();
			var name_fields = $form.find('#tag-generator-panel-name').val();
			var id = $form.find('#tag-generator-panel-id').val();
			var data_class = $form.find('#tag-generator-panel-class').val();
			
			var shortcode_fields = $( this ).attr('data-shortcode');
			var type = $( this ).attr('data-type');
			
			console.log(shortcode_fields);
			

			if ( name_fields ) {
				shortcode += shortcode_fields + ' ' + name_fields;
			}else {
				shortcode += shortcode_fields + ' ' + type + '-' + Math.floor( Math.random() * 1000 );;
			}
			
			$('.option-value').each(function (index, value) {
				var $row = $(this).closest('.cf7cc-repeater-row');
				
				var $text = $row.find('.option-text').val();
				
				if($(this).val() && $text) {
					shortcode_value += ' "' + $(this).val() + '|' + $text + '"';
				}
			});
			
			if( id ) {
				shortcode_id += ' id:' + id;
			}
	
			if( data_class ) {
				shortcode_class += ' class:' + data_class;
			}
			
			shortcode = '[' + shortcode + shortcode_id + shortcode_class + shortcode_value + ']';
			
			if( label ) {
				tag += '<label> ' + label + ' (required)' + "\n" + '    ' + shortcode + ' </label>'+ "\n\n";
			}else {
				tag += shortcode;
			}
			
			wpcf7.taggen.insert( tag );
			$.magnificPopup.close();
			return false;
		},
		
		load_form_tags: function() {
			$('#tag-generator-list').after( $('#bh-cf7cc-tags').html() );
			$('.open-popup-link').magnificPopup({
				type:'inline',
				midClick: true,
				callbacks: {
					open: function() {
						$('body').addClass('magnificPopup');
					},
					close: function() {
						$('body').removeClass('magnificPopup');
					}
				}
			});
		}
		


	}
	
	bh_cf7cc_admin.init();
});