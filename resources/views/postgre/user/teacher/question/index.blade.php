@extends('postgre.user.teacher.master')

@section('title','iCLOP | Bank Soal')

@section('content-header')
<div class="content-header">
  <div class="container">
    <div class="row">
      <div class="col"><p>Bank Soal</p></div>
      <div class="col-sm-6">
        <button class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Data</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <table id="tabel_soal" class="table table-hover table-head-fixed text-nowrap" style="width:100%">
          <thead>
            <th>No</th>
            <th>Soal</th>
            <th>Sub Topik</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="add_question" action="{{ route('teacher.question.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Soal</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="topic">Topik</label>
            <select class="form-control" id="topic" required>
                <option value="">Pilih Topik</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sub_topic_id">Sub Topik</label>
            <select class="form-control" name="sub_topic_id" id="sub_topic_id" required>
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
              <label for="guidance">File Panduan</label>
              <input type="file" name="guidance" class="form-control">
              <span class="text-danger error-text guidance_error"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning btn-block">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('postgre.user.teacher.question.edit-question-modal')
@endsection

@section('script')
<script>
    
$.getJSON("{{ route('teacher.topics.list') }}", function(data) {
    let options = '<option value="">-- Pilih Topic --</option>';
    data.forEach(topic => {
        options += `<option value="${topic.id}">${topic.name}</option>`;
    });
    $('#topic').html(options);
});


$('#topic').on('change',function(){
  let t=$(this).val();
  $('#sub_topic_id').prop('disabled',true).html('<option>Loading…</option>');
  $.getJSON("{{ url('t/subtopics') }}/"+t,function(list){
    let h='<option selected disabled>- Pilih Sub Topic -</option>';
    list.forEach(st=>h+=`<option value="${st.id}">${st.name}</option>`);
    $('#sub_topic_id').html(h).prop('disabled',false);
  });
});

$('#tabel_soal').DataTable({
  processing:true,serverSide:true,ajax:"{{ route('teacher.question.datatable') }}",
  columns:[
    {data:"id",name:"id"},
    {data:"title",name:"title"},
    {data:"sub_topic_name",name:"sub_topic_name"},
    {data:"description",name:"description"},
    {data:"actions",name:"actions"}
  ]
});

$('#add_question').on('submit',function(e){
  e.preventDefault();
  let f=this;
  $.ajax({
    url:$(f).attr('action'),
    method:$(f).attr('method'),
    data:new FormData(f),
    processData:false,contentType:false,dataType:'json',
    beforeSend(){ $(f).find('span.error-text').text('') },
    success(data){
      if(data.code===0){
        $.each(data.error,(i,v)=>$(f).find(`span.${i}_error`).text(v[0]));
      } else {
        f.reset();
        $('#sub_topic_id').prop('disabled',true).html('<option selected disabled>- Pilih Sub Topic -</option>');
        $('#addModal').modal('hide');
        toastr.success(data.msg);
        $('#tabel_soal').DataTable().ajax.reload(null,false);
      }
    }
  });
});

$(document).on('click','#detailBtn',function(){
  let id=$(this).data('id');
  $.get("{{ route('teacher.question.detail') }}",{question_id:id},function(d){
    let m=$('.editQuestionModal');
    m.find('input[name="qid"]').val(d.details.id);
    m.find('input[name="title"]').val(d.details.title);
    m.find('select[name="sub_topic_id"]').val(d.details.sub_topic_id);
    m.find('textarea[name="description"]').val(d.details.description);
    m.find('textarea[name="test_code"]').val(d.details.test_code);
    m.find('input[type="file"]').val('');
    m.modal('show');
  },'json');
});

$('#update_question').on('submit',function(e){
  e.preventDefault();
  let f=this;
  $.ajax({
    url:$(f).attr('action'),
    method:$(f).attr('method'),
    data:new FormData(f),
    processData:false,contentType:false,dataType:'json',
    beforeSend(){ $(f).find('span.error-text').text('') },
    success(data){
      if(data.code===0){
        $.each(data.error,(i,v)=>$(f).find(`span.${i}_error`).text(v[0]));
      } else {
        $('#tabel_soal').DataTable().ajax.reload(null,false);
        $('#updateModal').modal('hide');
        f.reset();
        toastr.success(data.msg);
      }
    }
  });
});
</script>
@endsection
