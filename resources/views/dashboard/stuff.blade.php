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
            <label>Detail</label>
            <textarea id="addFormDetail" class="form-control"></textarea>
            <span class="invalid-feedback add-detail"></span>
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
            <td>Detail</td>
            <td><span id="viewDetail"></span></td>
          </tr>

          <tr>
            <td>Quantity</td>
            <td><span id="viewQuantity"></span></td>
          </tr>

          <tr>
            <td>Create Date</td>
            <td><span id="viewCreatedAt"></span></td>
          </tr>

          <tr>
            <td>Update Date</td>
            <td><span id="viewUpdatedAt"></span></td>
          </tr>
        </table>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>

<!-- edit  modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        Edit Stuff
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="editForm">

          <input type="hidden" value="" id="editFormId">

          <div class="form-group">
            <label>Name</label>
            <input type="text" id="editFormName" class="form-control">
            <span class="invalid-feedback edit-name"></span>
          </div>

          <div class="form-group">
            <label>Category</label>
            <select id="editFormCategory" class="form-control">
              <option value="" selected>Select Category</option>
              @foreach($category as $a)
              <option value="{{ $a->id }}">{{ $a->name }}</option>
              @endforeach
            </select>
            <span class="invalid-feedback edit-category"></span>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <textarea id="editFormCondition" class="form-control"></textarea>
            <span class="invalid-feedback edit-condition"></span>
          </div>

          <div class="form-group">
            <label>Location</label>
            <textarea id="editFormLocation" class="form-control"></textarea>
            <span class="invalid-feedback edit-location"></span>
          </div>

          <div class="form-group">
            <label>Size</label>
            <input type="text" class="form-control" id="editFormSize">
            <span class="invalid-feedback edit-size"></span>
          </div>

          <div class="form-group">
            <label>Detail</label>
            <textarea id="editFormDetail" class="form-control"></textarea>
            <span class="invalid-feedback edit-detail"></span>
          </div>

          <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" id="editFormQuantity">
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
        { data: 'created_at', name: 'Create Date' },
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
      $('#addFormDetail').removeClass('is-invalid');
      $('#addFormQuantity').removeClass('is-invalid');

      $('.invalid-feedback.add-name').empty();
      $('.invalid-feedback.add-category').empty();
      $('.invalid-feedback.add-condition').empty();
      $('.invalid-feedback.add-location').empty();
      $('.invalid-feedback.add-size').empty();
      $('.invalid-feedback.add-detail').empty();
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
          detail: $('#addFormDetail').val(),
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
          $('#viewDetail').text(data.msg.detail);
          $('#viewQuantity').text(data.msg.quantity);
          $('#viewCreatedAt').text(data.msg.created_at);
          $('#viewUpdatedAt').text(data.msg.updated_at);
        }
      })
    });

    $('#table').on('click', '.edit[data-id]', function () {
      $('#editModal').modal('toggle');
      var id = $(this).data('id');
      $('#editFormId').val(id);
      $('#editForm').trigger('reset');

      $('#editFormName').removeClass('is-invalid');
      $('#editFormCondition').removeClass('is-invalid');
      $('#editFormLocation').removeClass('is-invalid');
      $('#editFormSize').removeClass('is-invalid');
      $('#editFormQuantity').removeClass('is-invalid');
      // $('#editFormSize').removeClass('is-invalid');
      $('#editFormDetail').removeClass('is-invalid');

      $('.invalid-feedback.edit-name').empty();
      $('.invalid-feedback.edit-condition').empty();
      $('.invalid-feedback.edit-location').empty();
      $('.invalid-feedback.edit-size').empty();
      $('.invalid-feedback.edit-quantity').empty();
      $('.invalid-feedback.edit-size').empty();
      $('.invalid-feedback.edit-detail').empty();

      $.ajax({
        url: "{{ url('/dashboard/stuff-json/') }}/" + id + '/edit',
        type: "GET",
        dataType: "JSON",
        data: {
          method: '_EDIT',
        },
        success: function (data) {
          $('#editFormName').val(data.msg.name);
          $('#editFormCondition').val(data.msg.condition);
          $('#editFormLocation').val(data.msg.location);
          $('#editFormSize').val(data.msg.size);
          $('#editFormDetail').val(data.msg.detail);
          $('#editFormQuantity').val(data.msg.quantity);
        }
      })

    });

    $('#editForm').on('submit', function () {
      event.preventDefault();

      var id = $('#editFormId').val();

      $.ajax({
        url: "{{ url('/dashboard/stuff-json/') }}/" + id,
        type: "PUT",
        dataType: "JSON",
        data: {
          method: '_UPDATE',
          name: $('#editFormName').val(),
          condition: $('#editFormCondition').val(),
          category: $('#editFormCategory').val(),
          location: $('#editFormLocation').val(),
          size: $('#editFormSize').val(),
          detail: $('#editFormDetail').val(),
          quantity: $('#editFormQuantity').val(),
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

            if (data.errors.condition) {
              $('#editFormCondition').addClass('is-invalid');
              $('.invalid-feedback.edit-condition').text(data.errors.condition);
            } else {
              $('#editFormCondition').removeClass('is-invalid');
              $('.invalid-feedback.edit-condition').empty();
            }

            if (data.errors.location) {
              $('#editFormLocation').addClass('is-invalid');
              $('.invalid-feedback.edit-location').text(data.errors.location);
            } else {
              $('#editFormLocation').removeClass('is-invalid');
              $('.invalid-feedback.edit-location').empty();
            }

            // if (data.errors.size) {
            //   $('#editFormSize').addClass('is-invalid');
            //   $('.invalid-feedback.edit-sizw').text(data.errors.size);
            // } else {
            //   $('#editFormSize').removeClass('is-invalid');
            //   $('.invalid-feedback.edit-size').empty();
            // }

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
            toastr.success('Stuff ' + data.msg.name + ' updated');
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
                url: "{{ url('dashboard/stuff-json') }}/" + id,
                type: 'DELETE',
                dataType: 'JSON',
                data: {
                  method: '_DESTROY',
                },
                success: function (data) {
                  toastr.warning('Category ' + data.msg.name + ' deleted');
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
