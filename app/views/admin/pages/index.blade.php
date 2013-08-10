@extends('layouts.admin')

@section('title') Static Pages @endsection

@section('content')

<table class="table table-striped center-row">
  <thead>
    <tr>
      <th>Action</th>
      <th>Page URL</th>
      <th>Title</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
@foreach ($pages as $page)
    <tr>
      <td style="width:10%;white-space:nowrap">
        <a href='{{ URL::route("sysop.pages.edit", [$page->id]) }}' title="Edit" class="btn"><i class="icon-edit"></i></a>
        <a href='{{ URL::route("sysop.pages.destroy", [$page->id]) }}' title="Delete" class="btn btn-danger delete" data-page="{{ $page->slug }}"><i class="icon-remove icon-white"></i></a>
      </td>
      <td style="vertical-align:middle">{{ HTML::linkRoute('sysop.pages.show', $page->slug, [$page->id]) }}</td>
      <td style="vertical-align:middle">{{ HTML::linkRoute('sysop.pages.show', $page->title, [$page->id]) }}</td>
      <td>
@if ($page->is_visible)
        <i class="icon-eye-open" title="Visible"></i>
@else
        <i class="icon-eye-close" title="Hidden"></i>
@endif
      </td>
    </tr>
@endforeach
  </tbody>
</table>

<a href='{{ URL::route("sysop.pages.create") }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
@endsection

@section('scripts')
<script>
$(function(){
  $('.delete').on('click', function(event) {
    var href = $(this).attr('href');
    var page = $(this).data('page');
    if (confirm('Delete "' + page + '"?')) {
      $.ajax({
        url: href,
        type: 'delete',
        dataType: 'json',
        success: function(response) {
          if (response.alert) {
            alert(response.alert);
          }
          if (response.reload) {
            window.location.reload(true);
          }
          else if (response.redirect) {
            window.location.replace(response.redirect);
          }
        }
      });
    }
    return false;
  });
});
</script>
@endsection
