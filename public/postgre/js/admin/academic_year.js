$('#academic_year_table').DataTable({
    processing: true,
    info: true,
    serverSide: true,   
    ajax: "{{ route('admin.academic_year.get_datatable') }}",
    columns: [
        {
            data: "name",
            name: "name"
        },
        {
            data: "status",
            name: "status"
        },
        {
            data: "actions",
            name: "actions"
        },
    ]
});
