<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow-lg p-4">

    <h3 class="mb-4 text-center">🎓 CRUD Data Mahasiswa</h3>

    <button class="btn btn-primary mb-3" onclick="tambah()">+ Tambah Data</button>

    <table id="myTable" class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
    </table>

</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalForm">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Form Mahasiswa</h5>
</div>

<div class="modal-body">
    <input type="hidden" id="id">

    <label>Nama</label>
    <input type="text" id="nama" class="form-control mb-2">

    <label>NIM</label>
    <input type="text" id="nim" class="form-control mb-2">

    <label>Jurusan</label>
    <input type="text" id="jurusan" class="form-control">
</div>

<div class="modal-footer">
    <button class="btn btn-success" onclick="simpan()">Simpan</button>
</div>

</div>
</div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let table;
let save_method;
let modal;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

$(document).ready(function(){

    modal = new bootstrap.Modal(document.getElementById('modalForm'));

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

    // VALIDASI
    if($('#nama').val() == '' || $('#nim').val() == '' || $('#jurusan').val() == ''){
        Swal.fire("Error", "Semua field wajib diisi!", "warning");
        return;
    }

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

            Swal.fire("Berhasil!", "Data berhasil disimpan", "success");
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
    Swal.fire({
        title: "Yakin?",
        text: "Data akan dihapus!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: "/delete/" + id,
                type: "DELETE",
                success: function(){
                    table.ajax.reload();
                    Swal.fire("Terhapus!", "Data berhasil dihapus", "success");
                }
            });
        }
    });
}
</script>

</body>
</html>
