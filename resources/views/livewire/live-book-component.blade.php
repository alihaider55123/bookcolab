<div class="container border p-5 mt-3">
    <h1>{{$book->name}}</h1>
    <h4>Intro</h4>
    <p>{{$book->intro}}</p>
    @php
    function displayTree($item, $padding = 0){
        foreach($item->children as $child){
            
    @endphp
        <div style="padding-left: {{$padding}}px">
            <h2>{{$child->title}}</h2>  
            <p>{{$child->content}}</p>    
        </div>
    @php
            if(count($child->children)){
                $padding += 20;
                displayTree($child, $padding);
                $padding -= 20;
            }
        }
    }
    @endphp
    @foreach ($book->sections as $item)
        <div style="padding-left: 0px">
            <h2>{{$item->title}}</h2>  
            <p>{{$item->content}}</p>    
        </div>
        @php
        displayTree($item, 20)
        @endphp
    @endforeach
</div>
