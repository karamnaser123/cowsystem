<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل موعد الدواء</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('medicines.update', ['medicines' => $medicine->id]) }}"
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
                        <label>الطبيب</label>
                        <input type="text" class="form-control" value="{{ $medicine->doctor }}" name="doctor">

                    </div>


                    <div class="form-group">
                        <label> نوع الدواء</label>
                        <input type="text" class="form-control" value="{{ $medicine->typeofmedication }}"
                            name="typeofmedication">
                    </div>
                    <div class="form-group">
                        <label> عدد الجرعات</label>
                        <input type="text" class="form-control" value="{{ $medicine->numberofdoses }}"
                            name="numberofdoses">
                    </div>

                    <div class="form-group">
                        <label> تحديد التاريخ</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->identifydate }}" name="identifydate">
                    </div>

                    <div class="form-group">
                        <label>تاريخ البدء</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->startdate }}" name="startdate">
                    </div>

                    <div class="form-group">
                        <label> تاريخ الانتهاء</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->enddate }}" name="enddate">
                    </div>

                    <div class="form-group">
                        <label>تاريخ المتابعة التالي</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->nextfollowupdate }}" name="nextfollowupdate">
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
