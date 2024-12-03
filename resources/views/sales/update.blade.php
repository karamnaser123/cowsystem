<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل الشراء</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('sales.update', ['sales' => $medicine->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->


                    <div class="form-group">
                        <label> اسم العميل</label>
                        <select class="form-control" name="customerid" style="padding-right: 30px">
                            @foreach (App\Models\customers::orderBy('id')->get() as $customers)
                                <option value="{{ $customers->id }}"
                                    {{ $medicine->customerid == $customers->id ? 'selected' : '' }}>
                                    {{ $customers->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label> اسم المنتج</label>
                        <select class="form-control" name="products_id" style="padding-right: 30px">
                            @foreach (App\Models\products::orderBy('id')->get() as $products)
                                <option value="{{ $products->id }}"
                                    {{ $medicine->products_id == $products->id ? 'selected' : '' }}>
                                    {{ $products->productname }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label> سعر المنتج(ان وجد) </label>
                        <input type="text" class="form-control" value="{{ $medicine->price }}" name="price">
                    </div>


                    <div class="form-group">
                        <label> كمية المنتج(بالكيلو)</label>
                        <input type="text" class="form-control" value="{{ $medicine->productquantity }}"
                            name="productquantity">
                    </div>


                    <div class="form-group">
                        <label> مقدار الخصم </label>
                        <input type="text" class="form-control" value="{{ $medicine->discount }}" name="discount">
                    </div>


                    <div class="form-group">
                        <label> طريقة الدفع </label>
                        <select class="form-control" name="payment_id" style="padding-right: 30px">
                            @foreach (App\Models\paymentmethods::orderBy('id')->get() as $paymentmethods)
                                <option value="{{ $paymentmethods->id }}"
                                    {{ $paymentmethods->id == $medicine->payment_id ? 'selected' : '' }}>
                                    {{ $paymentmethods->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> تاريخ البيع </label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->datesale }}" name="datesale">
                    </div>

                    @if ($medicine->payment_id == '2')
                        <label>اسم البنك</label>
                        <input type="text" class="form-control" value="{{ $medicine->bankname }}" name="bankname">

                        <label>رقم الشيك</label>
                        <input type="text" class="form-control" value="{{ $medicine->checknumber }}"
                            name="checknumber">

                        <label>تاريخ الصرف</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->exchangedate }}" name="exchangedate">
                    @endif

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
