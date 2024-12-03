<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء مولود للبقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('cowbirth.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>رقم البقرة المولودة</label>
                        <select class="form-control" name="cownumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>

                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}">
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>رقم البقرة الام</label>
                        <select class="form-control" name="mothernumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>
                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}">
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label> تاريخ وضع المولود </label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('dateofbirth') }}" name="dateofbirth">
                    </div>

                    <div class="form-group">
                        <label>جنس البقرة</label>
                        <select class="form-control" name="gender" style="padding-right: 30px">
                            <option value="">غير معروف</option>
                            <option value="1">ذكر</option>
                            <option value="2"> انثى</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>الملاحظات</label>
                        <input type="text" class="form-control" value="{{ old('note') }}" name="note">
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
