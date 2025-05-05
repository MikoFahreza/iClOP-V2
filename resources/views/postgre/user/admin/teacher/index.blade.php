@extends('postgre.user.admin.master') @section('title')
    iCLOP | Dosen
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Dosen</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control" placeholder="Nama">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select class="form-control">
                                        <option value="" disabled selected>Tahun Ajaran</option>
                                        <option value="">2021/2022</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select class="form-control">
                                        <option disabled selected>Dosen</option>
                                        <option>option 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Tambah</button>
                    </form>
                </div>
                <div class="col-lg-8">
                    <form>
                        @csrf
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Type your keywords here">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        @forelse ($teacher as $item)
                            <div class="col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <i class="fa-solid fa-user-circle"></i>
                                        </div>
                                        <h3 class="profile-username text-center">{{ $item->user->name }}</h3>
                                        <hr>
                                        <p class="text-center text-muted"></p>
                                        <a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <code>No Data</code>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
