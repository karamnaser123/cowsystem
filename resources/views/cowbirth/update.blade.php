<!-- Modal -->
<div id="editUserModal-{{ $medicine->id }}"class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل المولد للبقرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateCowForm" action="{{ route('cowbirth.update', ['cowbirth' => $medicine->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put') <!-- Use the PUT method for updates -->



                    <div class="form-group">
                        <label> رقم البقرة المولودة</label>
                        <select class="form-control" name="cownumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>
                            @foreach (App\Models\Cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}"
                                    {{ optional($medicine->cowse)->id == $cow->id ? 'selected' : '' }}>
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>رقم البقرة الأم</label>
                        <select class="form-control" name="mothernumber" style="padding-right: 30px">
                            <option value="">لا يوجد</option>

                            @foreach (App\Models\Cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}"
                                    {{ optional($medicine->cowse2)->id == $cow->id ? 'selected' : '' }}>
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach

                        </select>
                    </div>



                    <div class="form-group">
                        <label> تاريخ وضع المولود </label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ $medicine->dateofbirth }}" name="dateofbirth">
                    </div>

                    <div class="form-group">
                        <label>جنس البقرة</label>
                        <select class="form-control" name="gender" style="padding-right: 30px">
                            <option value="1" {{ $medicine->gender == 1 ? 'selected' : '' }}>ذكر</option>
                            <option value="2" {{ $medicine->gender == 2 ? 'selected' : '' }}> انثى</option>
                            <option value="" {{ $medicine->gender == null ? 'selected' : '' }}> غير معروف
                            </option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>الملاحظات</label>
                        <input type="text" class="form-control" value="{{ $medicine->note }}" name="note">
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
