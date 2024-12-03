<!-- Include jQuery -->
@extends('layouts.app')
@section('body')
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute"
        data-header-position="absolute" data-boxed-layout="full">

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
  
                        <!-- Search Bar -->
                        {{-- <div class="mb-3">
                            <form action="{{ route('suppliers.search') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="ابحث عن   مورد" name="search">
                                    <button class="btn btn-outline-secondary" type="submit">بحث</button>
                                </div>
                            </form>
                        </div> --}}
                        <div class="card">
                            <div class="table-responsive m-t-20">
                                <table class="table table-bordered table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                          <th scope="col">الربح الاجمالي خلال شهر</th>
                                            <th scope="col">  الشهر</th>
                                            <th scope="col">  السنة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($totalprice as $totalprices)
                                            <tr>
                                                <th scope="row">{{ $totalprices->id }}</th>
                                                <td>{{ $totalprices->totalprice }}</td>
                                                <td>{{ $totalprices->month }}</td>
                                                <td>{{ $totalprices->year }}</td>
                             

                            
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
