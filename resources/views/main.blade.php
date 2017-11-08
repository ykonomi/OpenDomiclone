@extends('layouts.app')
@section('content')
<front my_id="{{Auth::id()}}" start_id="{{$start_id}}"></front>
@endsection
