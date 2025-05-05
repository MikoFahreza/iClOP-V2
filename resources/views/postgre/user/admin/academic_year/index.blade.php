@extends('postgre.user.admin.master') @section('title')
    iCLOP | Tahun Ajaran
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Tahun Ajaran</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-lightblue">
                                <div class="inner">
                                    @forelse ($tahun_ajaran as $item)
                                        <h3>{{ $item->{'name'} }}</h3>
                                        <h5>{{ $item->{'semester'} }}</h5>
                                    @empty
                                        <h3>No Data</h3>
                                    @endforelse
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                                <p class="small-box-footer">Tahun Ajaran Aktif</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="btn btn-block btn-info font-weight-bold" data-toggle="modal"
                                data-target="#exampleModal">
                                Tambah
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-12">
                    <div class="col-12">
                        <table id="academic_year_table" class="table table-hover table-head-fixed text-nowrap"
                            style="width: 100%">
                            <thead>
                                <th>Tahun Ajaran</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade academicYearAddForm" id="exampleModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tahun Ajaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.academic_year.add') }}" enctype="multipart/form-data"
                                method="POST" id="form_tambah_data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="name">Nama</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Tahun ajaran" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-book"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="semester">Semester</label>
                                        <div class="input-group">
                                            <select name="semester" class="form-control" id="semeseter">
                                                <option selected disabled>
                                                    -- Semester --
                                                </option>
                                                <option value="Ganjil">
                                                    Ganjil
                                                </option>
                                                <option value="Genap">Genap</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-book"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text semester_error"></span>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="start_date"
                                                placeholder="Tanggal mulai" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text start_date_error"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="end_date">Tanggal berakhir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="end_date"
                                                placeholder="Tanggal berakhir" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger error-text end_date_error"></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Tambah
                                </button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @include('postgre.user.admin.academic_year.modal-edit-tahun')
        </div>
    </div>
    @endsection @section('script')
    <script>
        $("#academic_year_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('admin.academic_year.get_datatable') }}",
            columns: [{
                    data: "name",
                    name: "name",
                },
                {
                    data: "semester",
                    name: "semester",
                },
                {
                    data: "status",
                    name: "status",
                },
                {
                    data: "actions",
                    name: "actions",
                },
            ],
        });

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
                        $("#academic_year_table")
                            .DataTable()
                            .ajax.reload(null, false);
                        $(".academicYearAddForm").modal("hide");
                        alert(data.msg);
                        toastr.success(data.msg);
                    }
                },
            });
        });

        $(document).on("click", "#detailTahunBtn", function() {
            const year_id = $(this).data("id");
            const url = `{{ route('admin.academic_year.detail') }}`;
            $(".modalEditTahun").find("form")[0].reset();
            $.get(
                url, {
                    year_id: year_id
                },
                function(data) {
                    const yearModal = $(".modalEditTahun");
                    $(yearModal)
                        .find("form")
                        .find('input[name="yid"]')
                        .val(data.details.id);
                    $(yearModal)
                        .find("form")
                        .find('input[name="name"]')
                        .val(data.details.name);
                    $(yearModal)
                        .find("form")
                        .find('input[name="start_date"]')
                        .val(data.details.start_date);
                    $(yearModal)
                        .find("form")
                        .find('input[name="end_date"]')
                        .val(data.details.end_date);
                    $(yearModal)
                        .find("form")
                        .find('select[name="semester"]')
                        .val(data.details.semester);
                    $(yearModal).modal("show");
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
                        $("#academic_year_table")
                            .DataTable()
                            .ajax.reload(null, false);
                        $(".modalEditTahun").modal("hide");
                        $(".modalEditTahun").find("form")[0].reset();
                        toastr.success(data.msg);
                    }
                },
            });
        });

        $(document).on("click", "#setAsActiveYearBtn", function() {
            const id = $(this).data('id');
            const url = "{{ route('admin.academic_year.setActive') }}"
            if (confirm("Tandai sebagai Aktif?")) {
                $.post(url, {
                    id: id
                }, function(data) {
                    if (data.code == 1) {
                        $('#academic_year_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });

        $(document).on("click", "#setAsNonActiveYearBtn", function() {
            const id = $(this).data('id');
            const url = "{{ route('admin.academic_year.setDone') }}"
            if (confirm("Tandai sebagai Selesai?")) {
                $.post(url, {
                    id: id
                }, function(data) {
                    if (data.code == 1) {
                        $('#academic_year_table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    </script>
@endsection
