@extends('layouts.admin')

@section('title') Images @endsection

@section('content')

<table class="table table-striped center-row">
  <thead>
    <tr>
      <th style="width:10%">Action</th>
      <th>Name</th>
      <th>Alt Text</th>
    </tr>
  </thead>
  <tbody>
@foreach ($images as $image)
    <tr>
      <td style="width:10%;white-space:nowrap">
        <a href='{{ URL::route("sysop.images.edit", [$image->id]) }}' title="Edit Info" class="btn"><i class="icon-edit"></i></a>
      </td>
      <td>{{ HTML::linkRoute('sysop.images.show', $image->name, [$image->id]) }}</td>
      <td>{{ $image->alt_text }}</td>
    </tr>
@endforeach
  </tbody>
</table>

<a href='{{ URL::route("sysop.images.create") }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
@endsection
