
        var updateText = 'Loading ...';
        var resultBlock = 'appartment_box';
        var bg_img = '/starlightadmin-20/themes/classic/images/pages/opacity.png';

        var useGoogleMap = 0;
        var useYandexMap = 0;
        var useOSMap = 1;

        var modeListShow = 'block';

		$(function () {
			$('div#appartment_box').on('mouseover mouseout', 'div.appartment_item', function(event){
				if (event.type == 'mouseover') {
				 $(this).find('div.apartment_item_edit').show();
				} else {
				 $(this).find('div.apartment_item_edit').hide();
				}
			});
		});

        function setListShow(mode){
            modeListShow = mode;
            reloadApartmentList(urlsSwitching[mode]);
        };


        $(function () {
            if(modeListShow == 'map'){
                list.apply();
            }
        });
    