<?php 
/*
Plugin Name: Guest Posts
Plugin URI: 
Description: This plugin is use to create custom post from frontend side.
Version: 1.0.0
Author: Sharry World
Author URI: 
License: GPLv2 or later
*/

if(! defined('ABSPATH')){
    die;
}
  

//  Start- Create form for Custom post submission 

function custompost_form_callback(){
        $allowed_roles=array('administrator','author');  
        $current_user = wp_get_current_user();
        $current_user_role=$current_user->roles[0];
    if(is_user_logged_in() &&  in_array($current_user_role, $allowed_roles) ){
        $post_types = get_post_types(array('public' => true,'_builtin' => false ));
        $customPostType="";

    foreach ($post_types as $post_type_name) {
        $customPostType.= "<option value='".$post_type_name."'>".$post_type_name."</option>";    
    }
    if($customPostType==""){
       $customPostType= "<option value='post'>Post</option>";
    }

        $formdata = '<div class="custom_post_page"><form action="creating_posts" id="form_cposts">
                      <div class="form-group">
                        <label for="posttitle">Post Title</label>
                        <input type="text" class="form-control" id="posttitle" placeholder="Post Title">
                        <span class="error-mess"></span>
                      </div>
                      <div class="form-group">
                        <label for="customposttypes">Select Any Custom Post Type</label>
                        <select class="form-control" id="customposttypes"><option value="none" selected disabled>Choose Any Post Type</option>'.$customPostType.'
                        </select>
                        <span class="error-mess"></span>
                      </div>
                      <div class="form-group">
                        <label for="postcontent">Post Content</label>
                        <textarea class="form-control" id="postcontent" rows="5"></textarea>
                        <span class="error-mess"></span>
                      </div>
                      <div class="form-group">
                        <label for="postexcerpt">Post Exerpt</label>
                        <textarea class="form-control" id="postexcerpt" rows="2"></textarea>
                        <span class="error-mess"></span>
                      </div>
                      <div class="form-group">
                        <label for="fimage">Featured Image</label>
                        <input type="file" class="form-control-file" id="fimage" accept="image/*" >
                      </div>
                        <p class="status"></p>
                         <div>
                            <input type="button" value="Submit Post" class="btn btn-primary" id="submit_cpost">
                         </div>
                    </form></div>';
    }else{

        $formdata='<div class="alert alert-warning" role="alert">Please login first to create post from frontend.</div>';
    }   
    return $formdata;
}

add_shortcode('createpost_form', 'custompost_form_callback'); 

// Start- Shortcode to show custom posts added by authors
add_shortcode('customposts', 'list_pending_posts_callback'); 

function list_pending_posts_callback( $atts){

    if($atts['posttype'] ){
        $postype=$atts['posttype'];
    }else{
        return "Please mention posttype in Shortcode ";
    }

  $args =   array(
                  'post_type'         => $postype,
                  'posts_per_page'    => 10,
                  //'post_status'       => $status,  
                  'paged' => get_query_var('paged') ? get_query_var('paged') : 1      
                );  
                    if($atts['status'] ){
                         $args['post_status']=$atts['status'];
                        }else{ 
                            $args['post_status']='publish';
                        }

                    if($atts['authorid'] ){
                         $args['author']=$atts['authorid'];
                        }
                      $pending_posts = new WP_Query($args);
    $listview='<div class="list-group">';
            if ( $pending_posts->have_posts() ) :
                    while ( $pending_posts->have_posts() ) :
                                    $pending_posts->the_post(); 
                                    $listview.='<a href="'.get_permalink().'" class="list-group-item list-group-item-action flex-column align-items-start ">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">'.get_the_title().'</h5>
                                        <small>'.get_the_date(). '( '.get_post_status ().' ) </small>

                                    </div>
                                    <p class="mb-1">'.wpautop(get_the_excerpt()).'</small></a>';
                    endwhile;
               
    $listview.='</div>';
                $pagination='<nav aria-label="..."><ul class="pagination pagination-lg">';
                $paginate_links = pendingposts_get_paginated_links( $pending_posts );
                    if($paginate_links){
                    foreach($paginate_links as $link){
                      $selected_class = '';
                      if( $link->isCurrent){
                        $selected_class = 'disabled';
                      }
                      $pagination .= '<li class="page-item '.$selected_class.'"><a href="'.$link->url.'" class="page-link"> '.$link->page.' </a></li>';
                    }}
                  $pagination.='</ul></nav>'; 
    $listview.= $pagination;
             endif;        
return $listview;

}



// paginationn links
function pendingposts_get_paginated_links( $query ) {
    // When we're on page 1, 'paged' is 0, but we're counting from 1,
    // so we're using max() to get 1 instead of 0
    $currentPage = max( 1, get_query_var( 'paged', 1 ) );
 
    // This creates an array with all available page numbers, if there
    // is only *one* page, max_num_pages will return 0, so here we also
    // use the max() function to make sure we'll always get 1
    $pages = range( 1, max( 1, $query->max_num_pages ) );
 
    // Now, map over $pages and return the page number, the url to that
    // page and a boolean indicating whether that number is the current page
    return array_map( function( $page ) use ( $currentPage ) {
        return ( object ) array(
            "isCurrent" => $page == $currentPage,
            "page" => $page,
            "url" => get_pagenum_link( $page )
        );
    }, $pages );
}






