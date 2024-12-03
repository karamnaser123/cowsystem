<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-xzQ2KXeZ2n9xlyTz3+OE2Fi7UMPCbHAxLWbG+ptXF5p8+2uUE5ktMUgJByFyNXkHc3Ulw7tkRuoFYfUDt4s2Xg=="
    crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


<div class="container" id="body-content" style="direction: rtl">
    <h1 class="mb-4">جميع تفاصيل البقرة</h1>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">معلومات البقرة</h2>
                    <p class="card-text"><strong>رقم البقرة:</strong> {{ $cow->cownumber }}</p>
                    <p class="card-text"><strong>رقم الام:</strong> {{ $cow->mothernumber }}</p>
                    <p class="card-text"><strong>تاريخ ولادة البقرة:</strong> {{ $cow->birthdate }}</p>
                    <!-- Add other relevant information here -->
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">العلاجات</h2>
                    <p class="card-text"><strong> عدد مرات علاج البقرة:</strong> {{ $medicines2 }}</p>
                    <hr>
                    @forelse ($medicines as $medicine)
                        <p class="card-text"><strong>تاريخ المتابعة التالي للدواء:</strong>
                            {{ $medicine->nextfollowupdate ?? 'N/A' }}</p>
                        <p class="card-text"><strong> نوع الدواء :</strong> {{ $medicine->typeofmedication ?? 'N/A' }}
                        </p>
                        <p class="card-text"><strong> عدد الجرعات:</strong> {{ $medicine->numberofdoses ?? 'N/A' }}</p>
                        <p class="card-text"><strong> اسم الدكتور:</strong> {{ $medicine->doctor ?? 'N/A' }}</p>
                        <hr>
                        <!-- Add other medicine properties as needed -->
                    @empty
                        <p class="card-text">لا يوجد علاج للبقرة</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">التلقيحات</h2>
                    <p class="card-text"><strong>عدد مرات تلقيح البقرة:</strong> {{ $breeds2 }}</p>
                    <hr>
                    @forelse ($breeds as $breed)
                        <p class="card-text"><strong>تاريخ التلقيح:</strong> {{ $breed->breedingdate ?? 'N/A' }}</p>
                        <p class="card-text"><strong>نوع التلقيح:</strong>
                            @if ($breed->breedingtype ?? 'N/A' == 1)
                                التلقيح الطبيعي
                            @elseif($breed->breedingtype ?? 'N/A' == 2)
                                التلقيح الصناعي
                                @else
                                غير معروف
                            @endif
                        </p>
                        <p class="card-text"><strong>تاريخ الفحص:</strong> {{ $breed->examinationdate ?? 'N/A' }}</p>
                        <p class="card-text"><strong>نتيجة الفحص:</strong> {{ $breed->result ?? 'N/A' }}</p>
                        <hr>
                    @empty
                        <p class="card-text">لا يوجد تلاقيج للبقرة.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">الحليب</h2>
                    <p class="card-text"><strong>عدد مرات حليب البقرة:</strong> {{ $milks2 }}</p>
                    <hr>
                    @forelse ($milks as $milk)
                        <p class="card-text"><strong>التاريخ:</strong> {{ $milk->date ?? 'N/A' }}</p>
                        <p class="card-text"><strong>مقدار الحليب في الصباح</strong>
                            {{ $milk->morningamount ?? 'N/A' }}</p>
                        <p class="card-text"><strong>مقدار الحليب في الظهيرة:</strong>
                            {{ $milk->noonamount ?? 'N/A' }}</p>
                        <p class="card-text"><strong>مقدار الحليب بعد الظهيرة:</strong>
                            {{ $milk->afternoonamount ?? 'N/A' }}</p>
                        <p class="card-text"><strong>كمية الحليب الإجمالية:</strong>
                            {{ $milk->morningamount + $milk->noonamount + $milk->afternoonamount ?? 'N/A' }}</p>
                        <p class="card-text"><strong> تاريخ التنشيف:</strong>
                            {{ $milk->dryingdate ?? 'N/A' }}</p>
                        <hr>
                    @empty
                        <p class="card-text">لا يوجد حليب للبقرة.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">مواليد البقرة</h2>
                    <p class="card-text"><strong>عدد مواليد البقرة:</strong> {{ $cowbirth2 }}</p>
                    <hr>
                    @forelse ($cowbirth as $cowbirt)
                        <p class="card-text"><strong>رقم المولود:</strong>
                            {{ $cowbirt->cowse->cownumber ?? 'N/A' }}</p>
                        <p class="card-text"><strong>تاريخ الولادة:</strong> {{ $cowbirt->dateofbirth ?? 'N/A' }}</p>
                        <p class="card-text"><strong>جنس البقرة:</strong>
                            @if ($cowbirt->gender ?? 'N/A' == 1)
                                ذكر
                            @elseif($cowbirt->gender ?? 'N/A' == 2)
                                أنثى
                            @else
                                غير معروف
                            @endif
                        </p>
                        <hr>
                    @empty
                        <p class="card-text">لا يوجد مواليد للبقرة.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="{{ route('cow.index') }}" class="btn btn-primary">الرجوع إلى صفحة الأبقار</a>
            <button class="btn btn-success" onclick="printBody()">طباعة الصفحة</button>
        </div>
    </div>
</div>
<script>
    function printBody() {
        var printContents = document.getElementById("body-content").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
