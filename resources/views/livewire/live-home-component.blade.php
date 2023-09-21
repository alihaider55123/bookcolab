<div class="container border p-5 mt-3">
    <h1>Available Books</h1>
    <div class="row">
        @foreach ($books as $item)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card" >
                <div class="card-body">
                  <h5 class="card-title">{{$item->name}}</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Auther: {{$item->auther    ->name}}</h6>
                  <p class="card-text">{{$item->intro}}</p>
                  <a href="{{route('book', $item->id)}}" class="card-link">Read</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
