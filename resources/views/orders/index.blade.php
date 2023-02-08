@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row py-5">
                        <div class="col">
                            <h1 class="fs-4">Заказы</h1>
                        </div>
                            <div class="col-auto">

                                <a class="btn" href="{{route('orders.create')}}">
              <span class="d-none d-sm-inline mx-1 navigate">
                Добавить
              </span>
                                    <svg id="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Дата</th>
                                <th>Телефон</th>
                                <th>Почта</th>
                                <th>Сумма</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th>{{$order->id}}</th>
                                    <td>{{$order->order_date}}</td>
                                    <td>{{$order->phone}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>{{$order->total_sum}}</td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn px-0" type="button" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-three-dots-vertical"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="{{route('orders.show', $order)}}">Посмотреть</a>
                                                </li>

                                                <li><a class="dropdown-item" href="{{route('orders.edit', $order)}}">Редактировать</a>
                                                </li>

                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{route('orders.destroy', $order)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                    <button type="submit" class="dropdown-item">Удалить</button>
                                                    </form>
                                                </li>


                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        })
    </script>
@endsection
