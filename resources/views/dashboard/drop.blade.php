@extends('layouts.dashboard')

@section('breadcrumb')
<li class="breadcrumb-item">
  <a href="{{ url('dashboard/stuff') }}">Stuff</a>
</li>
<li class="breadcrumb-item active">
  Drop
</li>
@endsection

@section('content')
<div class="card mb3">
  <div class="card-header">
    Drop
    <button class="btn btn-info" id="addButton" style="float: right" data-toggle="modal" data-target="#addModal">
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
              <th>Detail</th>
              <th>Quantity</th>
              <th>Person In Charge</th>
              <th>Create Date</th>
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
        Add Drop
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="addForm">
          <div class="form-group">
            <label>Stuff</label>
            <select id="addFormStuff" class="form-control">
              <option value="" selected>Select Stuff</option>
              @foreach($stuff as $a)
              <option value="{{ $a->id }}">{{ $a->name }}</option>
              @endforeach
            </select>
            <span class="invalid-feedback add-stuff"></span>
          </div>

          <div class="form-group">
            <label>Person In Charge</label>
            <input type="text" id="addFormPerson" class="form-control">
            <span class="invalid-feedback add-person"></span>
          </div>

          <div class="form-group">
            <label>Detail</label>
            <textarea id="addFormDetail" class="form-control"></textarea>
            <span class="invalid-feedback add-detail"></span>
          </div>

          <div class="form-group">
            <label>Quantity</label>
            <input  type="number" class="form-control" id="addFormQuantity">
            <span class="invalid-feedback add-quantity"></span>
          </div>

          <br/>
          <input type="submit" class="btn btn-info" value="Save">


        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>

