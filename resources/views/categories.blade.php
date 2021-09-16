@extends('layouts.main')

@section('page_title')
    Categories
@endsection

@section('content')
<categories-table 
    :parent-categories='{!! json_encode($categories, true) !!}'
/>
@endsection