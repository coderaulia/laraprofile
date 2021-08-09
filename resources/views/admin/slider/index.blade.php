@extends('admin.admin_master')

@section('admin')

<div class="py-12">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="container">
        <div class="row">

            <a href="{{ route('add.slider') }}" class="btn mb-2 btn-info">Add Slider</a>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        All Slider Images
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php ($no = 1)
                            @foreach($slider as $data)
                            <tr>
                                <th scope="row">{{ $no++ }}</th>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                </td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <a href="{{ url('slider/edit/'.$data->id) }}" class="btn btn-info">Edit</a>
                                    <a href="{{ url('slider/delete/'.$data->id) }}"
                                        onclick="return confirm('Are you sure to delete?')"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
