@extends('postgre.user.student.master')

@section('title')
    iCLOP | Dashboard
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <p class="m-0"> Dashboard </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../../dist/img/avatar5.png"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                            <p class="text-muted text-center text-capitalize">{{ Auth::user()->role }}</p>
                            {{-- <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Exercise Completed</b> <a class="float-right">10</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Learning Result</b> <a class="float-right">543</a>
                                </li>
                            </ul> --}}
                            <button href="#" class="btn btn-primary btn-block"><b>Update</b></button>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>Latihan</h3>
                                            <p>Daftar Latihan</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{ route('student.exercise') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>Nilai</h3>
                                            <p>Daftar Nilai</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{ route('student.result') }}" class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            {{-- stats --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
