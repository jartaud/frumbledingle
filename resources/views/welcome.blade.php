@extends('layouts.main')

@section('page_title')
README
@endsection

@section('content')
    <div class="mt-5">
        {!! (new \Parsedown())->text(file_get_contents(base_path() . '/readme.md')) !!}
    </div>
@endsection

@section('xtra-scripts')
    <script>
        $(function() {
            $("table")
                .wrap('<div class="table-responsive"></div>')
                .addClass("table table-striped table-bordered")
        })
    </script>
@endsection