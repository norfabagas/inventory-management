@extends('layouts.dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item active">
  User
</li>
@endsection

@section('content')
<div class="card mb3">
  <div class="card-header">
    User Management
    <button id="addButton" class="btn btn-info" style="float: right" data-toggle="modal" data-target="#addModal">
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
              <th>Email</th>
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
        Add new User
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="addForm">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="addFormName">
            <span class="invalid-feedback add-name"></span>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" id="addFormEmail">
            <span class="invalid-feedback add-email"></span>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="addFormPassword">
            <span class="invalid-feedback add-password"></span>
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

<!-- edit mdoal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        Edit User
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="editForm">
          <input type="hidden" id="editFormId">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="editFormName">
            <span class="invalid-feedback edit-name"></span>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="editFormPassword" placeholder="Leave blank to keep user's password unchanged">
            <span class="invalid-feedback edit-password"></span>
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

@endsection

@section('script')
<script>

$(document).ready(function () {

  $('#table').DataTable({
    serverSide: true,
    processing: true,
    ajax: "{{ route('user') }}",
    columns: [
      { data: 'name', name: 'name' },
      { data: 'email', name: 'email' },
      { data: 'action', name: 'action' },
    ]
  });

  $('#addButton').on('click', function () {
    $('#addForm').trigger('reset');

    $('#addFormName').removeClass('is-invalid');
    $('#addFormEmail').removeClass('is-invalid');
    $('#addFormPassword').removeClass('is-invalid');

    $('.invalid-feedback.add-name').empty();
    $('.invalid-feedback.add-email').empty();
    $('.invalid-feedback.add-password').empty();
  });

  $('#addForm').on('submit', function () {

    event.preventDefault();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: "{{ url('dashboard/user-json') }}",
      data: {
        method: '_STORE',
        name: $('#addFormName').val(),
        email: $('#addFormEmail').val(),
        password: $('#addFormPassword').val(),
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

          if (data.errors.email) {
            $('#addFormEmail').addClass('is-invalid');
            $('.invalid-feedback.add-email').text(data.errors.email);
          } else {
            $('#addFormEmail').removeClass('is-invalid');
            $('.invalid-feedback.add-email').empty();
          }

          if (data.errors.password) {
            $('#addFormPassword').addClass('is-invalid');
            $('.invalid-feedback.add-password').text(data.errors.password);
          } else {
            $('#addFormPassword').removeClass('is-invalid');
            $('.invalid-feedback.add-password').empty();
          }
        } else {
          toastr.success('User ' + data.msg.email + ' created');
          $('#addModal').modal('hide');
          $('#table').DataTable().draw(false);
        }
      }

    })

  });

  $('#table').on('click', '.edit[data-id]', function () {
    var id = $(this).data('id');
    $.ajax({
      url: "{{ url('dashboard/user-json') }}/" + id + "/edit",
      dataType: 'JSON',
      type: 'GET',
      data: {
        method: '_EDIT',
      },
      success: function (data) {
        $('#editModal').modal('toggle');
        $('#editFormName').val(data.msg.name);

        $('#editFormName').removeClass('is-invalid');
        $('#editFormPassword').removeClass('is-invalid');
        $('.invalid-feedback.edit-name').empty();
        $('.invalid-feedback.edit-password').empty();

        $('#editFormId').val(id);
      }
    })
  });

  $('#editForm').on('submit', function () {
    var id = $('#editFormId').val();
    event.preventDefault();
    $.ajax({
      url: "{{ url('dashboard/user-json') }}/" + id,
      dataType: 'JSON',
      type: 'PUT',
      data: {
        method: '_UPDATE',
        name: $('#editFormName').val(),
        password: $('#editFormPassword').val(),
      },
      success: function (data) {
        if (data.errors) {

          if (data.errors.name) {
            $('#editFormName').addClass('is-invalid');
            $('.invalid-feedback.edit-name').text(data.errors.name);
          } else {
            $('#editFormName').removeClass('is-invalid');
            $('.invalid-feedback.edit-name').empty();
          }

          if (data.errors.password) {
            $('#editFormPassword').addClass('is-invalid');
            $('.invalid-feedback.edit-password').text(data.errors.password);
          } else {
            $('#editFormPassword').removeClass('is-invalid');
            $('.invalid-feedback.edit-password').empty();
          }

        } else {
          toastr.success('Data for ' + data.msg.email + ' updated');
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
              url: "{{ url('dashboard/user-json') }}/" + id,
              type: 'DELETE',
              dataType: 'JSON',
              data: {
                method: '_DESTROY',
              },
              success: function (data) {
                toastr.warning('User ' + data.msg.email + ' deleted');
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
