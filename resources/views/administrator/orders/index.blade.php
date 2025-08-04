@extends('administrator.layout.app')

@section('title', 'Daftar Pesanan')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Pesanan</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped dt-responsive nowrap" width="100%" id="orders-table">
                <thead>
                    <tr>
                        <th>No.</th> {{-- <-- PERUBAHAN DI SINI --}}
                        <th>Pelanggan</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script>
        $(function() {
            $('#orders-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('orders.index') }}',
                columns: [
                    // --- AWAL PERUBAHAN DI SINI ---
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'customer_name',
                        name: 'user.name'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                // Urutkan berdasarkan kolom ke-5 (Tanggal Pesan), dari terbaru (desc)
                order: [
                    [4, 'desc']
                ]
                // --- AKHIR PERUBAHAN DI SINI ---
            });
        });
    </script>
@endsection
