<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل المورد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('suppliers.update', ['suppliers' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->


                    <div class="form-group">
                        <label> المورد </label>
                        <input type="text" class="form-control" value="{{ $medicine->name }}" name="name">
                    </div>
                    <div class="form-group">
                        <label> رقم الهاتف </label>
                        <input type="text" class="form-control" value="{{ $medicine->phone }}" name="phone">
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
