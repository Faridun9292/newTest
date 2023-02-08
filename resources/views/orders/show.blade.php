@extends('layouts.app')

@section('content')
    <div class="row py-5">
        <div class="col">
            <h1 class="fs-4">Данные заказа</h1>
        </div>
        <div class="col-auto">
            <a class="btn" href="{{ route('orders.index') }}">
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
    <div class="row card_row mb-4">
        <div class="col-lg-3 col-md-4">
            <h5>Данные</h5>
            <p>
                <small class="text-muted"></small>
            </p>
        </div>
        <div class="col-md col-lg-7">
            <div class="row g-2">
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">Дата заказа</label>
                    <div class="form-floating ">
                        {{ $order->order_date }}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">Телефон</label>
                    <div class="form-floating ">
                        {{ $order->phone }}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">E-mail</label>
                    <div class="form-floating ">
                        {{ $order->email }}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">Адрес</label>
                    <div class="form-floating ">
                        {{ $order->address }}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">Координаты</label>
                    <div class="form-floating ">
                        {{ $order->coordinates }}
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="mb-0" style="font-size: 14px;">Общая сумма заказа</label>
                    <div class="form-floating ">
                        {{ $order->total_sum }}
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="datatable">
                <thead>
                <tr>
                    <th>Название продукта</th>
                    <th>Стоимость</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <th>{{$product->title}}</th>
                        <td>{{$product->price}}</td>
                        <td>{{$product->pivot->count}}</td>
                        <td>{{$product->pivot->sum}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
