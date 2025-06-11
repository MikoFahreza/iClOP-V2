@extends('postgre.user.student.master') @section('title')
    iCLOP | Latihan
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Latihan</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                @forelse ($exercise as $item)
                    <div class="col-lg-4">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ $item->{'name'} }}</h3>
                                <p>{{ $item->year->{'name'} }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('student.exerciseQuestion', ['exercise_id' => $item->{'id'}, 'question_no' => 1]) }}"
                                class="small-box-footer bg-blue"> KERJAKAN <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @empty
                    <code>No data available!</code>
                @endforelse

            </div>
        </div>
    </div>
@endsection
