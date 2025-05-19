@extends('postgre.user.student.master')
@section('title')
    iCLOP | Daftar Nilai
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Daftar Nilai</p>
                    <div class="callout callout-info">
                        <h4> Nilai: {{ $result }}</h4>
                        <p>
                            Jawaban Benar: {{ $passed }} <br>
                            Jumlah Soal:{{ $question }}
                        </p>
                    </div>
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
                        <table id="tabel_nilai" class="table table-hover table-head-fixed text-nowrap" style="width: 100%">
                            <thead>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Tanggal Submit</th>
                                <th>Tanggal Update</th>
                                <th>Status</th>
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
    @include('postgre.user.student.result.detail-nilai-latihan-modal')
@endsection

@section('script')
    <script>
        $('#tabel_nilai').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('student.result.getByExerciseDataTable', ['exercise_id' => $exercise_id]) }}",
            columns: [{
                    data: "no",
                    name: "no"
                },
                {
                    data: "title",
                    name: "title"
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "updated_at",
                    name: "updated_at"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "actions",
                    name: "actions",
                    searchable: false,
                    orderable: false,
                },
            ]
        });

        $(document).on('click', '#jawaban', function() {
            const submission_id = $(this).data('id');
            const url = '{{ route('student.result.getSubmissionDetail') }}';
            // alert();
            $.get(url, {
                submission_id: submission_id
            }, function(data) {
                const modal = $('.solutionModal');
                // $(modal).find('h5').text(data.details[0].title);
                // $(modal).find('h6').text(data.details[0].updated_at);
                $(modal).find('h4').text(data.details[0].soal['title']);
                $(modal).find('code').text(data.details[0].solution);
                $(modal).modal('show');
            }, "json");
        });
    </script>
@endsection
