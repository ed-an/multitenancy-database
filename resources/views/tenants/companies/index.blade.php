@extends('tenants.layouts.app')

@section('content')
    <div class="container">

        @section('content')
            <h3>Empresas</h3>
            <br /><br />
            <a class="btn btn-default" href="{{route('company.create')}}"> Criar novo</a>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Domain</th>
                    <th>Database</th>
                    <th>Host</th>
                    <th>username</th>
                    <th>password</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->domain }}</td>
                        <td>{{ $company->bd_database}}</td>
                        <td>{{ $company->bd_host }}</td>
                        <td>{{ $company->bd_username }}</td>
                        <td>{{ $company->bd_password }}</td>
                        <td>
                           <a href="{{route('company.edit', ['domain' => $company->domain])}}">Editar</a>
                           <a href="{{route('company.show', ['domain' => $company->domain])}}">Ver</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endsection
    </div>
@endsection
