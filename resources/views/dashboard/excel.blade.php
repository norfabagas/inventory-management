@extends('layouts.dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item active">
  Excel
</li>
@endsection

@section('content')
<div class="card mb3">
  <div class="card-header">
    Export to Excel
  </div>

  <div class="card-body">

    <form id="exportForm">
      <div clas="form-group">
        <label>From</label>
        <input type="date" class="form-control" date-date-format="Y-m-d" id="fromForm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
      </div>

      <div class="form-group">
        <label>To</label>
        <input type="date" class="form-control" id="toForm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
      </div>

      <div class="form-group">
        <label>Data to Export</label>
        <select id="dataForm" class="form-control">
          <option value="">Select</option>
          <option value="stock">Stok</option>
          <option value="stuff">Barang Masuk</option>
          <option value="drop">Barang Keluar</option>
        </select>
      </div>

      <div class="form-group">
        <label>Export Format</label>
        <select id="formatForm" class="form-control">
          <option value="">Select</option>
          <option value="csv">CSV</option>
          <option value="xls">XLS</option>
          <option value="xlsx">XLSX</option>
        </select>
      </div>

      <br/>
      <input type="submit" class="btn btn-info" value="Export">
    </form>

  </div>

  <div class="card-footer">

  </div>
</div>
@endsection

@section('script')
<script>
  $(document).ready(function () {

    $('#exportForm').on('submit', function () {
      event.preventDefault();
      var from = $('#fromForm').val();
      var to = $('#toForm').val();
      var data = $('#dataForm').val();
      var format = $('#formatForm').val();
      if (from >= to) {
        toastr.warning('\'From\' date input must be less or 1 day earlier than \'To\' date input');
      } else if (data == '') {
        toastr.warning('Data type is required');
      } else if (format == '') {
        toastr.warning('Export Format is required')
      } else {
        switch (data) {
          case 'stock':
            toastr.success('stock');
            $(location).attr("href", "{{ url('dashboard/excel/stock/') }}/" + from + "/" + to + "/" + format);
            break;
          case 'stuff':
            toastr.success('export data for stuff created');
            $(location).attr("href", "{{ url('dashboard/excel/stuff/') }}/" + from + "/" + to + "/" + format);
            break;
          case 'drop':
            toastr.success('drop');
            $(location).attr("href", "{{ url('dashboard/excel/drop/') }}/" + from + "/" + to + "/" + format);
            break;
          default:
            toastr.warning('data not valid');

        }

      }

    });

  });
</script>
@endsection
