@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="fs-4">Редактирование товара</h1>
        </div>
        <div class="col-auto">
            <a class="btn" href="{{route('products.index')}}">
         <span class="d-none d-sm-inline mx-1">
         Назад
         </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <form action="{{route('products.update', $product)}}" method="post">
        @csrf
        @method('put')

        @include('products.form')
    </form>
@endsection
