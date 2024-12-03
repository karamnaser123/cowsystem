<!-- Include jQuery -->

@extends('layouts.app')
@section('body')
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute"
        data-header-position="absolute" data-boxed-layout="full">

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12">

                        <div class="mb-3">
                            <!-- Button trigger modal -->
                            @can('create-cow')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    انشاء بقرة
                                </button>
                                @include('cow.create')
                            @endcan
                            <a href="{{ route('cow.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>
                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف البقر
                            </label>

                            <button id="updateAllQR" class="btn btn-success" onclick="updateAllQRCodes()">تحديث جميع
                                QrCode</button>

                            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                            <script>
                                function updateAllQRCodes() {
                                    // Confirm with the user before updating
                                    // Disable the button to prevent multiple clicks
                                    $('#updateAllQR').prop('disabled', true);

                                    // Perform an AJAX request to your backend endpoint for updating QR codes
                                    $.ajax({
                                        url: '{{ route('updateAllQRCodes') }}',
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {

                                            location.reload();

                                        },
                                        error: function(xhr, status, error) {
                                            // Handle error, e.g., show an error message
                                            console.error('Error updating QR Codes:', error);
                                        }
                                    });
                                }
                            </script>
                            <form id="uploadForm" action="{{ route('cow.import') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="file" name="file" accept=".xlsx" id="fileInput" style="display: none;">

                                <script>
                                    document.getElementById('fileInput').addEventListener('change', function() {
                                        var fileInput = this;
                                        var fileName = fileInput.files[0] ? fileInput.files[0].name : 'اختر ملف';
                                        document.getElementById('customFileLabel').innerText = fileName;
                                    });
                                </script>
                            </form>

                            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#fileInput').on('change', function() {
                                        $('#uploadForm').submit();
                                    });
                                });
                            </script>

                        </div>


                        <!-- Search Bar -->
                        <div class="mb-3">
                            <form action="{{ route('cow.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن بقرة" name="search">
                                    <button class="btn btn-outline-secondary" type="submit">بحث</button>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="table-responsive m-t-20">
                                <table class="table table-bordered table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">رقم البقرة</th>
                                            <th scope="col">رقم الام</th>
                                            <th scope="col">صورة البقرة</th>
                                            <th scope="col">تاريخ الميلاد</th>
                                            <th scope="col">تاريخ دخول المزرعة </th>
                                            <th scope="col">الوزن(كيلو جرام)</th>
                                            <th scope="col">سعر الشراء </th>
                                            <th scope="col">سعر البيع المتوقع </th>
                                            <th scope="col">المصروف اليومي</th>
                                            <th scope="col">تاريخ الافطام</th>
                                            <th scope="col">الحالة</th>
                                            <th scope="col">تعديل</th>
                                            <th scope="col">جميع تفاصيل البقرة</th>
                                            <th scope="col"> QRCODE</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cow as $cows)
                                            <tr>
                                                <th scope="row">{{ $cows->id }}</th>
                                                <td>{{ $cows->cownumber }}</td>
                                                <td>{{ $cows->mothernumber }}</td>
                                                <td>
                                                    <img width="50px" height="50px"
                                                        src="{{ asset('images/' . $cows->image) }}" loading="lazy">
                                                </td>
                                                <td>{{ $cows->birthdate }}</td>
                                                <td>{{ $cows->farmentrydate }}</td>
                                                <td>{{ $cows->weight }}</td>
                                                <td>{{ $cows->purchasingprice }}JOD </td>
                                                <td>{{ $cows->expectedsaleprice }}JOD</td>
                                                <td>{{ $cows->dailyexpense }}JOD</td>
                                                <td>{{ $cows->weaningdate }}</td>

                                                <td>
                                                    @if ($cows->status == 1)
                                                        نشطة
                                                    @else
                                                        غير نشطة
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('edit-cow')
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $cows->id }}"
                                                            data-cow-id="{{ $cows->id }}">
                                                            تعديل بقرة
                                                        </button>

                                                        @include('cow.update')
                                                    @endcan
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="{{ route('cow.details', ['cowId' => $cows->id]) }}">عرض
                                                        تفاصيل
                                                        البقرة</a>

                                                </td>

                                                <td>
                                                    {{-- <div id="qrCodeContainer">
                                                        {!! DNS2D::getBarcodeHTML(url("cow/details/qr/{$cows->id}"), 'QRCODE', 3, 3) !!}
                                                    </div> --}}
                                                    <button
                                                        onclick="downloadQRCode('{{ $cows->qrcode }}', {{ $cows->id }})">
                                                        <img width="100px" height="100px"
                                                            src="{{ asset('qrcodes/' . $cows->qrcode) }}" loading="lazy">
                                                    </button>

                                                    <script>
                                                        function downloadQRCode(qrcodeFilename, cowId) {
                                                            var link = document.createElement('a');
                                                            link.href = "{{ asset('qrcodes/') }}" + '/' + qrcodeFilename;
                                                            link.download = "cow_" + cowId + ".png"; // Use the cow's ID in the filename
                                                            link.click();
                                                        }
                                                    </script>



                                                </td>

                                                <td>
                                                    @can('delete-cow')
                                                        <form action="{{ route('cow.destroy', ['id' => $cows->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل انت متأكد من حذف البقرة؟');">

                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </td>

                                            </tr>

                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
