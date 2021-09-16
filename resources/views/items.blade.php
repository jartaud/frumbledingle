@extends('layouts.main')

@section('page_title')
    Items
@endsection

@section('content')
<items-table 
    :locations='{!! json_encode($locations) !!}'
    :categories='{!! json_encode($categories, true) !!}'
/>
@endsection