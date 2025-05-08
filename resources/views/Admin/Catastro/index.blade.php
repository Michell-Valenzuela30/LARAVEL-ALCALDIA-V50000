@extends('layouts.admin')

@section('title', 'Gestión de Catastro')
@section('header', 'Gestión de Catastro')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/catastro/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catastro/responsive.dataTables.min.css') }}">


    @push('scripts')
        <script src="{{ asset('js/catastro/jquery.js') }}"></script>
        <script src="{{ asset('js/catastro/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/catastro/responsive.dataTables.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>

        </script>
    @endpush
@endsection
