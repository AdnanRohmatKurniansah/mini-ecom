@extends('layout.dashboard')

@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manage Blog Categories</h3>
                <a href="/dashboard/blogs/categories/create" class="btn btn-success me-1 my-3">Create</a>
            </div>
        </div>
    </div>

<div class="row" id="table-striped">
  <div class="col-9">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        </div>
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($blogCategories as $category)  
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $category->name }}</td>
                  <td class="d-flex">
                    <a href="/dashboard/blogs/categories/{{ $category->slug }}/edit"><i class="badge-circle badge-circle-light-secondary" data-feather="edit"></i></a>
                    <form action="/dashboard/blogs/categories/{{ $category->slug }}" method="post">
                      @method('delete')
                      @csrf
                        <button class="badge-circle badge-circle-light-secondary text-red border-0" style="background-color: transparent" onclick="return confirm('Are you sure?')" type="submit"><i data-feather="trash"></i></button>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
      <ul class="pagination pagination-primary">
          <li class="page-item"><a class="page-link" href="{{ $blogCategories->previousPageUrl() }}">Prev</a></li>
          @foreach ($blogCategories->getUrlRange(1, $blogCategories->lastPage()) as $page => $url)
              <li class="page-item {{ $blogCategories->currentPage() == $page ? 'active' : '' }}">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
          @endforeach
          <li class="page-item"><a class="page-link" href="{{ $blogCategories->nextPageUrl() }}">Next</a></li>
      </ul>        
    </div>

  </div>
</div>

</div>

@endsection