@extends('layouts.dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item">
  <a href="{{ url('/dashboard/stuff') }}">Stuff</a>
</li>
<li class="breadcrumb-item active">
  Category
</li>
@endsection

@section('content')
<div class="card mb3">

  <div class="card-header">
    Category
    <buton id="addButton" class="btn btn-info" style="float: right" data-toggle="modal" data-target="#addModal">
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
        Add new Category
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="addForm">
          <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" id="addFormName">
            <p class="invalid-feedback add-name"></p>
          </div>
          <br/>
          <input type="submit" class="btn btn-success" value="Save">
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
        Edit Category
        <button class="close" role="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body"></div>

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
      ajax: "{{ route('category') }}",
      columns: [
        { data: 'Category', name: 'Category' },
        { data: 'Create Date', name: 'Create Date', searchable: false },
        { data: 'action', name: 'action', searchable: false }
      ]
    });

    $('#addButton').on('click', function () {
      $('#addForm').trigger('reset');

      $('#addFormName').removeClass('is-invalid');
      $('.invalid-feedback.add-name').empty();
    });

    $('#addForm').on('submit', function () {
      event.preventDefault();

      $.ajax({
        url: "{{ url('dashboard/stuff/category-json') }}",
        dataType: 'JSON',
        type: 'POST',
        data: {
          method: '_STORE',
          name: $('#addFormName').val(),
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
          } else {
            $('#addModal').modal('hide');
            toastr.success('New Category Added');
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
                url: "{{ url('dashboard/stuff/category-json') }}/" + id,
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
