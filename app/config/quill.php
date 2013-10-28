<?php

return array(

	// name and email address to send pitches to
	'pitch' => array(
		'name'  => 'Watts Martin',
		'email' => 'layotl+cq@gmail.com',
	),

	// name and email address to send contacts to
	'contact' => array(
		'name'  => 'Watts Martin',
		'email' => 'layotl+cq@gmail.com',
	),

	// Sending names
	'send' => array(
		'name'  => 'Claw & Quill',
		'email' => 'noreply@clawandquill.net',
	),

	// image upload directory
	'upload_dir' => (App::environment() == 'production') ? '/opt/nginx/sites/quill/shared/system/images/%s/' : public_path() . '/system/images/%s/',

);
