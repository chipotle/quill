<?php

class ContactNotify {

	public function fire($job, $data)
	{
		Mail::send(['text' => 'emails.contact'], $data, function($m) use ($data) {
			$reply_to = $data['email'] ?: Config::get('quill.send.email');
			$m->to(Config::get('quill.contact.email'), Config::get('quill.contact.name'))
				->subject("[cnq] Contact from {$data['name']}")
				->from(Config::get('quill.send.email'), Config::get('quill.send.name'))
				->replyTo($reply_to);
		});
	}
}
