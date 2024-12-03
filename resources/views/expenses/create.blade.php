<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء مصروف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('expenses.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label> نوع المصروف </label>
                        <input type="text" class="form-control" value="{{ old('typeofexpense') }}"
                            name="typeofexpense">
                    </div>

                    <div class="form-group">
                        <label> مقدار المصروف </label>
                        <input type="number" class="form-control" value="{{ old('amount') }}" name="amount">
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
