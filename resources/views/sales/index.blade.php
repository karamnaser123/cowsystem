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
                            @can('create-sales')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    انشاء مبيعات
                                </button>
                                @include('sales.create')
                            @endcan
                            <a href="{{ route('sales.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>
                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف المبيعات
                            </label>
                            <form id="uploadForm" action="{{ route('sales.import') }}" method="post"
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
                            <form action="{{ route('sales.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن مبيعات" name="search">
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
                                            <th scope="col"> اسم العميل</th>
                                            <th scope="col"> صورة المنتج</th>
                                            <th scope="col"> اسم المنتج</th>
                                            <th scope="col"> سعر المنتج</th>
                                            <th scope="col"> كمية المنتج(بالكيلو) </th>
                                            <th scope="col"> مقدار الخصم</th>
                                            <th scope="col"> السعر الاجمالي</th>
                                            <th scope="col"> طريقة الدفع</th>
                                            <th scope="col"> اسم البنك</th>
                                            <th scope="col"> رقم الشيك</th>
                                            <th scope="col"> تاريخ الصرف</th>
                                            <th scope="col"> تاريخ البيع</th>
                                            <th scope="col"> تاريخ الإنشاء</th>
                                            <th scope="col">تعديل</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sales as $medicine)
                                            <tr>
                                                <th scope="row">{{ $medicine->id }}</th>
                                                <td>{{ $medicine->customer->name }}</td>
                                                <td> <img style="width: 50px; height: 50px;"
                                                        src="{{ asset('images/products/' . $medicine->products->productimage) }}">
                                                </td>
                                                <td>{{ $medicine->products->productname }}</td>
                                                @if ($medicine->price)
                                                    <td>{{ $medicine->price }}JOD</td>
                                                @else
                                                    <td>{{ $medicine->products->productprice }}JOD</td>
                                                @endif
                                                <td>{{ $medicine->productquantity }}</td>
                                                <td>{{ $medicine->discount }}JOD</td>
                                                <td>{{ $medicine->totalprice }}JOD</td>
                                                <td>{{ $medicine->payment->name }}</td>
                                                <td>{{ $medicine->bankname }}</td>
                                                <td>{{ $medicine->checknumber }}</td>
                                                <td>{{ $medicine->exchangedate }}</td>
                                                <td>{{ $medicine->datesale }}</td>
                                                <td>{{ $medicine->created_at }}</td>
                                                <td>
                                                    @can('edit-sales')
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $medicine->id }}"
                                                            data-cow-id="{{ $medicine->id }}">
                                                            تعديل المبيعات
                                                        </button>

                                                        @include('sales.update')
                                                    @endcan
                                                </td>

                                                <td>
                                                    @can('delete-sales')
                                                        <form action="{{ route('sales.destroy', ['id' => $medicine->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل انت متأكد من حذف المبيعات ؟');">
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
