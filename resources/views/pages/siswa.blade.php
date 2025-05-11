@extends('layouts.app')

@section('title', 'Siswa')

@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('main')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Siswa</h3>
            </div>
            <div class="card-body">
                <table id="list_siswa" class="table table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
$(document).ready(function() {
    var dataTable = $('#list_siswa').DataTable({
        order: [],
        fixedHeader: true,
        columnDefs: [
            { className: 'text-center', targets: 0 },
            { orderable: false, className: 'text-center', targets: 6 }
        ],
        pagingType: 'simple_numbers',
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: true,
        responsive: true,
        scrollX: true,
        ajax: "{{ route('siswa.json_data') }}"
    });

    // Tambah siswa
    $('#formTambahSiswa').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('siswa.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    dataTable.ajax.reload();
                    $('#modalTambahSiswa').modal('hide');
                }
            }
        });
    });

    // Edit siswa
    window.editSiswa = function(id) {
        // Ambil data siswa dan tampilkan di modal edit
        $.get('/siswa/json_data', function(res) {
            var siswa = res.data.find(row => row[6].includes('editSiswa(' + id + ')'));
            if(siswa) {
                // Set value ke form edit (implementasi sesuai kebutuhan)
                // $('#formEditSiswa input[name=nama]').val(siswa[2]);
                // ...
                $('#modalEditSiswa').modal('show');
            }
        });
    }

    // Update siswa
    $('#formEditSiswa').on('submit', function(e) {
        e.preventDefault();
        var id = $('#formEditSiswa input[name=id]').val();
        $.ajax({
            url: '/siswa/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    dataTable.ajax.reload();
                    $('#modalEditSiswa').modal('hide');
                }
            }
        });
    });

    // Hapus siswa
    window.deleteSiswa = function(id) {
        if(confirm('Yakin ingin menghapus siswa ini?')) {
            $.ajax({
                url: '/siswa/' + id,
                method: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(res) {
                    if(res.success) {
                        dataTable.ajax.reload();
                    }
                }
            });
        }
    }
});
</script>
@endpush
