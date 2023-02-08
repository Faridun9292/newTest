<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Название</label>
                    <input type="text" name="title" minlength="3" value="{{$product->title ?? (old('title') ?? null) }}" class="{{$errors->has('title') ? 'form-control is-invalid' : 'form-control'}}">
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Цена</label>
                    <input type="text" name="price" min="0"  value="{{$product->price ?? (old('price') ?? null)}}" class="{{$errors->has('price') ? 'form-control is-invalid' : 'form-control'}}">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>

                <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script defer>

</script>

