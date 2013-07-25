@extends('layouts.admin')

@section('title') Stories @endsection

@section('content')

<table class="table table-striped">
  <thead>
    <tr>
      <th style="width:10%">Action</th>
      <th>Issue</th>
      <th>Title</th>
      <th>Author</th>
    </tr>
  </thead>
  <tbody>
@foreach ($stories as $story)
    <tr>
      <td style="width:10%;white-space:nowrap">
        <a href='{{ URL::route("sysop.stories.edit", [$story->id]) }}' title="Edit" class="btn"><i class="icon-edit"></i></a>
        <a href='{{ URL::route("sysop.stories.show", [$story->id]) }}' title="Preview" class="btn"><i class="icon-eye-open"></i></a>
      </td>
      <td>{{ $story->number }}</td>
      <td>{{ $story->title }}</td>
      <td>{{ HTML::mailto($story->email, $story->name) }}</td>
    </tr>
@endforeach
  </tbody>
</table>

<a href='{{ URL::route("sysop.stories.create") }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
@endsection
