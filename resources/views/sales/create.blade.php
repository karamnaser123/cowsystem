<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء مبيعات</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('sales.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label> اسم العميل</label>
                        <select class="form-control" name="customerid" style="padding-right: 30px">
                            @foreach (App\Models\customers::orderBy('id')->get() as $customers)
                                <option value="{{ $customers->id }}">
                                    {{ $customers->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> اسم المنتج</label>
                        <select class="form-control" name="products_id" style="padding-right: 30px">
                            @foreach (App\Models\products::orderBy('id')->get() as $products)
                                <option value="{{ $products->id }}">
                                    {{ $products->productname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> سعر المنتج(ان وجد) </label>
                        <input type="text" class="form-control" value="{{ old('price') }}" name="price">
                    </div>

                    <div class="form-group">
                        <label> كمية المنتج(بالكيلو)</label>
                        <input type="text" class="form-control" value="{{ old('productquantity') }}"
                            name="productquantity">
                    </div>

                    <div class="form-group">
                        <label> مقدار الخصم </label>
                        <input type="text" class="form-control" value="{{ old('discount') }}" name="discount">
                    </div>

                    <div class="form-group">
                        <label> طريقة الدفع </label>
                        <select id="paymentMethod" class="form-control" name="payment_id" style="padding-right: 30px">
                            @foreach (App\Models\paymentmethods::orderBy('id')->get() as $paymentmethods)
                                <option value="{{ $paymentmethods->id }}">
                                    {{ $paymentmethods->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> تاريخ البيع </label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('datesale') }}" name="datesale">
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
