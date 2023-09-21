<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    My Books <a href="{{route('add-book')}}"><button class="btn btn-primary float-end">Add new book</button></a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <th>Intro</th>
                            <th>Collaborators</th>
                            <th>Date Added</th>
                            <th></th>
                        </tr>
                        @foreach ($books as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->intro}}</td>
                            <td>{{implode(', ', collect($item->current_collaborators)->pluck('name')->toArray())}}</td>
                            <td>{{\Carbon\Carbon::create($item->created_at)->format('M/d/Y h:i a')}}</td>
                            <td><a href="{{route('edit-book', $item->id)}}">Edit</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>