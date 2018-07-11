@extends('layouts.dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item active">Stuff</li>
@endsection

@section('content')
<div class="card mb3">

  <div class="card-header">
    Stuff
    <button id="addButton" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#addModal">
      <i class="fa fa-plus"></i>
    </button>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <div class="col-12">
        <table class="table display" id="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Category</th>
              <th>Location</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <div class="card-footer">

  </div>

</div>

<!-- add modal -->
<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        Add Stuff
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="addForm">

          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="addFormName">
            <span class="invalid-feedback add-name"></span>
          </div>

          <div class="form-group">
            <label>Category</label>
            <select id="addFormCategory" class="form-control">
              <option value="">Select Category</option>
              @foreach($category as $a)
              <option value="{{ $a->id }}">{{ $a->name }}</option>
              @endforeach
            </select>
            <span class="invalid-feedback add-category"></span>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <textarea id="addFormCondition" class="form-control"></textarea>
            <span class="invalid-feedback add-condition"></span>
          </div>

          <div class="form-group">
            <label>Location</label>
            <textarea id="addFormLocation" class="form-control"></textarea>
            <span class="invalid-feedback add-location"></span>
          </div>

          <div class="form-group">
            <label>Size</label>
            <input type="text" class="form-control" id="addFormSize">
            <span class="invalid-feedback add-size"></span>
          </div>

          <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" id="addFormQuantity">
            <span class="invalid-feedback add-quantity"></span>
          </div>

          <br/>
          <input type="submit" value="Save" class="btn btn-info">

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>

<!-- show modal -->
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        Stuff Detail
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table">
          <tr>
            <td>Name</td>
            <td><span id="viewName"></span></td>
          </tr>

          <tr>
            <td>Category</td>
            <td><span id="viewCategory"></span></td>
          </tr>

          <tr>
            <td>Condition</td>
            <td><span id="viewCondition"></span></td>
          </tr>

          <tr>
            <td>Location</td>
            <td><span id="viewLocation"></span></td>
          </tr>

          <tr>
            <td>Size</td>
            <td><span id="viewSize"></span></td>
          </tr>

          <tr>
            <td>Quantity</td>
            <td><span id="viewQuantity"></span></td>
          </tr>
        </table>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>
@endsection

@section('script')
<script>
  $(document).ready(function () {

    $('#table').DataTable({
      serverSide: true,
      processing: true,
      ajax: "{{ route('stuff') }}",
      columns: [
        { data: 'Name', name: 'Name' },
        { data: 'Category', name: 'Category' },
        { data: 'Location', name: 'Location' },
        { data: 'Quantity', name: 'Quantity' },
        { data: 'action', name: 'action', searchable: false },
      ]
    });

    $('#addButton').on('click', function () {
      $('#addForm').trigger('reset');

      $('#addFormName').removeClass('is-invalid');
      $('#addFormCategory').removeClass('is-invalid');
      $('#addFormCondition').removeClass('is-invalid');
      $('#addFormLocation').removeClass('is-invalid');
      $('#addFormSize').removeClass('is-invalid');
      $('#addFormQuantity').removeClass('is-invalid');

      $('.invalid-feedback.add-name').empty();
      $('.invalid-feedback.add-category').empty();
      $('.invalid-feedback.add-condition').empty();
      $('.invalid-feedback.add-location').empty();
      $('.invalid-feedback.add-size').empty();
      $('.invalid-feedback.add-quantity').empty();
    });

    $('#addForm').on('submit', function () {
      event.preventDefault();

      $.ajax({
        url: "{{ url('dashboard/stuff-json') }}",
        dataType: 'JSON',
        type: 'POST',
        data: {
          method: '_STORE',
          name: $('#addFormName').val(),
          category: $('#addFormCategory').val(),
          condition: $('#addFormCondition').val(),
          location: $('#addFormLocation').val(),
          size: $('#addFormSize').val(),
          quantity: $('#addFormQuantity').val(),
        },
        success: function (data) {
          if (data.errors) {

            if (data.errors.name) {
              $('#addFormName').addClass('is-invalid');
              $('.invalid-feedback.add-name').text(data.errors.name);
            } else {
              $('#addFormName').removeClass('is-invalid');
              $('.invalid-feedback.add-name').empty();
            }

            if (data.errors.category) {
              $('#addFormCategory').addClass('is-invalid');
              $('.invalid-feedback.add-category').text(data.errors.category);
            } else {
              $('#addFormCategory').removeClass('is-invalid');
              $('.invalid-feedback.add-category').empty();
            }

            if (data.errors.condition) {
              $('#addFormCondition').addClass('is-invalid');
              $('.invalid-feedback.add-condition').text(data.errors.condition);
            } else {
              $('#addFormCondition').removeClass('is-invalid');
              $('.invalid-feedback.add-condition').empty();
            }

            if (data.errors.location) {
              $('#addFormLocation').addClass('is-invalid');
              $('.invalid-feedback.add-location').text(data.errors.location);
            } else {
              $('#addFormLocation').removeClass('is-invalid');
              $('.invalid-feedback.add-location').empty();
            }

            // if (data.errors.size) {
            //   $('#addFormSize').addClass('is-invalid');
            //   $('.invalid-feedback.add-size').text(data.errors.size);
            // } else {
            //   $('#addFormSize').addClass('is-invalid');
            //   $('.invalid-feedback.add-size').empty();
            // }

            if (data.errors.quantity) {
              $('#addFormQuantity').addClass('is-invalid');
              $('.invalid-feedback.add-quantity').text(data.errors.quantity);
            } else {
              $('#addFormQuantity').removeClass('is-invalid');
              $('.invalid-feedback.add-quantity').empty();
            }

          } else {
            toastr.success(data.msg.name+ ' Added');
            $('#addModal').modal('hide');
            $('#table').DataTable().draw(false);
          }
        }
      })

    });

    $('#table').on('click', '.show[data-id]', function () {
      var id = $(this).data('id');

      $.ajax({
        url: "{{ url('dashboard/stuff-json') }}/" + id,
        type: 'GET',
        dataType: 'JSON',
        data: {
          method: '_SHOW',
        },
        success: function (data) {
          $('#showModal').modal('toggle');
          $('#viewName').text(data.msg.name);
          $('#viewCategory').text(data.category);
          $('#viewCondition').text(data.msg.condition);
          $('#viewLocation').text(data.msg.location);
          $('#viewSize').text(data.msg.size);
          $('#viewQuantity').text(data.msg.quantity);
        }
      })
    });

  });
</script>
@endsection
