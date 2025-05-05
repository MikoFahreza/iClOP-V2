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
                <div class="col">
                    <form action="{{ route('teacher.exerciseResult.getExerciseIDForDataTable') }}" method="POST"
                        id="form_get_exercise">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select name="exercise_id" class="form-control">
                                        <option value="" disabled selected> --Pilih Latihan-- </option>
                                        @forelse ($exercise as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @empty
                                            <code>no data</code>
                                        @endforelse
                                    </select>
                                    <span class="text-danger error-text exercise_id_error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="col-12">
                        <table id="class_student_table" class="table table-hover table-head-fixed text-nowrap"
                            style="width: 100%">
                            <thead>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Passed</th>
                                <th>Jumlah Soal</th>
                                <th>Nilai Latihan</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let exercise_id;

        $("#class_student_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('teacher.exerciseResultByExerciseDataTable', ['class_id' => $class_id, 'exercise_id' => 1]) }}",
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
            ],
            columns: [{
                    data: "username",
                    name: "username",
                },
                {
                    data: "classname",
                    name: "classname",
                },
                {
                    data: "passed",
                    name: "passed",
                },
                {
                    data: "jumlah_soal",
                    name: "jumlah_soal",
                },
                {
                    data: "result",
                    name: "result",
                },
            ],
        });

        $("#form_get_exercise").on("submit", function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr("action"),
                method: $(form).attr("method"),
                data: new FormData(form),
                processData: false,
                dataType: "json",
                contentType: false,
                beforeSend: function() {
                    $(this).find("span.error-text").text("");
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form)
                                .find("span." + prefix + "_error")
                                .text(val[0]);
                        });
                    } else {
                        var newurl =
                            "{{ route('teacher.exerciseResultByExerciseDataTable', ['class_id' => $class_id, 'exercise_id' => -1]) }}"
                            .replace("-1", data.msg);
                        $("#class_student_table").DataTable().ajax.url(newurl).load();
                    }
                },
            });
        });
    </script>
@endsection
