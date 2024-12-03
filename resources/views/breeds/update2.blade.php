<!-- Modal -->
<div id="editUserModal2-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل نتيجة التلقيح </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('breeds.update2', ['breeds' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->

                    {{-- <div class="form-group">
                        <label>نتيجة الفحص</label>
                        <input type="text" class="form-control" value="{{ $medicine->result }}" name="result">
                    </div> --}}


                    <div class="form-group">
                        <label>نتيجة الفحص</label>
                        <select class="form-control" name="result" style="padding-right: 30px">
                            <option {{ $medicine->result == 'حامل' ? 'selected' : '' }} value="حامل">حامل</option>
                            <option {{ $medicine->result == 'غير حامل' ? 'selected' : '' }} value="غير حامل">غير حامل
                            <option {{ $medicine->result == '' ? 'selected' : '' }} value="">غير معروف
                            </option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>الملاحظات</label>
                        <input type="text" class="form-control" value="{{ $medicine->note }}" name="note">
                    </div>


                    <div class="form-group">
                        <label>تاريخ الميلاد المتوقع</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->expectedbirthdate }}" name="expectedbirthdate">
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
