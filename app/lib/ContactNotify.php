<?php

class ContactNotify {

	/**
	 * Queue consumer for sending contact email
	 * @param  mixed $job  unused (always sent by Laravel)
	 * @param  array $data data from queue
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
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