<!-- edit modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        Edit Drop
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="editForm">

          <input type="hidden" id="editFormId">

          <div class="form-group">
            <label>Person In Charge</label>
            <input type="text" id="editFormPerson" class="form-control">
            <span class="invalid-feedback edit-person"></span>
          </div>

          <div class="form-group">
            <label>Detail</label>
            <textarea id="editFormDetail" class="form-control"></textarea>
            <span class="invalid-feedback edit-detail"></span>
          </div>

          <div class="form-group">
            <label>Quantity</label>
            <input  type="number" class="form-control" id="editFormQuantity">
            <span class="invalid-feedback edit-quantity"></span>
          </div>

          <br/>
          <input type="submit" class="btn btn-info" value="Update">


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
        Drop Details
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table">
          <tr>
            <td>Stuff Name</td>
            <td>
              <span id="showStuffName"></span>
            </td>
          </tr>

          <tr>
            <td>Stuff Quantity</td>
            <td>
              <span id="showStuffQuantity"></span>
            </td>
          </tr>

          <tr>
            <td>Drop Detail</td>
            <td>
              <span id="showDropDetail"></span>
            </td>
          </tr>

          <tr>
            <td>Drop Quantity</td>
            <td>
              <span id="showDropQuantity"></span>
            </td>
          </tr>

          <tr>
            <td>Created at</td>
            <td>
              <span id="showDropCreatedAt"></span>
            </td>
          </tr>

          <tr>
            <td>Updated At</td>
            <td>
              <span id="showDropUpdatedAt"></span>
            </td>
          </tr>

          <tr>
            <td>Person in Charge</td>
            <td>
              <span id="showPersonName"></span>
            </td>
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
    processing: true,
    serverSide: true,
    ajax: "{{ route('drop') }}",
    columns: [
      { data: 'stuff_name', name: 'stuff_name' },
      { data: 'detail', name: 'detail' },
      { data: 'quantity', name: 'quantity' },
      { data: 'person', name: 'person' },
      { data: 'created_at', name: 'created_at' },
      { data: 'action', name: 'action' },
    ]
  });

  $('#addButton').on('click', function () {
    $('#addForm').trigger('reset');

    $('#addFormStuff').removeClass('is-invalid');
    $('#addFormPerson').removeClass('is-invalid');
    $('#addFormDetail').removeClass('is-invalid');
    $('#addFormQuantity').removeClass('is-invalid');

    $('.invalid-feedback.add-stuff').empty();
    $('.invalid-feedback.add-person').empty();
    $('.invalid-feedback.add-detail').empty();
    $('.invalid-feedback.add-quantity').empty();
  });

  $('#addForm').on('submit', function () {
    event.preventDefault();
    $.ajax({
      url: "{{ url('dashboard/stuff/drop-json') }}",
      dataType: 'JSON',
      type: 'POST',
      data: {
        method: '_STORE',
        stuff: $('#addFormStuff').val(),
        person: $('#addFormPerson').val(),
        detail: $('#addFormDetail').val(),
        quantity: $('#addFormQuantity').val(),
      },
      success: function (data) {
        if (data.errors) {
          console.log(data.errors);

          if (data.errors.stuff) {
            $('#addFormStuff').addClass('is-invalid');
            $('.invalid-feedback.add-stuff').text(data.errors.stuff);
          } else {
            $('#addFormStuff').removeClass('is-invalid');
            $('.invalid-feedback.add-stuff').empty();
          }

          if (data.errors.person) {
            $('#addFormPerson').addClass('is-invalid');
            $('.invalid-feedback.add-person').text(data.errors.person);
          } else {
            $('#addFormPerson').removeClass('is-invalid');
            $('.invalid-feedback.add-person').empty();
          }

          if (data.errors.detail) {
            $('#addFormDetail').addClass('is-invalid');
            $('.invalid-feedback.add-detail').text(data.errors.detail);
          } else {
            $('#addFormDetail').removeClass('is-invalid');
            $('.invalid-feedback.add-detail').empty();
          }

          if (data.errors.quantity) {
            $('#addFormQuantity').addClass('is-invalid');
            $('.invalid-feedback.add-quantity').text(data.errors.quantity);
          } else {
            $('#addFormQuantity').removeClass('is-invalid');
            $('.invalid-feedback.add-quantity').empty();
          }

        } else {
          toastr.success('New Drop Added');
          $('#addModal').modal('hide');
          $('#table').DataTable().draw(false);
        }
      }
    });

  });

  $('#table').on('click', '.show[data-id]', function () {
    var id = $(this).data('id');
    $('#showModal').modal('toggle');
    $.ajax({
      url: "{{ url('dashboard/stuff/drop-json') }}/" + id,
      dataType: 'JSON',
      type: 'GET',
      data: {
        method: '_SHOW',
      },
      success: function (data) {
        $('#showStuffName').text(data.stuff.name);
        $('#showStuffQuantity').text(data.stuff.quantity);
        $('#showDropDetail').text(data.drop.detail);
        $('#showDropQuantity').text(data.drop.quantity);
        $('#showDropCreatedAt').text(data.drop.created_at);
        $('#showDropUpdatedAt').text(data.drop.updated_at);
        // $('#showPersonName').text(data.person.name);
        $('#showPersonName').text(data.drop.person);
      }
    })
  });

  $('#table').on('click', '.edit[data-id]', function () {
    $('#editForm').trigger('reset');
    var id = $(this).data('id');

    $.ajax({
      url: "{{ url('dashboard/stuff/drop-json') }}/" + id + "/edit",
      dataType: 'JSON',
      type: 'GET',
      data: {
        method: '_EDIT',
      },
      success: function (data) {
        $('#editModal').modal('toggle');

        $('#editFormDetail').val(data.msg.detail);
        $('#editFormQuantity').val(data.msg.quantity);
        $('#editFormPerson').val(data.msg.person);

        $('#editFormDetail').removeClass('is-invalid');
        $('#editFormQuantity').removeClass('is-invalid');
        $('#editFormPerson').removeClass('is-invalid');

        $('.invalid-feedback.edit-detail').empty();
        $('.invalid-feedback.edit-quantity').empty();
        $('.invalid-feedback.edit-person').empty();

        $('#editFormId').val(id);
      }
    });
  });

  $('#editForm').on('submit', function () {
    event.preventDefault();

    var id = $('#editFormId').val();
    $.ajax({
      url: "{{ url('dashboard/stuff/drop-json') }}/" + id,
      type: 'PUT',
      dataType: 'JSON',
      data: {
        method: '_UPDATE',
        person: $('#editFormPerson').val(),
        quantity: $('#editFormQuantity').val(),
        detail: $('#editFormDetail').val(),
      },
      success: function (data) {

        if (data.errors) {

          if (data.errors.person) {
            $('#editFormPerson').addClass('is-invalid');
            $('.invalid-feedback.edit-person').text(data.errors.person);
          } else {
            $('#editFormPerson').removeClass('is-invalid');
            $('.invalid-feedback.edit-person').empty();
          }

          if (data.errors.detail) {
            $('#editFormDetail').addClass('is-invalid');
            $('.invalid-feedback.edit-detail').text(data.errors.detail);
          } else {
            $('#editFormDetail').removeClass('is-invalid');
            $('.invalid-feedback.edit-detail').empty();
          }

          if (data.errors.quantity) {
            $('#editFormQuantity').addClass('is-invalid');
            $('.invalid-feedback.edit-quantity').text(data.errors.quantity);
          } else {
            $('#editFormQuantity').removeClass('is-invalid');
            $('.invalid-feedback.edit-quantity').empty();
          }

        } else {
          toastr.success('Drop updated');
          $('#editModal').modal('hide');
          $('#table').DataTable().draw(false);
        }
      }
    })
  });

  $('#table').on('click', '.delete[data-id]', function () {
    var id = $(this).data('id');

    bootbox.dialog({
      message: "Are you sure to delete?",
      buttons: {
        no: {
          label: 'No',
          className: 'btn-danger',
          callback: function () {

          }
        },
        yes: {
          label: 'Yes',
          className: 'btn-success',
          callback: function () {
            console.log(id);
            $.ajax({
              url: "{{ url('dashboard/stuff/drop-json') }}/" + id,
              type: 'DELETE',
              dataType: 'JSON',
              data: {
                method: '_DESTROY',
              },
              success: function (data) {
                toastr.warning('Drop deleted');
                $('#table').DataTable().draw(false);
              }
            })
          }
        }
      }
    });

  });

});
</script>
@endsection
