<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">انشاء التلقيح</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('breeds.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>رقم البقرة</label>
                        <select class="form-control" name="cownumber" style="padding-right: 30px">

                            @foreach (App\Models\cow::orderBy('cownumber')->get() as $cow)
                                <option value="{{ $cow->id }}">
                                    {{ $cow->cownumber }}
                                </option>
                            @endforeach
                        </select>
                    </div>




                    <div class="form-group">
                        <label>تاريخ التلقيح</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('breedingdate') }}" name="breedingdate">
                    </div>

                    <div class="form-group">
                        <label>نوع التلقيح</label>
                        <select class="form-control" name="breedingtype" style="padding-right: 30px">
                            <option value="1">التلقيح الطبيعي</option>
                            <option value="2"> التلقيح الصناعي</option>
                            <option value=""> غير معروف </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label> حالة التلقيح</label>
                        <input type="text" class="form-control" value="{{ old('breedingstatus') }}"
                            name="breedingstatus">
                    </div>



                    <div class="form-group">
                        <label> التكاليف</label>
                        <input type="text" class="form-control" value="{{ old('cost') }}" name="cost">
                    </div>

                    <div class="form-group">
                        <label> تم التلقيح بواسطة (ان وجد)</label>
                        <input type="text" class="form-control" value="{{ old('pollinationby') }}"
                            name="pollinationby">
                    </div>


                    <div class="form-group">
                        <label>تاريخ الفحص</label>
                        <input type="date" style="width:467px; height: 40px" class="form-control"
                            value="{{ old('examinationdate') }}" name="examinationdate">
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
