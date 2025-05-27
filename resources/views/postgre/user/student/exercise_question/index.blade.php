@extends('postgre.user.student.master') @section('title')
    iCLOP | Daftar Soal
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Daftar Soal</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <table id="tabel_soal" class="table table-hover table-head-fixed text-nowrap" style="width: 100%">
                            <thead>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Topik</th>
                                <th>Sub Topik</th>
                                <th>Deskrpsi</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#tabel_soal').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('student.exerciseQuestion.questionList', ['exercise_id' => $exercise_id]) }}",
            columns: [{
                    data: "no",
                    name: "no"
                },
                {
                    data: "title",
                    name: "title"
                },
                {
                    data: "topic_name",
                    name: "topic_id"
                },
                {
                    data: "sub_topic_name",
                    name: "sub_topic_id"
                },
                {
                    data: "description",
                    name: "description"
                },
                {
                    data: "actions",
                    name: "actions"
                },
            ]
        });
    </script>
@endsection
