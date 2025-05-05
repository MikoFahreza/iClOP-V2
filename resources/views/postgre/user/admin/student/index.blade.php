@extends('postgre.user.admin.master') @section('title')
    iCLOP | Mahasiswa
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Mahasiswa</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <form action="{{ route('admin.student.getClassIDForDataTable') }}" method="POST" id="select_class_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <select name="academic_year_id" class="form-control" id="year-dropdown">
                                            <option value="" disabled selected>Tahun Ajaran</option>
                                            @forelse ($year as $item)
                                                <option value="{{ $item->{'id'} }}">{{ $item->{'name'} }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No Data
                                                </option>
                                            @endforelse
                                        </select>
                                        <span class="text-danger error-text year_academic_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="class_id" class="form-control" id="class-dropdown">
                                        <option value="" disabled selected>Kelas</option>
                                    </select>
                                    <span class="text-danger error-text class_id_error"></span>
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
                <div class="col-lg-6 col-12">
                    <table id="class_student_table" class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                            <th>Nama</th>
                            <th>Kelas</th>
                            {{-- <th>Status</th> --}}
                            <th>Hapus</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="col-lg-6 col-12">
                    <table id="all_student_table" class="table table-hover table-head-fixed text-nowrap"
                        style="width: 100%">
                        <thead>
                            <th>Nama</th>
                            {{-- <th>Kelas</th> --}}
                            {{-- <th>Status</th> --}}
                            <th>Tambahkan</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('script')
    <script>
        let class_id = 0;

        $("#all_student_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('admin.student.getAllDatatable') }}",
            columns: [{
                    data: "name",
                    name: "name",
                },
                // {
                //     data: "class_name",
                //     name: "class_name",
                // },
                {
                    data: "actions",
                    name: "actions",
                },
            ],
        });

        $("#class_student_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('admin.student.getDatatable', ['class_id' => -1]) }}",
            columns: [{
                    data: "name",
                    name: "name",
                },
                {
                    data: "class_name",
                    name: "class_name",
                },
                // {
                //     data: "status",
                //     name: "status",
                // },
                {
                    data: "actions",
                    name: "actions",
                },
            ],
        });

        $('#year-dropdown').on('change', function() {
            var yid = this.value;
            $("#class-dropdown").html('');
            $.ajax({
                url: "{{ route('admin.student.getClassAsOption') }}",
                type: "POST",
                data: {
                    yid: yid,
                },
                dataType: 'json',
                success: function(result) {
                    $('#class-dropdown').html('<option value="">Kelas</option>');
                    $.each(result.class, function(key, value) {
                        $("#class-dropdown").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $("#select_class_form").on("submit", function(e) {
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
                        class_id = data.msg;
                        var url = "{{ route('admin.student.getDatatable', ['class_id' => -1]) }}"
                            .replace("-1", data.msg);
                        $("#class_student_table").DataTable().ajax.url(url).load();
                        alert(class_id);
                    }
                },
            });
        });

        $(document).on("click", "#assignStudentToClassBtn", function() {
            const student_id = $(this).data('id');
            alert(class_id);
            const url = "{{ route('admin.student.assignStudentToClass') }}"
            if (confirm("Tambahkan sebagai Mahasiswa?")) {
                $.post(url, {
                    student_id: student_id,
                    class_id: class_id
                }, function(data) {
                    if (data.code == 1) {
                        $('#all_student_table').DataTable().ajax.reload(null, false);

                        var newurl = "{{ route('admin.student.getDatatable', ['class_id' => -1]) }}"
                            .replace("-1", class_id);
                        $("#class_student_table").DataTable().ajax.url(newurl).load();
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });

        $(document).on("click", "#removeStudentFromClassBtn", function() {
            const student_id = $(this).data('id');
            alert(class_id);
            const url = "{{ route('admin.student.removeStudentFromClass') }}"
            if (confirm("Hapus dari daftar Mahasiswa?")) {
                $.post(url, {
                    student_id: student_id,
                    class_id: class_id
                }, function(data) {
                    if (data.code == 1) {
                        $('#all_student_table').DataTable().ajax.reload(null, false);

                        var newurl = "{{ route('admin.student.getDatatable', ['class_id' => -1]) }}"
                            .replace("-1", class_id);
                        $("#class_student_table").DataTable().ajax.url(newurl).load();
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    </script>
@endsection
