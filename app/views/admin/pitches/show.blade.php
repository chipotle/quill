@extends('layouts.admin')

@section('title') Pitch #{{ $pitch->id }} @endsection

@section('content')

<dl class="dl-horizontal">
  <dt>From</dt>
  @if ($pitch->author_id)
  <dd> {{ HTML::linkRoute('sysop.authors.show', $pitch->author->getPreferredName(), [$pitch->author->id]) }} &lt;{{ HTML::mailto($pitch->author->email) }}&gt;</dd>
  @else
  <dd>{{ $pitch->name }} &lt;{{ HTML::mailto($pitch->email) }}&gt;</dd>
  @endif
  <dt>Submitted</dt>
  <dd>{{ $pitch->created_at->toFormattedDateString() }}</dd>
  <dt>Updated</dt>
  <dd>{{ $pitch->updated_at->toFormattedDateString() }}</dd>
  <dt>Status</dt>
  @if ($pitch->story_id)
  <dd>{{ HTML::linkRoute('sysop.stories.show', Pitch::$statusList[$pitch->status], [$pitch->story_id]) }}</dd>
  @else
  <dd>{{ Pitch::$statusList[$pitch->status] }}</dd>
  @endif
</dl>

<div class="well" style="white-space:pre-line">{{ $pitch->blurb }}</div>

@if ($pitch->notes)
<h3>Notes</h3>
<p style="white-space:pre-line">{{ $pitch->notes }}</p>
<br>
@endif

<p>
  <a href="{{ URL::route('sysop.pitches.index') }}" class="btn"><i class="icon-backward"></i> Back</a>
  <a href="{{ URL::route('sysop.pitches.edit', [$pitch->id]) }}" class="btn"><i class="icon-edit"></i> Edit</a>
</p>
@endsection
