@extends('layouts.main')

@section('main')

    <p class="text-center"> HALAMAN KELOLA PEGAWAI</p>

    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th></th>
                <th>ID Transaksi</th>
                <th>Nama Kasir</th>
                <th>Daftar Barang</th>
                <th>Daftar Harga</th>
                <th>Daftar Jumlah</th>
                <th>Total Harga</th>
                <th>Uang Pembeli</th>
                <th>Nilai Kembalian</th>
                <th>Tanggal Dibuat</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr class="ini">
                <th></th>
                <th>ID Transaksi</th>
                <th>Nama Kasir</th>
                <th>Daftar Barang</th>
                <th>Daftar Harga</th>
                <th>Daftar Jumlah</th>
                <th>Total Harga</th>
                <th>Uang Pembeli</th>
                <th>Nilai Kembalian</th>
                <th>Tanggal Dibuat</th>
            </tr>
            </tfoot>
        </table>
    </div>

    @push('scripts')
        <script>
            function format(d) {
                return (
                    'Full name: ' +
                    d.first_name +
                    ' ' +
                    d.last_name +
                    '<br>' +
                    'Salary: ' +
                    d.salary +
                    '<br>' +
                    'The child row can contain any data you wish, including links, images, inner tables etc.'
                );
            }

            $(document).ready(function () {
                var dt = $('#example').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {{asset('dataTables/test.json')}},
                    columns: [
                        {
                            class: 'details-control',
                            orderable: false,
                            data: null,
                            defaultContent: '',
                        },
                        { data: 'first_name' },
                        { data: 'last_name' },
                        { data: 'position' },
                        { data: 'office' },
                    ],
                    order: [[1, 'asc']],
                });

                // Array to track the ids of the details displayed rows
                var detailRows = [];

                $('#example tbody').on('click', 'tr td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = dt.row(tr);
                    var idx = detailRows.indexOf(tr.attr('id'));

                    if (row.child.isShown()) {
                        tr.removeClass('details');
                        row.child.hide();

                        // Remove from the 'open' array
                        detailRows.splice(idx, 1);
                    } else {
                        tr.addClass('details');
                        row.child(format(row.data())).show();

                        // Add to the 'open' array
                        if (idx === -1) {
                            detailRows.push(tr.attr('id'));
                        }
                    }
                });

                // On each draw, loop over the `detailRows` array and show any child rows
                dt.on('draw', function () {
                    detailRows.forEach(function(id, i) {
                        $('#' + id + ' td.details-control').trigger('click');
                    });
                });
            });
        </script>

        <style>
            td.details-control {
                background: url({{ asset('images/svg/plus-circle-fill.svg') }}) no-repeat center center;
                cursor: pointer;
            }

            tr.details td.details-control {
                background: url({{ asset('images/svg/dash-circle-fill.svg') }}) no-repeat center center;
            }
        </style>
    @endpush

@endsection


