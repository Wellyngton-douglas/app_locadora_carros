@extends('layouts.app')

@section('content')
    {{-- instancia do componente login --}}
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endsection
