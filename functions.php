<?php 

// Remove Comments Form Fields
function website_remove($fields){

	if(isset($fields['url']))
	unset($fields['url']);

	return $fields;
}
add_filter('comment_form_default_fields', 'website_remove');



// Get Comments Author Link 
function force_comment_author_url($comment)
{
    // does the comment have a valid author URL?
    $no_url = !$comment-&gt;comment_author_url || $comment-&gt;comment_author_url == 'http://';

    if ($comment-&gt;user_id &amp;&amp; $no_url) {
        // comment was written by a registered user but with no author URL
        $comment-&gt;comment_author_url = 'http://localhost/cftea/?author=' . $comment-&gt;user_id;
    }
    return $comment;
}
add_filter('get_comment', 'force_comment_author_url');

 
// Below Textarea of Comments form
function crunchify_move_comment_form_below( $fields ) { 
    $comment_field = $fields['comment']; 
    unset( $fields['comment'] ); 
    $fields['comment'] = $comment_field; 
    return $fields; 
} 
add_filter( 'comment_form_fields', 'crunchify_move_comment_form_below' ); 

// Add Comments Placeholder 
function my_update_comment_fields( $fields ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$label     = $req ? '*' : ' ' . __( '(optional)', 'text-domain' );
	$aria_req  = $req ? "aria-required='true'" : '';

	$fields['author'] =
		'&lt;p class="comment-form-author"&gt;
			&lt;label for="author"&gt;' . __( "Name", "text-domain" ) . $label . '&lt;/label&gt;
			&lt;input id="author" name="author" type="text" placeholder="' . esc_attr__( "Jane Doe", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30" ' . $aria_req . ' /&gt;
		&lt;/p&gt;';

	$fields['email'] =
		'&lt;p class="comment-form-email"&gt;
			&lt;label for="email"&gt;' . __( "Email", "text-domain" ) . $label . '&lt;/label&gt;
			&lt;input id="email" name="email" type="email" placeholder="' . esc_attr__( "name@email.com", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
		'" size="30" ' . $aria_req . ' /&gt;
		&lt;/p&gt;';

	$fields['url'] =
		'&lt;p class="comment-form-url"&gt;
			&lt;label for="url"&gt;' . __( "Website", "text-domain" ) . '&lt;/label&gt;
			&lt;input id="url" name="url" type="url"  placeholder="' . esc_attr__( "http://google.com", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" /&gt;
			&lt;/p&gt;';

	return $fields;
}
add_filter( 'comment_form_default_fields', 'my_update_comment_fields' );

function my_update_comment_field( $comment_field ) {

  $comment_field =
    '&lt;p class="comment-form-comment"&gt;
            &lt;label for="comment"&gt;' . __( "Comment", "text-domain" ) . '&lt;/label&gt;
            &lt;textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Enter comment here...", "text-domain" ) . '" cols="45" rows="8" aria-required="true"&gt;&lt;/textarea&gt;
        &lt;/p&gt;';

  return $comment_field;
}
add_filter( 'comment_form_field_comment', 'my_update_comment_field' );