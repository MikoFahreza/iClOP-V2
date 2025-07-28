@extends('postgre.user.teacher.master') @section('title')
    iCLOP | Latihan
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Kelas</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container" id="class_container">
            <div class="row">
                <div class="col-lg-4">
                    <form action="{{ route('teacher.exercise.add') }}" method="POST" id="form_tambah_data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control form-control"
                                            placeholder="Nama latihan">
                                    </div>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="description" class="form-control" placeholder="Deskripsi">
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                            <label for="guidance">File Panduan
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="guidance"
                                                    data-value="">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-file-pdf"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-danger error-text guidance_error"></span>
                                        </div>
                                    </div>
                        <div class="form-row">
                        <div class="form-group col-sm-8">
                            <label for="duration">Durasi (menit)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="duration" min="1" placeholder="Durasi dalam menit" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-clock"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text duration_error"></span>
                        </div>
                    </div>
                        <button type="submit" class="btn btn-block btn-info">Tambah</button>
                    </form>
                </div>
                <div class="col-lg-8">
                    <form action="" method="GET">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type your keywords here">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        @forelse ($exercise as $item)
                            <div class="col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <i class="fa-solid fa-building-columns"></i>
                                        </div>
                                        <h3 class="profile-username text-center">{{ $item->{'name'} }}</h3>
                                        
                                        <button class="btn btn-primary btn-block" id="exerciseDetailBtn"
                                            data-id={{ $item->{'id'} }}><b>Detail</b></button>
                                        <a href="{{ route('teacher.exerciseQuestion', ['exercise_id' => $item->{'id'}]) }}" class="btn btn-success btn-block"
                                            id="classStudentBtn" data-id={{ $item->{'id'} }}><b>Soal</b></a>
                                        <button class="btn btn-danger btn-block" id="exerciseDeleteBtn"
                                            data-id={{ $item->{'id'} }}><b>Hapus</b></button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4">
                                <code>No Data</code>
                            </div>
                        @endforelse
                    </div>
                    {{ $exercise->links() }}
                </div>
            </div>
            @include('postgre.user.teacher.exercise.modal-edit-exercise')
        </div>
    </div>
    @endsection @section('script')
    <script>
        $("#form_tambah_data").on("submit", function(e) {
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
                        $(form)[0].reset();
                        // alert(data.msg);
                        toastr.success(data.msg);
                        $("#class_container").load(location.href + " #class_container");
                    }
                },
            });
        });

        $(document).on("click", "#exerciseDetailBtn", function() {
            const eid = $(this).data("id");
            const url = "{{ route('teacher.exercise.detail') }}";
            $(".modalEditExercise").find("form")[0].reset();
            $.get(
                url, {
                    eid: eid
                },
                function(data) {
                    const exerciseModal = $(".modalEditExercise");
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="eid"]')
                        .val(data.details[0].id);
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="name"]')
                        .val(data.details[0].name);
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="description"]')
                        .val(data.details[0].description);
                    $(exerciseModal).modal("show");
                },
                "json"
            );
        });

        $("#form_update_data").on("submit", function(e) {
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
                        $(".modalEditExercise").modal("hide");
                        $(".modalEditExercise").find("form")[0].reset();
                        toastr.success(data.msg);
                        $("#class_container").load(location.href + " #class_container");
                    }
                },
            });
        });

        $(document).on("click", "#exerciseDeleteBtn", function() {
            const exercise_id = $(this).data("id");
            const url = "{{ route('teacher.exercise.delete') }}";
            
            if (confirm("Apakah Anda yakin ingin menghapus exercise ini? Semua data terkait akan ikut terhapus.")) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        exercise_id: exercise_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 1) {
                            toastr.success(data.msg);
                            $("#class_container").load(location.href + " #class_container");
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Terjadi kesalahan saat menghapus exercise");
                    }
                });
            }
        });
    </script>
@endsection
