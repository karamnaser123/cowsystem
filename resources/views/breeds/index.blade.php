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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                انشاء التلقيح
                            </button>
                            @include('breeds.create')
                            <a href="{{ route('breeds.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>

                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف دواء البقر
                            </label>
                            <form id="uploadForm" action="{{ route('breeds.import') }}" method="post"
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
                            <form action="{{ route('breeds.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن التلقيح" name="search">
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
                                            <th scope="col">تاريخ التلقيح</th>
                                            <th scope="col"> نوع التلقيح</th>
                                            <th scope="col">حالة التلقيح </th>
                                            <th scope="col"> يكلف</th>
                                            <th scope="col"> تم التلقيح بواسطة (ان وجد)</th>
                                            <th scope="col"> تاريخ الفحص</th>
                                            <th scope="col"> نتيجة الفحص</th>
                                            <th scope="col"> الملاحظات</th>
                                            <th scope="col"> تاريخ الميلاد المتوقع</th>
                                            <th scope="col">تعديل موعد التلقيح</th>
                                            <th scope="col">تعديل نتيجة التلقيح</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($breeds as $medicine)
                                            <tr>
                                                <th scope="row">{{ $medicine->id }}</th>
                                                <td>{{ $medicine->cowse->cownumber }}</td>
                                                <td>{{ $medicine->breedingdate }}</td>
                                                <td>
                                                    @if ($medicine->breedingtype == 1)
                                                        التلقيح الطبيعي
                                                    @elseif ($medicine->breedingtype == 2)
                                                        التلقيح الصناعي
                                                    @else
                                                        غير معروف
                                                    @endif

                                                </td>
                                                <td>{{ $medicine->breedingstatus }} </td>
                                                <td>{{ $medicine->cost }}</td>
                                                <td>{{ $medicine->pollinationby }}</td>
                                                <td>{{ $medicine->examinationdate }}</td>
                                                <td>{{ $medicine->result }}</td>
                                                <td>{{ $medicine->note }}</td>
                                                <td>{{ $medicine->expectedbirthdate }}</td>


                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal-{{ $medicine->id }}"
                                                        data-cow-id="{{ $medicine->id }}">
                                                        تعديل موعد التلقيح
                                                    </button>
                                                    <br>
                                                    <br>


                                                    @include('breeds.update')
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal2-{{ $medicine->id }}"
                                                        data-cow-id="{{ $medicine->id }}">
                                                        تعديل نتيجة التلقيح
                                                    </button>
                                                    @include('breeds.update2')

                                                </td>
                                                <td>
                                                    <form action="{{ route('breeds.destroy', ['id' => $medicine->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('هل انت متأكد من حذف موعد التلقيح؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <!-- Add your empty state message if needed -->
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
