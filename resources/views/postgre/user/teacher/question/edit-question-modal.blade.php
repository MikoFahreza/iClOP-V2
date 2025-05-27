<div class="modal fade editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-keyboard="false" data-backdrop="static" id="updateModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('teacher.question.update')}}" enctype="multipart/form-data" method="POST" id="update_question">
                @csrf
                <input type="hidden" name="qid">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_topic">Topik</label>
                        <select class="form-control" id="edit_topic" required>
                            <option value="">Pilih Topik</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_sub_topic_id">Sub Topik</label>
                        <select class="form-control" name="sub_topic_id" id="edit_sub_topic_id" required>
                            <option value="">Pilih Sub Topik</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="title">Nama Soal</label>
                            <input type="text" name="title" class="form-control" placeholder="Nama tugas">
                            <span class="text-danger error-text title_error"></span>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi tugas"></textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="test_code">Test Code</label>
                            <textarea name="test_code" rows="5" class="form-control" placeholder="Test code"></textarea>
                            <span class="text-danger error-text test_code_error"></span>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="guidance_update">File Panduan</label>
                            <input type="file" name="guidance_update" class="form-control">
                            <span class="text-danger error-text guidance_update_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btn-block">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    
// Load topics untuk modal edit
$.getJSON("{{ route('teacher.topics.list') }}", function(data) {
    let options = '<option value="">-- Pilih Topic --</option>';
    data.forEach(topic => {
        options += `<option value="${topic.id}">${topic.name}</option>`;
    });
    $('#edit_topic').html(options);
});

// Handle perubahan topic di modal edit
$('#edit_topic').on('change', function(){
    let t = $(this).val();
    $('#edit_sub_topic_id').prop('disabled', true).html('<option>Loading…</option>');
    $.getJSON("{{ url('t/subtopics') }}/" + t, function(list){
        let h = '<option selected disabled>- Pilih Sub Topic -</option>';
        list.forEach(st => h += `<option value="${st.id}">${st.name}</option>`);
        $('#edit_sub_topic_id').html(h).prop('disabled', false);
    });
});

// Update fungsi detailBtn untuk mengisi modal edit
$(document).on('click', '#detailBtn', function(){
    let id = $(this).data('id');
    $.get("{{ route('teacher.question.detail') }}", {question_id: id}, function(d){
        let m = $('.editQuestionModal');
        
        // Set form values
        m.find('input[name="qid"]').val(d.details.id);
        m.find('input[name="title"]').val(d.details.title);
        m.find('textarea[name="description"]').val(d.details.description);
        m.find('textarea[name="test_code"]').val(d.details.test_code);
        m.find('input[type="file"]').val('');
        
        // Load sub topics berdasarkan topic yang dipilih
        $.get("{{ route('teacher.question.detail') }}", {question_id: id}, function(detail){
            // Dapatkan topic_id dari sub_topic
            $.get("{{ url('t/subtopic-detail') }}/" + detail.details.sub_topic_id, function(subTopicData){
                // Set topic dropdown
                $('#edit_topic').val(subTopicData.topic_id).trigger('change');
                
                // Setelah sub topics dimuat, set sub topic yang dipilih
                setTimeout(function(){
                    $('#edit_sub_topic_id').val(detail.details.sub_topic_id);
                }, 500);
            });
        });
        
        m.modal('show');
    }, 'json');
});
</script>