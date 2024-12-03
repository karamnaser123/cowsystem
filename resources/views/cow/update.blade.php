<!-- Modal -->
<div id="editUserModal-{{ $cows->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل بقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('cow.update', ['cow' => $cows->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->

                    <!-- Add a hidden input for the cow's ID -->
                    <input type="hidden" id="cowId" name="cowId" value="">

                    <div class="form-group">
                        <label>رقم البقرة</label>
                        <input type="text" value="{{ $cows->cownumber }}" class="form-control" name="cownumber">
                    </div>
                    <div class="form-group">
                        <label>رقم الام (ان وجد)</label>
                        <select class="form-control" name="mothernumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>
                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->cownumber }}"
                                    {{ $cow->mothernumber != $cow->cownumber ? 'selected' : '' }}>
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>تاريخ الميلاد (ان وجد)</label>
                        <br>
                        <input type="date" class="form-control" style="width:467px; height: 40px"
                            value="{{ $cows->birthdate }}" name="birthdate">
                    </div>


                    <div class="form-group">
                        <label>تاريخ دخول المزرعة</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $cows->farmentrydate }}" name="farmentrydate">

                    </div>
                    <div class="form-group">
                        <label> الوزن (كيلو جرام)</label>
                        <input type="text" class="form-control" value="{{ $cows->weight }}" name="weight">

                    </div>
                    <div class="form-group">
                        <label>سعر الشراء</label>
                        <input type="text" class="form-control" value="{{ $cows->purchasingprice }}"
                            name="purchasingprice">

                    </div>
                    <div class="form-group">
                        <label>سعر البيع المتوقع</label>
                        <input type="text" class="form-control" value="{{ $cows->expectedsaleprice }}"
                            name="expectedsaleprice">

                    </div>
                    <div class="form-group">
                        <label>المصروف اليومي</label>
                        <input type="text" class="form-control" value="{{ $cows->dailyexpense }}"
                            name="dailyexpense">

                    </div>

                    <div class="form-group">
                        <label>تاريخ الافطام (ان وجد)</label>
                        <br>
                        <input type="date" class="form-control" style="width:467px; height: 40px"
                            value="{{ $cows->weaningdate }}" name="weaningdate">
                    </div>

                    <div class="form-group">
                        <label>حالة البقرة</label>
                        <select class="form-control" name="status" style="padding-right: 30px">
                            <option value="1" {{ $cows->status == 1 ? 'selected' : '' }}>نشطة</option>
                            <option value="0" {{ $cows->status == 0 ? 'selected' : '' }}>غير نشطة</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">صورة البقرة:</label>
                        <br>
                        <input type="file" id="image" name="image">
                        <img width="50px" height="50px" src="{{ asset('images/' . $cows->image) }}">
                    </div>

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
