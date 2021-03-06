@extends('cms.parent')

@section('title', 'Admins')

@section('capital-starter-page', 'Admins')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'admins')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admins</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-striped text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Active</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($admins as $admin)
                      <tr>
                        <td>{{$admin->id}}</td>
                        <td>{{$admin->name}}</td>
                        {{-- <td>@if({{$admin->active}}) {{"Active"}} @else {{"Disabled"}} @endif</td> --}}
                        <td><span class="badge @if($admin->active) bg-success @else bg-danger @endif">{{$admin->status}}</span></td>
                        <td>{{$admin->created_at}}</td>
                        <td>{{$admin->updated_at}}</td>
                        <td>
                          <div class="btn-group">
                            @can('Update-Admin')
                                <a href="{{route('admins.edit', $admin->id)}}" class="btn btn-info">
                                <i class="fas fa-pen"></i>
                                </a>
                            @endcan


                            @can('Delete-Admin')
                                <a href="#" class="btn btn-danger" onclick="confirmDestroy({{$admin->id}}, this)">
                                <i class="fas fa-trash"></i>
                                </a>
                            @endcan
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('company-name', env('APP_NAME'))

@section('version', 'Version: ' . env('APP_VERSION'))


@section('scripts')
    {{-- HERE SCRIPTS --}}
    <script>
      function confirmDestroy(id, refrance) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            destoy(id, refrance);
          }
        });
      }

      function destoy (id, refrance) {
        // cms/admin/admins/{admin}
        axios.delete('/cms/admin/admins/' + id)
          .then(function (response) {
            // handle success
            console.log(response);
            refrance.closest('tr').remove();
            showDeletingMessage(response.data);
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            showDeletingMessage(error.response.data);
          })
          .then(function () {
            // always executed
          });
      }

      function showDeletingMessage (data) {
        Swal.fire({
          icon: 'success',
          title: 'Your work has been saved',
          showConfirmButton: false,
          timer: 2000
        });
      }
    </script>
@endsection
