<h4>Категории</h4>
<ul class="list-unstyled">
    @foreach($categories as $category)
        <li>
            <a href="{{route('books.categoryBooks',['id' => $category->id])}}">{{ $category->name }}</a>
        </li>
    @endforeach
</ul>

