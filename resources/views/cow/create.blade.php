<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء بقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('cow.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>رقم البقرة</label>
                        <input type="text" class="form-control" value="{{ old('cownumber') }}" name="cownumber">
                    </div>


                    <div class="form-group">
                        <label>رقم الام (ان وجد)</label>
                        <select class="form-control" name="mothernumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>
                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->cownumber }}">
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>تاريخ الميلاد (ان وجد)</label>
                        <br>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('birthdate') }}" name="birthdate">
                    </div>


                    <div class="form-group">
                        <label>تاريخ دخول المزرعة</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('farmentrydate') }}" name="farmentrydate">

                    </div>
                    <div class="form-group">
                        <label> الوزن (كيلو جرام)</label>
                        <input type="text" class="form-control" value="{{ old('weight') }}" name="weight">

                    </div>
                    <div class="form-group">
                        <label>سعر الشراء</label>
                        <input type="text" class="form-control" value="{{ old('purchasingprice') }}"
                            name="purchasingprice">

                    </div>
                    <div class="form-group">
                        <label>سعر البيع المتوقع</label>
                        <input type="text" class="form-control" value="{{ old('expectedsaleprice') }}"
                            name="expectedsaleprice">

                    </div>
                    <div class="form-group">
                        <label>المصروف اليومي</label>
                        <input type="text" class="form-control" value="{{ old('dailyexpense') }}"
                            name="dailyexpense">

                    </div>


                    <div class="form-group">
                        <label>تاريخ الافطام (ان وجد)</label>
                        <br>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('weaningdate') }}" name="weaningdate">
                    </div>


                    <div class="form-group">
                        <label>حالة البقرة</label>
                        <select class="form-control" name="status" style="padding-right: 30px">
                            <option value="1">نشطة</option>
                            <option value="0">غير نشطة</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="image">صورة البقرة:</label>
                        <br>
                        <input type="file" value="{{ old('image') }}" id="image" name="image">
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
