<?php
class PitchNotify {

	public function fire($job, $data)
	{
		$pitch = Pitch::find($data['pitch']);
		if ($pitch) {
			Mail::send(['text' => 'emails.pitch'], ['pitch' => $pitch], function($m) use ($pitch)
			{
				$m->to('layotl@gmail.com', 'Watts Martin')
					->subject("[cnq] Pitch #{$pitch->id}")
					->from('noreply@clawandquill.net', 'Claw & Quill')
					->replyTo($pitch->email);
			});
		}
	}
}
