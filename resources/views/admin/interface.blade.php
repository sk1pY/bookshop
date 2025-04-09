@extends('admin.layouts.index')
@section('content')
    <p>Slide store</p>
    <form action="{{ route('admin.interfaces.slides.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" >
        <input type="text" name="type" value="slide" hidden>
        <input type="submit">
    </form>
    <table  class="table table-sm table-bordered table-striped">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-5">Фото</th>
            <th scope="col" class="col-1">Удалить/изменить</th>
        </tr>
        </thead>
        <tbody >
        @foreach($slides as $slide)

            <tr class="align-middle">
                <td>
                    <img src="{{Storage::url('imageSlide/'.$slide->image)}}" alt="123" class="w-25">
                </td>
                <td>
                    <form action="{{ route('admin.interfaces.slides.destroy',$slide) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete">
                    </form>                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
