<!-- Modal -->
<div class="modal fade modalEditClass" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.class.update') }}" enctype="multipart/form-data" method="POST"
                    id="form_update_data">
                    @csrf
                    <input type="hidden" name="cid" />
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="name">Nama</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Nama" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="academic_year_id">Tahun Ajaran</label>
                            <div class="input-group">
                                <select name="academic_year_id" class="form-control" id="semeseter">
                                    @forelse ($year as $item)
                                        <option value="{{ $item->{'id'} }}">{{ $item->{'name'} }}</option>
                                    @empty
                                        <option disabled>Not Found</option>
                                    @endforelse
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text academic_year_id_error"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="name">Dosen</label>
                            <div class="input-group">
                                <select name="teacher_id" class="form-control">
                                    @forelse ($teacher as $item)
                                        <option value="{{ $item->{'id'} }}">{{ $item->user->{'name'} }}</option>
                                    @empty
                                        <option disabled>Not Found</option>
                                    @endforelse
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text teacher_id_error"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">
                        Update
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
