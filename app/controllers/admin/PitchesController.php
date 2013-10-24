<?php namespace Admin;

class PitchesController extends \BaseController {

	protected $pitch;

	function __construct(\Pitch $pitch)
	{
		$this->pitch = $pitch;
	}
	/**
	 * Display a listing of pitches.
	 *
	 * @return Response
	 */
	public function index($show=false)
	{
		if ($show) {
			$pitches = $this->pitch->orderBy('updated_at', 'desc')->paginate(15);
		}
		else {
			$pitches = $this->pitch->pending()->orderBy('updated_at', 'desc')->paginate(15);
		}
		return \View::make('admin.pitches.index')->with([
			'pitches' => $pitches,
			'show' => $show
		]);
	}

	/**
	 * Display a pitch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pitch = $this->pitch->findOrFail($id);
		return \View::make('admin.pitches.show')->with('pitch', $pitch);
	}

	/**
	 * Show the form for editing a pitch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pitch = $this->pitch->findOrFail($id);
		$menu = \Pitch::$statusList;
		if (! in_array($pitch->status, [\Pitch::ACCEPTED, \Pitch::WAITING, \Pitch::PUBLISHED])) {
			unset($menu[\Pitch::WAITING]);
			unset($menu[\Pitch::PUBLISHED]);
		}
		return \View::make('admin.pitches.edit')->with([
			'pitch' => $pitch,
			'menu' => $menu
		]);
	}

	/**
	 * Update the specified pitch in storage. This also creates or assigns
	 * an author object to a pitch and turns the pitch into a new story
	 * object.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = \Input::all();
		$pitch = $this->pitch->find($id);
		$validator = \Validator::make($input, [
			'email' => 'required|email',
			'name' => 'required',
			'blurb' => 'required'
		]);
		if ($validator->fails()) {
			\Session::flashInput($input);
			return \Redirect::route('sysop.pitches.edit', [$id])->with('error', $validator->messages());
		}
		$pitch->fill($input);
		if ($pitch->status == \Pitch::UNSEEN) {
			$pitch->status = \Pitch::REVIEW;
		}
		$msg = "Pitch #{$pitch->id} updated.";
		$to_story = false;
		if ($pitch->status == \Pitch::ACCEPTED) {
			if (! $pitch->author_id) {
				$a = \App::make('Author')->create(['name' => $pitch->name,
					'email' => $pitch->email]);
				$pitch->author_id = $a->id;
				$msg .= " Author {$a->name} created.";
			}
			if (! $pitch->story_id) {
				$s = \App::make('Story')->create([
					'title' => "{$pitch->name}'s New Story",
					'author_id' => $pitch->author_id,
					'blurb' => $pitch->blurb, 'body' => 'Lorem ipsum']);
				$pitch->story_id = $s->id;
				$msg .= " Story created.";
				$to_story = true;
			}
		}
		$pitch->save();
		if ($to_story) {
			return \Redirect::route('sysop.stories.edit', [$pitch->story_id])->with('msg', $msg);
		}
		return \Redirect::route('sysop.pitches.index')->with('msg', $msg);
	}

	/**
	 * Remove the specified pitch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pitch = $this->pitch->find($id);
		$pitch->delete();
		\Session::flash('msg', "Pitch '{$pitch->id}' deleted!");
		$response = ['redirect'=>\URL::route('sysop.pitches.index')];
		return \Response::json($response);
	}

}
