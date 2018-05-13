function send_to_databese(question_id,special_prefix){
	if(typeof(question_id)=='undefined' || typeof(question_id)=='undefined'){
		alert('error');
		return;
	}
	var_main_element=jQuery('.poll_main_div_'+special_prefix+'.poll_min_div_cur_answer_'+question_id)
	date={};
	date_answers={};
	date['question_id']=question_id;
	date['poll_answer_securety']=poll_varables.poll_answer_securety;
	
	var k=0;
	var_main_element.find('input:checked').each(function(index, element) {
        date_answers[k]=jQuery(this).val()
		k++;
    });
	date['date_answers']=date_answers;
	jQuery.ajax({
	  type: "POST",
	  url:poll_varables.admin_ajax_url+'?action=pollinsertvalues',
	  data: date
	}).done(function(data) {		
		answers_object = JSON.parse(data);
		 all_count=0;		
		for (var key in answers_object) {
			 all_count= all_count+parseInt(answers_object[key]['vote']);
		}
		if(!all_count)
			all_count=0.00001;		
		jQuery('.poll_min_div_cur_answer_'+question_id).each(function(index, element) {
			loc_this=this;
			for (var key in answers_object) {
				jQuery(loc_this).find(	'.poll_element_'+answers_object[key]['answer_name'] +' .poll_span_voted_count').html(answers_object[key]['vote']+' Vote')
				jQuery(loc_this).find(	'.poll_element_'+answers_object[key]['answer_name'] +' .pracents_of_the_poll').css('width',(100*(answers_object[key]['vote']/all_count)+'%'))
			}
           
        });
	});
}
function clicked_in_poll_div(element,question_id,special_prefix){
	jQuery(element).parent().parent().find('input').prop('checked',!jQuery(element).parent().parent().find('input').prop('checked'));
	send_to_databese(question_id,special_prefix);	
}
