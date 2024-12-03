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
                            @can('create-cowbirth')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    انشاء مولود للبقرة
                                </button>
                                @include('cowbirth.create')
                            @endcan

                            <a href="{{ route('cowbirth.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>

                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف مواليد البقر
                            </label>
                            <form id="uploadForm" action="{{ route('cowbirth.import') }}" method="post"
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
                            <form action="{{ route('cowbirth.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن مولود للبقرة"
                                        name="search">
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
                                            <th scope="col">رقم البقرة المولودة</th>
                                            <th scope="col">رقم البقرة الام</th>
                                            <th scope="col"> تاريخ ميلاد البقرة</th>
                                            <th scope="col"> جنس البقرة</th>
                                            <th scope="col"> الملاحظات</th>
                                            <th scope="col">تعديل</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cowbirth as $medicine)
                                            <tr>
                                                <th scope="row">{{ $medicine->id }}</th>
                                                @if (isset($medicine->cownumber))
                                                    <td>{{ $medicine->cowse->cownumber }}</td>
                                                @else
                                                    <td>فارغ</td>
                                                @endif

                                                @if (isset($medicine->mothernumber))
                                                    <td>{{ $medicine->cowse2->cownumber }}</td>
                                                @else
                                                    <td>فارغ</td>
                                                @endif
                                                <td>{{ $medicine->dateofbirth }}</td>
                                                <td>
                                                    @if ($medicine->gender == 1)
                                                        ذكر
                                                    @elseif ($medicine->gender == 2)
                                                        أنثى
                                                    @else
                                                        غير معروف
                                                    @endif
                                                </td>
                                                <td>{{ $medicine->note }}</td>

                                                <td>
                                                    @can('edit-cowbirth')
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $medicine->id }}"
                                                            data-cow-id="{{ $medicine->id }}">
                                                            تعديل المولد للبقرة
                                                        </button>

                                                        @include('cowbirth.update')
                                                    @endcan
                                                </td>

                                                <td>
                                                    @can('delete-cowbirth')
                                                        <form action="{{ route('cowbirth.destroy', ['id' => $medicine->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل انت متأكد من حذف مولود للبقرة ؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endcan
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
