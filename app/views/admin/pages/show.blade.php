@extends('layouts.admin')

@section('content')

<p style="text-align:center;color:#999;border-bottom:#999 1px solid;font-style:italic">Preview: {{ $title }}</p>

{{ $body }}

<p>
    <a href="{{ URL::route('sysop.pages.index') }}" class="btn"><i class="icon-backward"></i> Back</a>
    <a href="{{ URL::route('sysop.pages.edit', [$id]) }}" class="btn"><i class="icon-edit"></i> Edit</a>
</p>
@endsection