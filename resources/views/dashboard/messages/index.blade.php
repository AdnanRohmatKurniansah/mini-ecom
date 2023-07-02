@extends('layout.dashboard')

@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manage Messages</h3>
            </div>
        </div>
    </div>

<div class="row mt-5" id="table-striped">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
        </div>
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr> 
            </thead>
            <tbody>
              @foreach ($messages as $message)  
              @php
                  $status = $message->status;
                  $class = $status == 'read' ? 'bg-success text-white' : 'bg-danger text-white';
              @endphp
              <tr>
                  <td>{{ $message->name }}</td>
                  <td>{{ $message->email }}</td>
                  <td class="{{ $class }}">{{ $message->status }}</td>
                  <td class="d-flex">
                    <a href="/dashboard/messages/{{ $message->id }}/show"><i class="badge-circle badge-circle-light-secondary" data-feather="eye"></i></a>
                    <form action="/dashboard/messages/{{ $message->id }}" method="post">
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
            <li class="page-item"><a class="page-link" href="{{ $messages->previousPageUrl() }}">Prev</a></li>
            @foreach ($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                <li class="page-item {{ $messages->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item"><a class="page-link" href="{{ $messages->nextPageUrl() }}">Next</a></li>
        </ul>        
    </div>

  </div>
</div>

</div>

@endsection