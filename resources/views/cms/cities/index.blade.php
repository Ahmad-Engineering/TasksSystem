@extends('cms.parent')

@section('title', 'Home')

@section('capital-starter-page', 'All City')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'cities')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All cities</h3>

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
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cities as $city)
                      <tr>
                        <td>{{$city->id}}</td>
                        <td>{{$city->name}}</td>
                        <td>{{$city->created_at}}</td>
                        <td>{{$city->updated_at}}</td>
                        <td>
                          <div class="btn-group">

                            @can('Update-City')
                                <a href="{{route('cities.edit', $city->id)}}" class="btn btn-info">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @endcan


                            {{-- <form method="POST" action="{{route('cities.destroy', $city->id)}}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form> --}}

                            @can('Delete-City')
                                <a href="#" class="btn btn-danger" onclick="confirmDestroy({{$city->id}}, this)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endcan

                            {{-- <button type="button" class="btn btn-danger">
                              <i class="fas fa-trash"></i>
                            </button> --}}
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
    <script>
      function confirmDestroy (id, refrence) {
        // console.log("ID : " + id);
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
              destory(id, refrence);
          }
        });
      }

      function destory (id, refrence) {
        // cms/admin/cities/{city}
        axios.delete('/cms/admin/cities/' + id)
          .then(function (response) {
            // handle success
            console.log(response);
            refrence.closest('tr').remove();
            showMessage(response.data);
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            showMessage(error.response.data);
          })
          .then(function () {
            // always executed
        });
      }

      function showMessage (data) {
        Swal.fire({
            icon: data.icon,
            title: data.title,
            text: data.text,
            showConfirmButton: false,
            timer: 1500
        });
      }
    </script>
@endsection
