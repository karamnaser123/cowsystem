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
                <form id="updateCowForm" action="{{ route('purchases.update', ['purchases' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->


                    <div class="form-group">
                        <label> اسم المورد</label>
                        <select class="form-control" name="supplierid" style="padding-right: 30px">
                            @foreach (App\Models\suppliers::orderBy('id')->get() as $suppliers)
                                <option value="{{ $suppliers->id }}"
                                    {{ $suppliers->id == $medicine->supplierid ? 'selected' : '' }}>
                                    {{ $suppliers->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label> اسم المنتج </label>
                        <input type="text" class="form-control" value="{{ $medicine->productname }}"
                            name="productname">
                    </div>
                    <div class="form-group">
                        <label> سعر المنتج </label>
                        <input type="text" class="form-control" value="{{ $medicine->purchasingprice }}"
                            name="purchasingprice">
                    </div>
                    <div class="form-group">
                        <label> كمية المنتج(بالكيلو)</label>
                        <input type="text" class="form-control" value="{{ $medicine->productquantity }}"
                            name="productquantity">
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
