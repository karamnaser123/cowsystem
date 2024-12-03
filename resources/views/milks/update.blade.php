<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل كميات الحليب للبقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('milks.update', ['milks' => $medicine->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->



                    <div class="form-group">
                        <label>رقم البقرة</label>
                        <select class="form-control" name="cownumber" style="padding-right: 30px">
                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}"
                                    {{ $medicine->cowse->id == $cow->id ? 'selected' : '' }}>
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> التاريخ</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->date }}" name="date">
                    </div>


                    <div class="form-group">
                        <label> كمية الحليب في الصباح</label>
                        <input type="text" class="form-control" value="{{ $medicine->morningamount }}"
                            name="morningamount">
                    </div>
                    <div class="form-group">
                        <label> كمية الحليب في الظهيرة</label>
                        <input type="text" class="form-control" value="{{ $medicine->noonamount }}"
                            name="noonamount">
                    </div>
                    <div class="form-group">
                        <label> كمية الحليب ما بعد الظهيرة </label>
                        <input type="text" class="form-control" value="{{ $medicine->afternoonamount }}"
                            name="afternoonamount">
                    </div>

                    <div class="form-group">
                        <label> تاريخ التنشيف (ان وجد)</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->dryingdate }}" name="dryingdate">
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
