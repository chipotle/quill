<?php

return array(

	// name and email address to send pitches to
	'pitch' => array(
		'name'  => 'Watts Martin',
		'email' => 'layotl+cq@gmail.com',
	),

	// image upload directory
	'upload_dir' => (App::environment() == 'production') ? '/opt/nginx/sites/quill/shared/system/images/%s/' : public_path() . '/system/images/%s/',

);
