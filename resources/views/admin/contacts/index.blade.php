<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - RentalKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f5f7f6; font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif; color: #1f2937; margin: 0; padding: 0; }
        .page-content { padding: 24px; }
        @media (max-width: 1024px) { .page-content { padding: 16px; } }
        .page-header { background: white; border-radius: 16px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,.05); }
        .page-title { font-weight: 700; color: #172033; font-size: 28px; margin: 0; }
        .page-subtitle { color: #6c757d; font-size: 14px; margin: 8px 0 0 0; }
        .stat-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,.05); height: 100%; transition: 0.25s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.05); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; background: #e8f5f2; color: #2c666e; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .stat-label { color: #6c757d; font-size: 13px; margin-bottom: 8px; }
        .stat-number { font-size: 28px; font-weight: 800; color: #172033; }
        .table-card { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,.05); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .table-title { font-weight: 700; color: #172033; font-size: 18px; margin: 0; }
        .table-subtitle { color: #6c757d; font-size: 13px; margin: 4px 0 0 0; }
        .table { margin: 0; }
        .table thead th { background: #f8faf9; color: #172033; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid #e9ecef; font-weight: 600; padding: 14px; vertical-align: middle; }
        .table tbody td { padding: 14px; vertical-align: middle; border-bottom: 1px solid #edf0ee; color: #172033; }
        .table tbody tr:hover { background: #fafbfa; }
        .table tbody tr:last-child td { border-bottom: none; }
        .visitor-name { font-weight: 600; color: #172033; }
        .visitor-email { color: #4b5563; font-size: 13px; word-break: break-word; }
        .subject-col { max-width: 300px; color: #4b5563; word-break: break-word; }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .status-belum { background: #fff3cd; color: #856404; }
        .status-dibaca { background: #cff4fc; color: #055160; }
        .status-dibalas { background: #d1e7dd; color: #0f5132; }
        .pagination { justify-content: flex-end; margin-top: 0; margin-bottom: 0; }
        .pagination .page-link { background: white; border: 1px solid #dee2e6; color: #0d6efd; }
        .pagination .page-link:hover { background: #e7f1ff; border: 1px solid #0d6efd; color: #0a58ca; }
        .pagination .page-item.active .page-link { background: #0d6efd; border: 1px solid #0d6efd; color: white; }
        .modal-header { border-bottom: 1px solid #e9ecef; }
        .modal-body { background: #fafbfa; }
        .field-group { margin-bottom: 16px; }
        .field-label { font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6c757d; margin-bottom: 6px; }
        .field-value { color: #172033; font-size: 14px; }
        .field-value.status { display: inline-block; }
        .action-btn { border: none; background: transparent; color: #6c757d; padding: 6px; cursor: pointer; font-size: 16px; transition: 0.2s; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; }
        .action-btn:hover { background: #e7f1ff; color: #0d6efd; }
        .action-btn-danger:hover { background: #f8d7da; color: #dc3545; }
        .modal-footer { border-top: 1px solid #e9ecef; padding: 16px 24px; }
        .modal-footer .btn { min-height: 38px; font-weight: 600; padding: 8px 16px; border-radius: 9px; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
        .modal-footer .btn-secondary { background-color: #6b7280; border-color: #6b7280; color: #fff; }
        .modal-footer .btn-danger { background-color: #dc3545; border-color: #dc3545; color: #fff; }
        .modal-footer .btn-primary { background-color: #198754; border-color: #198754; color: #fff; }
        .dataTables_processing { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 16px 32px; border-radius: 8px; font-size: 14px; z-index: 100; }
        .dataTables_wrapper { position: relative; }
        .dataTables_filter, .dataTables_length { display: none; }
    </style>
</head>
<body>
@include('layouts.partials.sidebar')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.getElementById('mainContent');
    const pageContent = document.querySelector('.page-content');
    const navbar = document.querySelector('header.topbar');
    if (mainContent && pageContent && navbar) {
        mainContent.insertBefore(navbar, pageContent);
    }
});
</script>
<div class="page-content">
    <div class="container-fluid px-4">
        <div class="page-header">
            <h1 class="page-title">Hubungi Kami</h1>
            <p class="page-subtitle">Kelola pesan dari pengunjung website.</p>
        </div>
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-envelope" aria-hidden="true"></i></div>
                        <div>
                            <div class="stat-label">Total Pesan</div>
                            <div class="stat-number">{{ $totalPesan }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-envelope-exclamation" aria-hidden="true"></i></div>
                        <div>
                            <div class="stat-label">Belum Dibaca</div>
                            <div class="stat-number">{{ $belumDibaca }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-reply" aria-hidden="true"></i></div>
                        <div>
                            <div class="stat-label">Sudah Dibalas</div>
                            <div class="stat-number">{{ $sudahDibalas }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-card">
            <div class="table-header">
                <div>
                    <h2 class="table-title">Daftar Pesan</h2>
                    <p class="table-subtitle">Pesan yang dikirim melalui halaman Hubungi Kami.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle" id="contacts-table">
                    <caption class="visually-hidden">Daftar pesan dari pengunjung</caption>
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Pengunjung</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subjek</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="field-group">
                    <div class="field-label">Nama Pengunjung</div>
                    <div class="field-value" id="modalNama">-</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Email</div>
                    <div class="field-value" id="modalEmail">-</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Subjek</div>
                    <div class="field-value" id="modalSubjek">-</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Status</div>
                    <div class="field-value status" id="modalStatus">-</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Tanggal Pesan</div>
                    <div class="field-value" id="modalTanggal">-</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Pesan</div>
                    <div class="field-value" id="modalPesan" style="white-space: pre-wrap; word-break: break-word;">-</div>
                </div>
                <div id="balasanSection" style="display: none;" class="field-group">
                    <div class="field-label">Balasan</div>
                    <div class="field-value" id="modalBalasan" style="white-space: pre-wrap; word-break: break-word;"></div>
                </div>
                <div id="dibalasSection" style="display: none;" class="field-group">
                    <div class="field-label">Dibalas pada</div>
                    <div class="field-value" id="modalDibalasNya">-</div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-danger btn-sm" id="btnHapusModal"><i class="bi bi-trash me-1"></i>Hapus Pesan</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnBalasModal"><i class="bi bi-reply me-1"></i>Balas Pesan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Balas Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="replyForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="email" class="form-control" id="replyTo" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Balasan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="replyText" rows="6" placeholder="Ketik balasan Anda di sini..." maxlength="5000"></textarea>
                        <small class="text-muted d-block mt-1"><span id="charCount">0</span>/5000</small>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="btnKirimBalasan"><i class="bi bi-send me-1"></i>Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var CSRF_TOKEN = '{{ csrf_token() }}';
var currentContactId = null;
$(document).ready(function() {
    $('#contacts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: '{{ route("contacts.data") }}', type: 'GET' },
        columns: [
            { data: null, orderable: false, searchable: false, className: 'px-3', width: '50px', render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
            { data: 'nama', orderable: true, searchable: true, render: function(data) { return '<div class="visitor-name">' + escapeHtml(data) + '</div>'; } },
            { data: 'email', orderable: true, searchable: true, render: function(data) { return '<div class="visitor-email">' + escapeHtml(data) + '</div>'; } },
            { data: 'subjek', orderable: true, searchable: true, render: function(data) { return '<div class="subject-col">' + escapeHtml(data) + '</div>'; } },
            { data: 'status', orderable: true, searchable: true, render: function(data) { var c=''; if(data==='Belum Dibaca')c='status-belum'; else if(data==='Dibaca')c='status-dibaca'; else if(data==='Dibalas')c='status-dibalas'; return '<span class="status '+c+'">'+escapeHtml(data)+'</span>'; } },
            { data: 'created_at', orderable: true, searchable: false, render: function(data) { var d=new Date(data); return d.toLocaleDateString('id-ID',{year:'numeric',month:'short',day:'numeric'}); } },
            { data: 'id', orderable: false, searchable: false, className: 'text-center', width: '100px', render: function(data,type,row) { return '<div class="d-flex justify-content-center gap-2"><button type="button" class="action-btn" title="Lihat Detail" onclick="viewContact('+data+')"><i class="bi bi-eye text-primary"></i></button><button type="button" class="action-btn action-btn-danger" title="Hapus" onclick="deleteContact('+data+',\''+escapeHtml(row.nama).replace(/'/g,"\\'")+'\')"><i class="bi bi-trash"></i></button></div>'; } }
        ],
        order: [[5,'desc']],
        language: { processing:'Memproses...', search:'Cari:', lengthMenu:'Tampilkan _MENU_ data', info:'Menampilkan _START_ sampai _END_ dari _TOTAL_ data', infoEmpty:'Tidak ada data', infoFiltered:'(difilter dari _MAX_ total data)', loadingRecords:'Memuat...', zeroRecords:'Tidak ditemukan data yang cocok', emptyTable:'Belum ada pesan masuk', paginate:{first:'«',last:'»',next:'›',previous:'‹'}, aria:{sortAscending:': aktifkan untuk urut naik', sortDescending:': aktifkan untuk urut turun'} }
    });
});
function viewContact(id) {
    $.ajax({ url:'/admin/contacts/'+id+'/detail', type:'GET', dataType:'json', success:function(contact) {
        currentContactId=contact.id;
        $('#modalNama').text(contact.nama); $('#modalEmail').text(contact.email); $('#modalSubjek').text(contact.subjek); $('#modalPesan').text(contact.pesan);
        var c=''; if(contact.status==='Belum Dibaca')c='status-belum'; else if(contact.status==='Dibaca')c='status-dibaca'; else if(contact.status==='Dibalas')c='status-dibalas';
        $('#modalStatus').text(contact.status).attr('class','field-value status '+c);
        var d=new Date(contact.created_at); $('#modalTanggal').text(d.toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit'}));
        if(contact.balasan){ $('#balasanSection').show(); $('#modalBalasan').text(contact.balasan); }else{ $('#balasanSection').hide(); }
        if(contact.dibalas_pada){ $('#dibalasSection').show(); var rd=new Date(contact.dibalas_pada); $('#modalDibalasNya').text(rd.toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit'})); }else{ $('#dibalasSection').hide(); }
        $('#replyTo').val(contact.email); markAsRead(id);
        var modal=new bootstrap.Modal(document.getElementById('detailModal')); modal.show();
    }, error:function(){ Swal.fire({icon:'error',title:'Gagal',text:'Tidak dapat memuat detail pesan.',timer:1800,showConfirmButton:false}); } });
}
function markAsRead(id) { $.ajax({ url:'{{ route("contacts.read","__ID__") }}'.replace('__ID__',id), type:'PATCH', headers:{'X-CSRF-TOKEN':CSRF_TOKEN}, success:function(){ var t=$('#contacts-table').DataTable(); t.ajax.reload(null,false); } }); }
function deleteContact(id,nama) {
    Swal.fire({title:'Konfirmasi',text:'Apakah Anda yakin ingin menghapus pesan dari "'+nama.substring(0,30)+'"?',icon:'warning',showCancelButton:true,confirmButtonText:'Ya, hapus',cancelButtonText:'Batal'}).then(function(r){
        if(!r.isConfirmed)return; $.ajax({ url:'{{ route("contacts.destroy","__ID__") }}'.replace('__ID__',id), type:'DELETE', headers:{'X-CSRF-TOKEN':CSRF_TOKEN}, success:function(res){ Swal.fire({icon:'success',title:'Berhasil',text:res.message||'Pesan berhasil dihapus.',timer:1800,showConfirmButton:false}); var t=$('#contacts-table').DataTable(); t.ajax.reload(); }, error:function(res){ var e='Gagal menghapus pesan.'; if(res.responseJSON&&res.responseJSON.message)e=res.responseJSON.message; Swal.fire({icon:'error',title:'Gagal',text:e,timer:1800,showConfirmButton:false}); } });
    });
}
$('#btnBalasModal').click(function(){ var m=bootstrap.Modal.getInstance(document.getElementById('detailModal')); m.hide(); var n=new bootstrap.Modal(document.getElementById('replyModal')); n.show(); });
$('#btnHapusModal').click(function(){ var m=bootstrap.Modal.getInstance(document.getElementById('detailModal')); m.hide(); deleteContact(currentContactId,$('#modalNama').text()); });
$('#replyText').on('input',function(){ var l=$(this).val().length; $('#charCount').text(l); });
$('#replyForm').on('submit',function(e){ e.preventDefault(); var b=$('#replyText').val().trim(); if(!b){ Swal.fire({icon:'warning',title:'Validasi',text:'Balasan tidak boleh kosong.',timer:1800,showConfirmButton:false}); return; }
    $.ajax({ url:'{{ route("contacts.reply","__ID__") }}'.replace('__ID__',currentContactId), type:'POST', headers:{'X-CSRF-TOKEN':CSRF_TOKEN}, data:{balasan:b}, success:function(res){ Swal.fire({icon:'success',title:'Berhasil',text:res.message||'Balasan berhasil dikirim.',timer:1800,showConfirmButton:false}); var m=bootstrap.Modal.getInstance(document.getElementById('replyModal')); m.hide(); $('#replyForm')[0].reset(); $('#charCount').text('0'); var t=$('#contacts-table').DataTable(); t.ajax.reload(); }, error:function(res){ var e='Gagal mengirim balasan.'; if(res.responseJSON&&res.responseJSON.message)e=res.responseJSON.message; Swal.fire({icon:'error',title:'Gagal',text:e,timer:1800,showConfirmButton:false}); } });
});
function escapeHtml(t){ var m={'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}; return String(t).replace(/[&<>"']/g,function(s){return m[s];}); }
</script>
</body>
</html>