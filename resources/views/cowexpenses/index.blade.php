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

                            @can('create-cowexpenses')
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    انشاء مصروف للبقرة
                                </button>

                                @include('cowexpenses.create')
                            @endcan
                            <a href="{{ route('cowexpenses.export') }}" class="btn btn-success">تحميل كملف
                                Excel</a>
                            <label for="fileInput" class="btn btn-success" id="customFileLabel">ارفع ملف مصاريف البقر
                            </label>
                            <form id="uploadForm" action="{{ route('cowexpenses.import') }}" method="post"
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
                            <form action="{{ route('cowexpenses.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن مصروف للبقرة"
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
                                            <th scope="col"> اسم المصروف</th>
                                            <th scope="col"> كمية </th>
                                            <th scope="col">تعديل</th>
                                            <th scope="col">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cowexpenses as $medicine)
                                            <tr>
                                                <th scope="row">{{ $medicine->id }}</th>
                                                <td>{{ $medicine->products->productname }}</td>
                                                <td>{{ $medicine->quantity }}</td>
                                                <td>
                                                    @can('edit-cowexpenses')
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $medicine->id }}"
                                                            data-cow-id="{{ $medicine->id }}">
                                                            تعديل مصروف البقرة
                                                        </button>

                                                        @include('cowexpenses.update')
                                                    @endcan
                                                </td>

                                                <td>
                                                    @can('delete-cowexpenses')
                                                        <form
                                                            action="{{ route('cowexpenses.destroy', ['id' => $medicine->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('هل انت متأكد من حذف مصروف البقرة ؟');">
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
