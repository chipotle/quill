@extends('layouts.admin')

@section('title') Authors @endsection

@section('content')

<table class="table table-striped">
  <thead>
    <tr>
      <th style="width:10%">Action</th>
      <th>Name</th>
      <th>Nickname</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
@foreach ($authors as $author)
    <tr>
      <td style="width:10%;white-space:nowrap">
        <a href='{{ URL::route("sysop.authors.edit", [$author->id]) }}' title="Edit Info" class="btn"><i class="icon-edit"></i></a>
      </td>
      <td>{{ HTML::linkRoute('sysop.authors.show', $author->name, [$author->id], ['title'=>'Show stories/pitches']) }}</td>
      <td>{{ $author->nickname }}</td>
      <td>{{ HTML::mailto($author->email) }}</td>
    </tr>
@endforeach
  </tbody>
</table>

<a href='{{ URL::route("sysop.authors.create") }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
@endsection
