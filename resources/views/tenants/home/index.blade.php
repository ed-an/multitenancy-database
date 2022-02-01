@extends('tenants.layouts.main')

@section('content')
<h1>Recursos de tenants</h1>
    <a href="{{ route('company.index') }}">
        <img src="{{asset('imgs/companies.jpg')}}" alt="Empresas">
    </a>
@endsection
