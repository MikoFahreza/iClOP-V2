@extends('postgre.user.teacher.master')
@section('title')
    iCLOP | Daftar Nilai
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Daftar Nilai</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                @forelse ($class as $item)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ $item->name }}</h3>
                                <p>Kelas</p>
                            </div>
                            <div class="icon">
                            </div>
                            <a href="{{ route('teacher.exerciseResultByClass', ['class_id' => $item->id]) }}"
                                class="small-box-footer">Lihat Nilai <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @empty
                    <code>No Data</code>
                @endforelse

            </div>
        </div>
    </div>
@endsection
