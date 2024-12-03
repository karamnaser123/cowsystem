<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء مصروف للبقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('cowexpenses.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf



                    <div class="form-group">
                        <label> اسم المنتج</label>
                        <select class="form-control" name="name" style="padding-right: 30px">
                            @foreach (App\Models\products::orderBy('id')->get() as $products)
                                <option value="{{ $products->id }}">
                                    {{ $products->productname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> الكمية </label>
                        <input type="text" class="form-control" value="{{ old('quantity') }}" name="quantity">
                    </div>






                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" type="button" class="btn btn-primary">إنشاء</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
