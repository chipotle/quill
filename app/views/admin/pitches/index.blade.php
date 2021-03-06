@extends('layouts.admin')

@section('title')
@if ($show)
All
@else
Pending
@endif
Pitches
@endsection

@section('content')

<p class="text-right">
  @if ($show)
  <a href="/sysop/pitches" class="btn">Pending Only</a>
  @else
  <a href="/sysop/pitches/all" class="btn">Show All</a>
  @endif
</p>

<table class="table table-striped center-row">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>#</th>
      <th>Date</th>
      <th>From</th>
      <th>Email</th>
      <th>Status</th>
      <th>Pitch</th>
    </tr>
  </thead>
  <tbody>
@foreach ($pitches as $pitch)
    <tr>
      <td><a href='{{ URL::route("sysop.pitches.edit", [$pitch->id]) }}' title="Edit" class="btn"><i class="icon-edit"></i></a></td>
      <td>{{ $pitch->id }}</td>
      <td>{{ $pitch->created_at->toDateString() }}</td>
      @if ($pitch->author_id)
      <td><b>{{ HTML::linkRoute('sysop.authors.show', $pitch->author->name, [$pitch->author_id]) }}</b></td>
      @else
      <td>{{ HTML::linkRoute('sysop.pitches.show', $pitch->name, [$pitch->id]) }}</td>
      @endif
      <td>{{ HTML::mailto($pitch->email) }}</td>
      <td>{{ Pitch::$statusList[$pitch->status] }}</td>
      <td style="height:1em;overflow:hidden">{{ HTML::linkRoute('sysop.pitches.show', HTML::truncate($pitch->blurb), [$pitch->id]) }}</td>
    </tr>
@endforeach
  </tbody>
</table>

{{ $pitches->links() }}

@endsection
