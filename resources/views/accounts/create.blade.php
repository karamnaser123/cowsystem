<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء عميل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('accounts.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <p>يجب الاختيار بين تاجر أو عميل:</p>
                    <input type="radio" id="merchantRadio" name="fav_language" value="merchant">
                    <label for="merchantRadio"> تاجر</label><br>
                    <input type="radio" id="customerRadio" name="fav_language" value="customer">
                    <label for="customerRadio"> عميل</label><br>

                    <div class="form-group" id="merchantDropdown" style="display: none;">
                        <label> اسم التاجر </label>
                        <select class="form-control" name="name" style="padding-right: 30px" disabled>
                            @foreach (App\Models\suppliers::orderBy('id')->get() as $supplier)
                                <option value="{{ $supplier->name }}">
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="customerDropdown" style="display: none;">
                        <label> اسم العميل </label>
                        <select class="form-control" name="name" style="padding-right: 30px" disabled>
                            @foreach (App\Models\customers::orderBy('id')->get() as $customer)
                                <option value="{{ $customer->name }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('input[name="fav_language"]').change(function() {
                                // Hide all dropdowns and disable all selects
                                $('#merchantDropdown, #customerDropdown').hide().find('select').prop('disabled', true);

                                // Show the selected dropdown and enable its select
                                if ($(this).val() === 'merchant') {
                                    $('#merchantDropdown').show().find('select').prop('disabled', false);
                                } else if ($(this).val() === 'customer') {
                                    $('#customerDropdown').show().find('select').prop('disabled', false);
                                }
                            });
                        });
                    </script>



                    <div class="form-group">
                        <label> دائن او مدين</label>
                        <select class="form-control" name="creditorordebtor" style="padding-right: 30px">
                            <option value="1">مدين</option>
                            <option value="0">دائن </option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label> رصيد الحساب </label>
                        <input type="number" class="form-control" value="{{ old('accountbalance') }}"
                            name="accountbalance">
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
