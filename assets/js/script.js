jQuery(document).ready(function($)
{
	$("img.mardell_main_image[usemap]").rwdImageMaps();

	$('img.mardell_main_image').maphilight();
    
    var mardell_preloader = '<div id="mardell_preloader"><img src="http://www.arabianbusiness.com/skins/ab.main/gfx/loading_spinner.gif" /></div>';

	$("#map area").click( function () {
      
		var clickedArea = $(this);
		var ajaxUrl = $("#ajaxUrl").val();
		
		$("area.mardell_coords").mouseout();

		var postid = $(this).attr("id");
        
        $("#mardell_location_content").html(mardell_preloader);

		$.ajax({
			url : ajaxUrl ,
			type: "POST" ,
			dataType: "json" ,
			data: {
				action : 'ajax_action' ,
				postid : postid
			},
			success: function(data)
			{
							
					var location_name = data.catname;
					var title = data.title.toString().split(",");
					var content = data.content.toString().split(",");
					var divContent = "";

					divContent += "<h1>" + location_name + "<h1>";

					if (data.count > 0)
					{		
						for (var i = 0 ; i < title.length ; i++)
						{

							divContent += "<h3>" + title[i] + "</h3>";
							divContent += "<h5>" + content[i] + "</h5>";
						}
					}
					else
					{
						divContent += "<h3>There are currently no stores available in this location</h3>";
					}

					$("#mardell_location_content").html(divContent);

				    $('#map area').each(function() {
						hData = $(this).data('maphilight') || {}; // get
						hData.alwaysOn = $(this).is(clickedArea); // modify
						$(this).data('maphilight', hData ).trigger('alwaysOn.maphilight'); // set
					});

			}
		});
	

        return false;
    });

});