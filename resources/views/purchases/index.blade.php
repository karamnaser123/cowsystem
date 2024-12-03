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
                            @can('create-purchases')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    انشاء مشتريات
                                </button>
                                @include('purchases.create')
                            @endcan
                            <a href="{{ route('purchases.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>

                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف المشتريات
                            </label>
                            <form id="uploadForm" action="{{ route('purchases.import') }}" method="post"
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
                            <form action="{{ route('purchases.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن مشترياتي"
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
                                            <th scope="col"> اسم المورد</th>
                                            <th scope="col"> اسم المنتج</th>
                                            <th scope="col"> كمية المنتج(بالكيلو)</th>
                                            <th scope="col"> كمية المنتج</th>
                                            <th scope="col"> السعر الاجمالي</th>
                                            <th scope="col"> طريقة الدفع</th>
                                            <th scope="col"> اسم البنك</th>
                                            <th scope="col"> رقم الشيك</th>
                                            <th scope="col"> تاريخ الصرف</th>
                                            <th scope="col"> تاريخ الإنشاء</th>
                                            <th scope="col">تعديل</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($purchases as $medicine)
                                            <tr>
                                                <th scope="row">{{ $medicine->id }}</th>
                                                <td>{{ $medicine->supplier->name }}</td>
                                                <td>{{ $medicine->productname }}</td>
                                                <td>{{ $medicine->purchasingprice }}JOD</td>
                                                <td>{{ $medicine->productquantity }}</td>
                                                <td>{{ $medicine->totalprice }}JOD</td>
                                                <td>{{ $medicine->payment->name }}</td>
                                                <td>{{ $medicine->bankname }}</td>
                                                <td>{{ $medicine->checknumber }}</td>
                                                <td>{{ $medicine->exchangedate }}</td>
                                                <td>{{ $medicine->created_at }}</td>

                                                <td>
                                                    @can('edit-purchases')
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $medicine->id }}"
                                                            data-cow-id="{{ $medicine->id }}">
                                                            تعديل المشتريات
                                                        </button>

                                                        @include('purchases.update')
                                                    @endcan
                                                </td>

                                                <td>
                                                    @can('delete-purchases')
                                                        <form
                                                            action="{{ route('purchases.destroy', ['id' => $medicine->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل انت متأكد من حذف المشتريات ؟');">
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
