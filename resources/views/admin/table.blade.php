@extends('layouts.app')
@section('content')
@include('layouts.headers.tables')
    
    
@endsection
@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
       <script src="{{ asset('argon') }}/vendor/js-cookie/js.cookie.js"></script>
          <script src="{{ asset('argon') }}/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
@endpush
