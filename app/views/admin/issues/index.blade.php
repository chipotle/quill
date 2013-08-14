@extends('layouts.admin')

@section('title') Issues @endsection

@section('content')

<table class="table table-striped center-row">
  <thead>
    <tr>
      <th style="width:10%">Action</th>
      <th>Num</th>
      <th>Date</th>
      <th>Title</th>
      <th>Published?</th>
    </tr>
  </thead>
  <tbody>
@foreach ($issues as $issue)
    <tr>
      <td style="width:10%;white-space:nowrap">
        <a href='{{ URL::route("sysop.issues.edit", [$issue->id]) }}' title="Edit Metadata" class="btn"><i class="icon-edit"></i></a>
        <a href='{{ URL::route("sysop.issues.show", [$issue->id]) }}' title="Contents" class="btn"><i class="icon-list"></i></a>
      </td>
      <td>{{ $issue->volnum() }}</td>
      <td>{{ $issue->pub_date }}</td>
      <td>{{ $issue->title }}</td>
      <td>
@if ($issue->is_published)
        <i class="icon-ok" title="Published"></i>
@else
        <a class="btn" href="{{ URL::route('sysop.issues.publish', [$issue->id]) }}">Publish</a>
@endif
      </td>
    </tr>
@endforeach
  </tbody>
</table>

<a href='{{ URL::route("sysop.issues.create") }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
@endsection
