<?php

class Admin_PitchesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$show_all = (Input::get('show_all') == 1);
		if ($show_all) {
			$pitches = Pitch::orderBy('updated_at', 'desc')->paginate(15);
		}
		else {
			$pitches = Pitch::pending()->orderBy('updated_at', 'desc')->paginate(15);
		}
		return View::make('admin.pitches.index')->with([
			'pitches' => $pitches,
			'show_all' => $show_all
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pitch = Pitch::findOrFail($id);
		return View::make('admin.pitches.show')->with('pitch', $pitch);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pitch = Pitch::findOrFail($id);
		$menu = Pitch::$statusList;
		if ($pitch->status == Pitch::UNSEEN) {
			unset($menu[Pitch::WAITING]);
			unset($menu[Pitch::PUBLISHED]);
		}
		return View::make('admin.pitches.edit')->with([
			'pitch' => $pitch,
			'menu' => $menu
		]);
		return View::make('admin.pitches.edit')->with('pitch', $pitch);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$pitch = Pitch::find($id);
		$validator = Validator::make($input, [
			'email' => 'required|email',
			'name' => 'required',
			'blurb' => 'required'
		]);
		if ($validator->fails()) {
			Session::flashInput($input);
			return Redirect::route('sysop.pitches.edit', [$id])->with('error', $validator->messages());
		}
		$pitch->fill($input);
		if ($pitch->status == Pitch::UNSEEN) {
			$pitch->status = Pitch::REVIEW;
		}
		$msg = "Pitch #{$pitch->id} updated.";
		if ($pitch->status == Pitch::ACCEPTED && !$pitch->author_id) {
			$a = new Author();
			$a->name = $pitch->name;
			$a->email = $pitch->email;
			$a->save();
			$pitch->author_id = $a->id;
			$msg .= "<br>Author '{$a->name}' created with ID {$a->id}.";
		}
		$pitch->save();
		return Redirect::route('sysop.pitches.index')->with('msg', $msg);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pitch = Pitch::find($id);
		$pitch->delete();
		Session::flash('msg', "Pitch '{$pitch->id}' deleted!");
		$response = ['redirect'=>URL::route('sysop.pitches.index')];
		return Response::json($response);
	}

}
