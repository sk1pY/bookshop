@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Настройка интерфейса</h4>
        <hr>
        <form action="{{ route('admin.interfaces.slides.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" >
        <input type="text" name="type" value="slide" hidden>
        <input type="submit">
    </form>
    <table  class="table table-sm table-bordered table-striped w-auto">
        <thead>
        <tr class="text-center align-middle ">
            <th scope="col" class="col">Фото</th>
            <th scope="col" class="col">Удалить/изменить</th>
        </tr>
        </thead>
        <tbody >
        @foreach($slides as $slide)

            <tr class="align-middle">
                <td>
                    <img src="{{Storage::url('slideImages/'.$slide->image)}}" alt="123" style="width: 100px">
                </td>
                <td class="text-center">
                    <form action="{{ route('admin.interfaces.slides.destroy',$slide) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm">
                            <i type="submit" class="bi bi-x "></i>
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
