<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Выберите продукцию</label>
                    <select  class="form-select" id="product">
                        @foreach($products as $product)
                            <option
                                value="{{$product->id}}"
                                data-price="{{$product->price}}" {{$loop->first ? 'selected' : ''}}>{{$product->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Количество</label>
                    <input type="number" min="1" value="1" class="form-control" id="countProduct">
                </div>
                <div class="mb-3">
                    <label class="form-label">Стоимость</label>
                    <input type="text" value="{{$product}}" id="priceProduct" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="btn">Добавить</button>
            </div>
        </div>
    </div>
</div>
{{--EndModal--}}
<script>
        let priceProduct = $("#product").find(':selected').data('price');
        let productId =  $("#product").find(':selected').val();
        let productName = $("#product").find(':selected').text();

        $("#product").on('change', () => {
            priceProduct = $("#product").find(':selected').data('price');
            $('#priceProduct').val(priceProduct * $('#countProduct').val());
            productId = $("#product").find(':selected').val();
            productName = $("#product").find(':selected').text();
        })

        $('#priceProduct').val(priceProduct);


        $('#countProduct').on('change', () => {
            $('#priceProduct').val($('#countProduct').val() * priceProduct);
        })


        $('#btn').on('click', (e) => {
            e.preventDefault();
            let last = $('.forappend').last();
            let lastData = last.data('id')

            let htmlElement = `
                    <div class="mb-3 forappend" data-id="${lastData + 1}">
                    <label class="form-label">Выберите продукцию</label>
                    <select name="products_id[]" class="form-select option">

                        <option value="${productId}"  selected>${productName}</option>

                    </select>
                </div>

            <div class="mb-3 forappend" data-id="${lastData + 1}">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Количество</label>
                        <input type="number" name="count[]" min="1" value="${$('#countProduct').val()}" class="form-control count" data-count="${lastData + 1}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Стоимость</label>
                            <input type="text" name="price[]" value="${$('#priceProduct').val()}"  class="form-control price" data-price="${priceProduct}" data-sum="${lastData + 1}" readonly>
                        </div>
                        <div class="mb-5 mt-2 text-end">
                            <button class="btn btn-danger remove" data-id="${lastData + 1}">Удалить</button>
                        </div>
                    </div>
                </div>
            `

            last.after(htmlElement);
        })

</script>
