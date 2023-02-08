@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="fs-4">Добавить новый заказ</h1>
        </div>
        <div class="col-auto">
            <a class="btn" href="{{route('orders.index')}}">
            <span class="d-none d-sm-inline mx-1 navigate">
              Назад
            </span>
                <svg id="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>
    <form action="{{route('orders.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Дата</label>
                                    <input type="text" name="order_date"
                                           value="{{old('order_date') ?? null}}"
                                           class="{{$errors->has('order_date') ? 'form-control is-invalid' : 'form-control'}}" id="order_date">
                                    @if($errors->has('order_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('order_date') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Телефон</label>
                                    <input type="tel" name="phone" value="{{old('phone') ?? null}}"
                                           class="{{$errors->has('phone') ? 'form-control is-invalid' : 'form-control'}}"
                                           id="phone">
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" name="email" value="{{old('email') ?? null}}"
                                           class="{{$errors->has('email') ? 'form-control is-invalid' : 'form-control'}}"
                                           required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Адрес</label>
                                    <input type="text" name="address"
                                           value="{{old('address') ?? null}}"
                                           class="{{$errors->has('address') ? 'form-control is-invalid' : 'form-control'}}" id="address">
                                    @if($errors->has('address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Кооридинаты</label>
                                    <input type="text" name="coordinates" value="{{old('coordinates') ?? null}}"
                                           class="{{$errors->has('coordinates') ? 'form-control is-invalid' : 'form-control'}}"
                                           id="coordinates">
                                    @if($errors->has('coordinates'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('coordinates') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div id="map" style="max-width:  1200px; height: 400px"></div>




                        <div class="mb-3 forappend">
                            <label class="form-label">Выберите продукцию</label>
                            <select name="products_id[]" class="form-select" id="products">
                                @foreach($products as $product)
                                    <option
                                        value="{{$product->id}}" data-price="{{$product->price}}" >{{$product->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 forappend" data-id="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Количество</label>
                                    <input type="number" name="count[]" min="1" value="{{old('count') ?? 1}}" class="form-control" id="count">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Стоимость</label>
                                    <input type="text" name="price[]" value="{{old('price') ?? null}}" id="price" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Добавить еще продукцию
                            </button>
                        </div>
                        <button class="btn btn-primary" type="submit">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        @include('modal')
    </form>

    <script type="text/javascript">
        let price = 0;
        $(document).ready(() => {
            $("#products").select2().on('select2:select', () => {
                price = $("#products").select2().find(':selected').data('price');
                $('#price').val(price * $('#count').val());
            })
            price = $("#products").select2().find(':selected').data('price');

            $('#price').val(price);


            $('#count').on('change', () => {
                $('#price').val($('#count').val() * price);
            })
        })

        let model = document.getElementById('exampleModal');
        model.addEventListener('hidden.bs.modal', () => {
            document.querySelectorAll('.count').forEach((count) => {
                count.addEventListener('change', () => {
                    let sum = document.querySelector('[data-sum='+'"'+ count.dataset.count + '"'+']');
                    sum.value = sum.dataset.price * count.value;
                })
            })

            document.querySelectorAll('.remove').forEach((btn) => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('[data-id='+'"'+ btn.dataset.id + '"'+']').forEach((elem)=>{
                        elem.remove();
                    })
                })
            })
        })


        $(function(){
            $("#phone").mask("+79999999999");
            $('#order_date').mask("99.99.9999",{placeholder:"07.07.2020"});
        });


        let coordinates = [55.558741, 37.378847];



        function init() {
            // Создание карты.
            var myMap = new ymaps.Map("map", {

                    center: coordinates,
                    // Уровень масштабирования. Допустимые значения:
                    // от 0 (весь мир) до 19.
                    zoom: 13
                }, {
                    searchControlProvider: 'yandex#search'
                }),

                myPlacemark = new ymaps.Placemark(myMap.getCenter());


            myMap.geoObjects.add(myPlacemark);

            myPlacemark.events
                .add('mouseenter', function (e) {
                    // Ссылку на объект, вызвавший событие,
                    // можно получить из поля 'target'.
                    e.get('target').options.set('preset', 'islands#greenIcon');
                })
                .add('mouseleave', function (e) {
                    e.get('target').options.unset('preset');
                })

            myMap.events.add('click', function (e) {
                var coords = e.get('coords');
                $('#coordinates').val(coords.join(', '));
                // Если метка уже создана – просто передвигаем ее.
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress(coords);
            });


            // Создание метки.
            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress(coords) {
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);
                    $('#address').val(firstGeoObject.getAddressLine());
                    myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: [
                                // Название населенного пункта или вышестоящее административно-территориальное образование.
                                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                            ].filter(Boolean).join(', '),
                            // В качестве контента балуна задаем строку с адресом объекта.
                            balloonContent: firstGeoObject.getAddressLine()
                        });
                });
            }
        }

        ymaps.ready(init);

    </script>
@endsection
