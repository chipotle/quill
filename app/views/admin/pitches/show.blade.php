@extends('layouts.admin')

@section('title') Pitch #{{ $pitch->id }} @endsection

@section('content')

<dl class="dl-horizontal">
  <dt>From</dt>
  <dd>{{ $pitch->name }} &lt;{{ $pitch->email }}&gt;</dd>
  <dt>Submitted</dt>
  <dd>{{ Html::date_fmt($pitch->created_at, 'd-M-y H:i') }}</dd>
  <dt>Updated</dt>
  <dd>{{ Html::date_fmt($pitch->updated_at, 'd-M-y H:i') }}</dd>
  <dt>Status</dt>
  <dd>{{ Pitch::$statusList[$pitch->status] }}</dd>
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
