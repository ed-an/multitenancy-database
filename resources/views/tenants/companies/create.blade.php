@extends('tenants.layouts.app')

@section('content')
    <h1>Nova empresa</h1>
    <form method="post" action="{{route('company.store')}}">
        {{csrf_field()}}
    @include('tenants.companies._form')
    <button type="submit" class="btn btn-default">Criar</button>
@endsection
