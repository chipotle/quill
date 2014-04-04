<?php
class PitchNotify {

	/**
	 * Queue consumer for sending pitch email
	 * @param  mixed $job  unused (always sent by Laravel)
	 * @param  array $data data from queue
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function fire($job, $data)
	{
		$pitch = Pitch::find($data['pitch']);
		if ($pitch) {
			Mail::send(['text' => 'emails.pitch'], ['pitch' => $pitch], function($m) use ($pitch)
			{
				$m->to(Config::get('quill.pitch.email'),Config::get('quill.pitch.name'))
					->subject("[cnq] Pitch #{$pitch->id}")
					->from(Config::get('quill.send.email'), Config::get('quill.send.name'))
					->replyTo($pitch->email);
			});
		}
	}
}
