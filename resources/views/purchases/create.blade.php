<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء الشراء</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('purchases.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label> اسم المورد</label>
                        <select class="form-control" name="supplierid" style="padding-right: 30px">
                            @foreach (App\Models\suppliers::orderBy('id')->get() as $suppliers)
                                <option value="{{ $suppliers->id }}">
                                    {{ $suppliers->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label> اسم المنتج </label>
                        <input type="text" class="form-control" value="{{ old('productname') }}" name="productname">
                    </div>
                    <div class="form-group">
                        <label> سعر المنتج </label>
                        <input type="text" class="form-control" value="{{ old('purchasingprice') }}"
                            name="purchasingprice">
                    </div>
                    <div class="form-group">
                        <label> كمية المنتج(بالكيلو)</label>
                        <input type="text" class="form-control" value="{{ old('productquantity') }}"
                            name="productquantity">
                    </div>



                    <div class="form-group">
                        <label>طريقة الدفع</label>
                        <select class="form-control" id="paymentMethod" name="payment_id" style="padding-right: 30px">
                            @foreach (App\Models\paymentmethods::orderBy('id')->get() as $paymentmethod)
                                <option value="{{ $paymentmethod->id }}">
                                    {{ $paymentmethod->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="additionalFields" style="display: none;">
                        <label>اسم البنك</label>
                        <input type="text" class="form-control" value="{{ old('bankname') }}" name="bankname">

                        <label>رقم الشيك</label>
                        <input type="text" class="form-control" value="{{ old('checknumber') }}" name="checknumber">

                        <label>تاريخ الصرف</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('dateofbirth') }}" name="exchangedate">
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // Trigger on page load
                            toggleAdditionalFields();

                            // Bind change event to the payment method select
                            $('#paymentMethod').change(function() {
                                toggleAdditionalFields();
                            });

                            function toggleAdditionalFields() {
                                var paymentMethod = $('#paymentMethod').val();

                                if (paymentMethod === '2') {
                                    $('#additionalFields').show();
                                } else {
                                    $('#additionalFields').hide();
                                }
                            }
                        });
                    </script>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" type="button" class="btn btn-primary">إنشاء</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
