(function($){
	$(document).ready(function() {
		/*select tags*/
		if ( $( "select" ).length > 0 ) {
			$( "select" ).select2({ width: "resolve" });
		}
		/*slider*/
		$('.indicators a').click(function(){
			if(!$(this).hasClass('current')){
				var current_class = $(this).attr('id');
				var last_class = $('#heading .indicators .current').attr('id')
				$('#heading .indicators .current').removeClass('current');
				$(this).addClass('current');
				$('#heading_text_holder .heading_text.'+last_class).fadeOut(200, function(){$('#heading_text_holder .heading_text.'+current_class).fadeIn()});
			}
			return false;
		})

		/*home image slider*/
		var speed = 400;
		var first_img = $('.home_slides .thumbnails img').first().attr('src');
		$('.home_image img').attr('src', first_img);
		var thumbs_step = $('.thumbnails').width();
		var thumbs_num = $('.thumbnails img').size();
		var thumb_length = thumbs_step / 3;
		var full_length = thumbs_num * thumb_length;
		var max_length = full_length - thumbs_step;
		$('#thumbnails_holder').width(full_length);
		$('.home_slides .prev, .home_slides .next').addClass('disabled');
		if(max_length>thumbs_step)
			$('.home_slides .next').removeClass('disabled');
		$('.home_slides .thumbnails img').click(function(){
			var current = $(this).attr('src');
			$('.home_image img').attr('src', current);
		})
		$('.home_slides .prev, .home_slides .next').click(function(){
			var curr_pos = parseInt($('.home_slides .thumbnails #thumbnails_holder').css('margin-left'));
			// <--
			if($(this).hasClass('next') && !$(this).hasClass('disabled')){
				$('.home_slides .prev').removeClass('disabled');
				if((curr_pos-thumbs_step)<=(-max_length)){
					$('.home_slides .thumbnails #thumbnails_holder').animate({'margin-left': -max_length+'px'}, speed);
					$(this).addClass('disabled');
				}else{
					$('.home_slides .thumbnails #thumbnails_holder').animate({'margin-left': curr_pos-thumbs_step+'px'}, speed);
				}
			}// -->
			else if($(this).hasClass('prev') && !$(this).hasClass('disabled')){
				$('.home_slides .next').removeClass('disabled');
				if((curr_pos+thumbs_step)>=0){
					$('.home_slides .thumbnails #thumbnails_holder').animate({'margin-left': '0px'}, speed);
					$(this).addClass('disabled');
				}else{
					$('.home_slides .thumbnails #thumbnails_holder').animate({'margin-left': curr_pos+thumbs_step+'px'}, speed);
				}
			}
		})

		/*bg color of main elements and posts on home page*/
		var main_elements = $('#primary > .widget, #primary > #content');
		main_elements.filter(':odd').css({'background': "#eaebec"});
		main_elements.filter(':even').css({'background': "#f3f3f3"});
		main_elements.filter(':last').css({'background': "#fff"});

		/*posts decoration*/
		var posts = $('body #content .posts .post');
		posts.filter(':even').css({'background': "#dbdcdd"}).find('h1 > a').css({'color': '#F26E50'});;

		/*bg color of tabs*/
		$('.tab_wrapper').closest('.widget').css({'background-color': '#FFF'});

		/*last-child*/
		$('.post').last().css('border-bottom', 'none');

		/*display map on Contact page when JS is enabled*/
		$('#heading.contact_page').css('height', '330px');

		/*#home_info_full descritpion list items*/
		var features_li = $("#home_info_full .features li");
		features_li.each(function(){
			if($(this).hasClass("not_available")){
				$(this).text('Not available item');
				$(this).prepend("<span>-</span>");
				$(this).css({'color': '#adadad'});
			}else{
				$(this).prepend("<span>+<span>");
			}
		})		

		/*tabs*/
		$('.tab_block').hide();
		$('.tab_block.active').show();
		$(".tabs .tab").click(function(){
			if(!$(this).hasClass('active')){
				var new_active = $(this);
				var last_active = new_active.parent().find('.active');
				last_active.removeClass('active');
				var last_active_num = last_active.attr('class').substr((last_active.attr('class').length-1), 1);
				var new_active_num = new_active.attr('class').substr((new_active.attr('class').length-1), 1)
				new_active.addClass('active');
				$(".tab_block_"+last_active_num).hide();
				$(".home_content_tab").hide();
				$(".tab_block_"+new_active_num).show();
				$(".home_content_"+new_active_num).show().css('z-index', '1');
			}
		})
		//+
		$('.tab_add').click(function(){
			$('body').css('position', 'relative');
			$('body').prepend('<div id="background_holder"><div id="window"><p><b>Some Content</b><br/><span>Lorem ipsum dolor sit amet</span></p></div></div>');
			$('body #background_holder').fadeIn(200);
			$('body #background_holder').click(function(){
				$(this).fadeOut(200, function(){
					$(this).remove();
				});
			});
			$('#window').click(function(){return false;})
			return false;
		})
		/*shadow*/
		var shade = $('.tab_block').css('box-shadow');
		$('.home_content_tab').css('position', 'relative').prepend('<div class="cover"></div>');

		/*dragging*/
		var max_bedrooms = 5;
		var min_bedrooms = 1;
		var scroll_width = parseInt($('.scroller_start').width());
		var path_width = parseInt($('.search_options .scroller_body').width());
		var real_path_width = path_width - scroll_width;
		var step = real_path_width / (max_bedrooms - min_bedrooms);
		$('.scroller_start').draggable({
			containment: $('.scroller_path'),
			axis:'x',
			start: function(){
				
			},
			drag:function(){
				var left = parseInt($(this).css('left'));
				$('.scroller .scroller_path .scroller_body').css('margin-left', left+(scroll_width/2)+'px');
				var min = Math.round(min_bedrooms + left/step);
				$('.bedrooms input.min').attr({'value': min});
			}
		})
		$('.scroller_end').draggable({
			containment: $('.scroller_path'),
			axis:'x',
			drag:function(){
				var right = real_path_width - parseInt($(this).css('left'));
				$('.scroller .scroller_path .scroller_body').css('margin-right', right+(scroll_width/2)+'px');
				var max = Math.round(max_bedrooms - right/step);
				$('.bedrooms input.max').attr({'value': max});
			}
		})

		/* Placeholder for IE */
		if($.browser.msie) { // Условие для вызова только в IE
			var color = $('input').css('color');
			$("form").find("input[type='text'], input[type='password'], input[type='email'], textarea").each(function() {
				var tp = $(this).attr("placeholder");
				$(this).attr('value',tp).css('color', color);
			}).focusin(function() {
		 		var val = $(this).attr('placeholder');
				if($(this).val() == val) {
					$(this).attr('value','').css('color',color);
				}
			}).focusout(function() {
				var val = $(this).attr('placeholder');
				if($(this).val() == "") {
					$(this).attr('value', val).css('color',color);
				}
			});
			/* Protected send form */
			$("form").submit(function() {
				$(this).find("input[type='text'], input[type='password'], input[type='email'], textarea").each(function() {
					var val = $(this).attr('placeholder');
					if($(this).val() == val) {
						$(this).attr('value','');
					}
				})
			});
		}

		/* Height of #main_ and #min_ post blocks */
		var main_height = $('#main_post_block').height();
		var min_height = $('#min_post_block').height();
		if(main_height<min_height)
			$('#main_post_block').height(min_height);

		/* !!! links - tmp script for testing html template !!! */
		if($('#home_preview .home_preview').hasClass('agent_preview'))
			$('#home_preview .home_preview.agent_preview').wrap('<a href="agent.html" />');
		else
			$('#home_preview .home_preview').wrap('<a href="listing.html" />');
		/* !!! end of links !!! */
	});
})(jQuery);