<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل المنتجات</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('products.update', ['products' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->

                    <div class="form-group">
                        <label> اسم المنتج </label>
                        <input type="text" class="form-control" value="{{ $medicine->productname }}"
                            name="productname">
                    </div>

                    <div class="form-group">
                        <label> سعر المنتج </label>
                        <input type="text" class="form-control" value="{{ $medicine->productprice }}"
                            name="productprice">
                    </div>
                    <div class="form-group">
                        <label>الكمية </label>
                        <input type="text" class="form-control" value="{{ $medicine->quantity }}" name="quantity">
                    </div>
                    <div class="form-group">
                        <label>صورة المنتج </label>
                        <input type="file" class="form-control" value="{{ $medicine->productimage }}"
                            name="productimage">
                        <img width="50px" height="50px"
                            src="{{ asset('images/products/' . $medicine->productimage) }}" </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <!-- Change the button text to تحديث -->
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
