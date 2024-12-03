<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل موعد التلقيح</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('breeds.update', ['breeds' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
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
                        <label>تاريخ التلقيح</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->breedingdate }}" name="breedingdate">
                    </div>

                    <div class="form-group">
                        <label>نوع التلقيح</label>
                        <select class="form-control" name="breedingtype" style="padding-right: 30px">
                            <option value="1" {{ $medicine->breedingtype == 1 ? 'selected' : '' }}>التلقيح
                                الطبيعي</option>
                            <option value="2" {{ $medicine->breedingtype == 2 ? 'selected' : '' }}> التلقيح
                                الصناعي</option>
                            <option value="" {{ $medicine->breedingtype == null ? 'selected' : '' }}> غير معروف
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label> حالة التلقيح</label>
                        <input type="text" class="form-control" value="{{ $medicine->breedingstatus }}"
                            name="breedingstatus">
                    </div>

                    <div class="form-group">
                        <label> التكاليف</label>
                        <input type="text" class="form-control" value="{{ $medicine->cost }}" name="cost">
                    </div>

                    <div class="form-group">
                        <label> تم التلقيح بواسطة (ان وجد)</label>
                        <input type="text" class="form-control" value="{{ $medicine->pollinationby }}"
                            name="pollinationby">
                    </div>

                    <div class="form-group">
                        <label>تاريخ الفحص</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->examinationdate }}" name="examinationdate">
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
