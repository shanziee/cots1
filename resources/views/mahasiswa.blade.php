<script>
let table;
let save_method;
let modal = new bootstrap.Modal(document.getElementById('modalForm'));

// CSRF setup (WAJIB)
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(document).ready(function(){

    table = $('#myTable').DataTable({
        ajax: {
            url: "/data",
            dataSrc: ""
        },
        columns: [
            { data: "nama" },
            { data: "nim" },
            { data: "jurusan" },
            {
                data: null,
                render: function(data){
                    return `
                        <button class="btn btn-warning btn-sm" onclick="edit(${data.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="hapus(${data.id})">Hapus</button>
                    `;
                }
            }
        ]
    });

});

function tambah(){
    save_method = "add";

    $('#id').val('');
    $('#nama').val('');
    $('#nim').val('');
    $('#jurusan').val('');

    modal.show();
}

function simpan(){
    let url = save_method == "add" ? "/store" : "/update/" + $('#id').val();
    let method = save_method == "add" ? "POST" : "PUT";

    $.ajax({
        url: url,
        type: method,
        data: {
            nama: $('#nama').val(),
            nim: $('#nim').val(),
            jurusan: $('#jurusan').val()
        },
        success: function(){
            modal.hide();
            table.ajax.reload();
        }
    });
}

function edit(id){
    save_method = "edit";

    $.get("/edit/" + id, function(data){
        $('#id').val(data.id);
        $('#nama').val(data.nama);
        $('#nim').val(data.nim);
        $('#jurusan').val(data.jurusan);

        modal.show();
    });
}

function hapus(id){
    if(confirm("Hapus data?")){
        $.ajax({
            url: "/delete/" + id,
            type: "DELETE",
            success: function(){
                table.ajax.reload();
            }
        });
    }
}
</script>
