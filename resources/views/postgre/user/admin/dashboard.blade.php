@extends('postgre.user.admin.master') @section('title')
    iCLOP | Beranda
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Dashboard</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            @forelse ($tahun_ajaran as $item)
                                <h3>{{ $item->{'name'} }}</h3>
                                <h5>{{ $item->{'semester'} }}</h5>
                            @empty
                                <h3>No Data</h3>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.academic_year') }}" class="small-box-footer">Tahun Ajaran <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Kelas</h3>
                            <p>Daftar Kelas</p>
                        </div>
                        <a href="{{ route('admin.class') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Dosen</h3>
                            <p>Daftar Dosen</p>
                        </div>
                        <a href="{{ route('admin.teacher') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Mahasiswa</h3>
                            <p>Daftar Mahasiswa</p>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
