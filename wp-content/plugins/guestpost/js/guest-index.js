jQuery( document ).ready(function() {

var post_title       =jQuery('#posttitle');
var customposttypes  =jQuery('#customposttypes :selected').val();
var postcontent      =jQuery('#postcontent');
var postexcerpt      =jQuery('#postexcerpt');
var fimage=jQuery('#fimage');

console.log(customposttypes);
    post_title.click(function(){
           jQuery('#posttitle ~ span:first').text("");

        });
    postcontent.click(function(){
           jQuery('#postcontent ~ span:first').text("");

        });
    postexcerpt.click(function(){
           jQuery('#postexcerpt ~ span:first').text("");

        });





	/* Form Validation */
	jQuery('#submit_cpost').click(function(){ 
		
		if(jQuery('#posttitle').val()==''){
			jQuery('#posttitle ~ span:first').text("Post Title can't be empty!");
			return;
		}		
        if(jQuery('#customposttypes :selected').val()=='none'){
        		jQuery('#customposttypes ~ span:first').text("Custom Post Type can't be empty!");
    		return;
       	}
        if(jQuery('#postcontent').val()==''){
            jQuery('#postcontent ~ span:first').text("Post Content can't be empty!");
        return;
        }

        if(jQuery('#postexcerpt').val()==''){
            jQuery('#postexcerpt ~ span:first').text("Post Excerpt can't be empty!");
        return;
        }

         var ft_image=  jQuery('#fimage')[0].files[0]
         if(ft_image==undefined){
            ft_image='';
         }
    	
        custom_post_data = new FormData();
        custom_post_data.append('file', ft_image);
        custom_post_data.append('action', 'createpostbyfrontend');
        custom_post_data.append('post_title', jQuery('#posttitle').val());
        custom_post_data.append('custom_posttypes', jQuery('#customposttypes :selected').val());
        custom_post_data.append('post_content',  jQuery('#postcontent').val());
        custom_post_data.append('post_excerpt', jQuery('#postexcerpt').val());
        custom_post_data.append('security', creatpost_obj.security);

       /* var custom_post_data = { 
          	'action'        : 'createpostbyfrontend', 
          	'post_title'   : jQuery('#posttitle').val(),
          	'custom_posttypes'   : jQuery('#customposttypes :selected').val(),
          	'post_content'    : jQuery('#postcontent').val(),
            'post_excerpt'   : jQuery('#postexcerpt').val(),
          	'fimage'    : ft_image,
        }*/

		    console.log(custom_post_data);

        jQuery.ajax({
            dataType: 'json',
            url	   : creatpost_obj.ajaxurl,
            type   : 'POST',
            contentType: false,
            processData: false,
            data   : custom_post_data,
            beforeSend: function() {
             	jQuery("#submit_cpost").hide();
                jQuery( "#form_cposts p.status" ).removeClass( "red_message" );
                jQuery("#form_cposts p.status").removeClass("green_message");
                jQuery("#form_cposts p.status").text("Sending...")
            },
            success: function(response) {  
                    
                if (response.flag == 'success') {
                    
                        jQuery( "#form_cposts p.status" ).removeClass( "red_message" );
                        jQuery("#form_cposts p.status").addClass("green_message");
                        alert(response.message);
                        jQuery("#form_cposts p.status").text("Redirecting...");
                        window.location.reload();
                    
                }else if(response.flag == 'failure'){
                    jQuery("#form_cposts p.status").addClass("red_message");
                    jQuery("#form_cposts p.status").text(response.message);
                    jQuery("#submit_cpost").show();
                }
            }
        });
    });  

});