@extends('postgre.user.teacher.master')

@section('title', 'iCLOP | Dashboard')

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
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Kelas</h3>
                            <p>Daftar Kelas</p>
                        </div>
                        <div class="icon">
                            
                        </div>
                        <a href="{{ route('teacher.class') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Nilai</h3>
                            <p>Daftar Nilai Mahasiswa</p>
                        </div>
                        <div class="icon">
                            
                        </div>
                        <a href="{{route('teacher.exerciseResult')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Soal</h3>
                            <p>Daftar Soal</p>
                        </div>
                        <div class="icon">
                            
                        </div>
                        <a href="{{ route('teacher.question') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>Latihan</h3>
                            <p>Daftar Latihan</p>
                        </div>
                        <div class="icon">
                            
                        </div>
                        <a href="{{ route('teacher.exercise') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
