<ul class="list-unstyled">
    @foreach($categories as $category)
        <li style="font-size: 1.1rem" class=" text">
            <a href="{{route('books.categoryBooks',['id' => $category->id])}}">{{ $category->name }}</a>
        </li>
    @endforeach
</ul>