// Start- callback function to create custom post using ajax
add_action('wp_ajax_createpostbyfrontend','create_post_by_frontend_callback');


function create_post_by_frontend_callback(){
    check_ajax_referer('create_custom_post', 'security');
        $allowed_roles=array('administrator','author');  
        $current_user = wp_get_current_user();
        $current_user_role=$current_user->roles[0];
    if(!is_user_logged_in() &&  !in_array($current_user_role, $allowed_roles) ){
        echo json_encode(array('flag'=>'failure','message'=> 'Invalid Login' ));
            die;
    }

     if(trim($_POST["post_title"] == '' ) || trim($_POST["custom_posttypes"] == '' )  || $_POST["post_content"] == ''   || trim($_POST["post_excerpt"] == '' ) ){
            echo json_encode(array('flag'=>'failure','message'=> 'Please input the all fields' ));
            die;
    } else {

        $post_title    = esc_attr($_POST["post_title"]);
        $custom_posttype    = esc_attr($_POST["custom_posttypes"]);
        $post_content    = esc_attr($_POST["post_content"]);
        $post_excerpt     = esc_attr($_POST["post_excerpt"]);
        $file_obj=$_FILES['file'];
        $ftrd_image='';
        if($file_obj){
            $ftrd_image = $_FILES['file']['name'];
        }

        $new_post = array(
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_excerpt' =>$post_excerpt,
            'post_status' => 'draft',
            'post_type' => $custom_posttype,
        );

        $pid = wp_insert_post($new_post);
        if(!$pid){
            $res=array("flag"=>"failure","message"=>"Error in while creating post!" );
            echo json_encode($res);
            die();
        }

        if (!function_exists('wp_generate_attachment_metadata'))
        {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }

        if ($_FILES)
        {
            foreach ($_FILES as $file => $array)
            {
               
                $attach_id = media_handle_upload( $file, $pid );
            }
        }

        if ($attach_id > 0)
        {
            update_post_meta($pid, '_thumbnail_id', $attach_id);
        }

        $my_post1 = get_post($attach_id);
        $my_post2 = get_post($pid);
        $custom_post = array_merge($my_post1, $my_post2);
         $mail_body="There is Post ".$post_title." has been created. Please check it via admin dashboard. ";
         $notify_mail=sendmail($mail_body);

        $res=array("flag"=>"success","message"=>"A post has been created successfully." );
        echo json_encode($res);
        die;

    }


   
    die();
}


 // Mailer function to send notify email to admin 
function sendmail($mail_body){

    $admin_email = get_option( 'admin_email' ); 
    $to = $admin_email;
    $subject = 'New Post Created!';
    $body = $mail_body;
    $mailResult=wp_mail( $to, $subject, $body );
    return $mailResult;
}


function guestplugin_register_settings() {
   register_setting( 'guestplugin_options_group', 'guestplugin_option_name', 'guestplugin_callback' );
}
add_action( 'admin_init', 'guestplugin_register_settings' );

function guestplugin_register_options_page() {
  add_options_page('Page Title', 'Custom Post submission', 'manage_options', 'guestplugin', 'guestplugin_options_page');
}
add_action('admin_menu', 'guestplugin_register_options_page');

function guestplugin_options_page()
{ ?>
    <h2>Shortcodes</h2>
        <div class="card" style="width: 36rem;">
              <div class="card-body">
                <h3 class="card-title">[createpost_form]</h3>
                <p class="card-text">Use this shortcode to show form for custom post submission.</p>
              </div>
        </div>
        <div class="card" style="width: 36rem;">
              <div class="card-body">
                <h3 class="card-title">[customposts posttype=guest status=draft authorid=1]</h3>
                    <h5 class="card-subtitle mb-2 text-muted">posttype : this is required field</h5>
                    <h5 class="card-subtitle mb-2 text-muted">status (publish,draft,pending,private) : Optional (default: publish)</h5>
                    <h5 class="card-subtitle mb-2 text-muted">authorid :Optional (default: show all posts including all authors)</h5>
                <p class="card-text">Use this shortcode to show custom posts added by authors.</p>
        </div>
        </div>
        <div class="card" style="width: 50rem;">
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        Note: Email are working only when you on server. For localhost please use smtp plugins.
                    </div>
                </div>
        </div>
        
<?php }


// Start- Enqueue Styles and Js 
function gp_signup_styles() {
    wp_enqueue_style('gp-bootstrap-min-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
    wp_enqueue_script( 'gp-jquery','https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array('jquery'));
    wp_enqueue_script( 'gp-popper-min-js','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'));
    wp_enqueue_script( 'gp-bootstrap-min-js','https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script( 'guest-index',  plugin_dir_url( __FILE__ ) . 'js/guest-index.js', array('jquery') , '', true );  

     wp_localize_script( 'guest-index', 'creatpost_obj', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'siteurl' => site_url(),
        'adminurl' => admin_url(),
        'security' => wp_create_nonce( 'create_custom_post' ),
       
    ));
        
}

add_action( 'wp_enqueue_scripts', 'gp_signup_styles' );



