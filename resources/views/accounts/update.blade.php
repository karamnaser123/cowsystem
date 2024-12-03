<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل العميل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('accounts.update', ['accounts' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->



                    <div class="form-group">
                        <label> دائن او مدين</label>
                        <select class="form-control" name="creditorordebtor" style="padding-right: 30px">
                            <option {{ $medicine->creditorordebtor == 1 ? 'selected' : '' }} value="1">مدين
                            </option>
                            <option {{ $medicine->creditorordebtor == 0 ? 'selected' : '' }} value="0">دائن
                            </option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label> رصيد الحساب </label>
                        <input type="number" class="form-control" value="{{ $medicine->accountbalance }}"
                            name="accountbalance">
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
