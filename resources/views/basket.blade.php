@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ( session('error') )
        <div class="alert alert-danger d-flex px-4">
            <div>{{ session('error') }}</div>
        </div>
    @endif
    @if ( session('success') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
        </div>
    @endif
    <div class="row">
        <div class="col-6 rounded-5 bg-white ms-4 p-4 table-responsive">

            <table class="table table-sm" style="width: 500px">

                <tbody>
                @forelse($books as $book)
                    <tr>
                        <td class="align-middle">

                            <div class="d-flex w-auto align-items-center">
                                <div class="form-check" style="transform:scale(1.3);">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                           value="{{ json_encode($book) }}" checked >
                                    <label class="form-check-label" for="inlineCheckbox1"></label>
                                </div>
                                <img style="width: 80px" src="{{ Storage::url('booksImages/' .$book->image) }}"
                                     alt="">
                                <div class="ms-3">
                                    <a href="{{route('books.book',['book'=> $book->id])}}">
                                        {{ $book->title }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">

                                <form action="{{ route('basket.delete',['id'=> $book->id]) }}" method="post"
                                      style="margin-right: 10px;">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-light">-</button>
                                </form>

                                <div class="  d-flex text-center ">{{ $book->quantity }}</div>
                                <form action="{{ route('basket.add',['id'=> $book->id]) }}" method="post"
                                      style="margin-left: 10px;">
                                    @csrf
                                    <button class="btn btn-light">+</button>
                                </form>

                            </div>
                            Цена: {{ $book ->price * $book-> quantity  }}
                        </td>
                        <td class="align-middle">
                            <form action="{{ route('basket.deleteAll', ['book'=>$book->id])}}" method="post"
                                  id>
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm fs-3">
                                    <i type="submit" class="bi bi-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <h5>Пустая корзина</h5>
                @endforelse
                </tbody>
            </table>


        </div>
        @guest
            <div class="col border rounded-5 bg-white ms-4 p-4">
                <p>Зарегистрируйтесь или авторизуйтесь, чтобы сделать заказ</p>
                <a class="btn btn-secondary" href="{{ route('register') }}">Регистрация</a>
                <a class="btn btn-secondary" href="{{ route('login') }}">Войти</a>

            </div>
        @endguest
        @auth

            <div class="col">

                <div class="border rounded-5 bg-white ms-4 p-4">
                    <form id="bookForm" class="d-flex flex-column" action="{{ route('basket.order') }}" method="post">
                        @csrf
                        <input type="hidden" id="basket" name="basket">
                        <input class="form-control" type="hidden" name="total_price" value="{{ $total_price }}">
                        <label for="name">Имя</label>
                        <input class="mb-3 form-control" id="name" name="name" type="text"
                               value="{{ Auth::user()->name ?? old('name') }}">
                        <label for="surname">Фамилия</label>
                        <input class="mb-3 form-control" id="surname" name="surname" type="text"
                               value="{{ Auth::user()->surname ?? old('surname') }}">
                        <label for="phone">Телефон</label>
                        <input class="mb-3 form-control" id="phone" name="phone" type="text"
                               value="{{ Auth::user()->phone?Auth::user()->phone:'+375'}}" maxlength="13">
                        <label for="address">Самовывоз</label>
                        <select name="address" class="form-select mb-3">
                            @foreach($addresses as $address)
                                <option value="{{$address->address}}">{{$address->address}}</option>

                            @endforeach
                        </select>
                        <input class="btn btn-danger w-25 w-auto" type="submit" value="Сделать заказ">
                    </form>
                </div>
                <div class="border rounded-5 bg-white ms-4 p-4 mt-3 fs-5">
                    <div class="d-flex justify-content-between">
                        <div>Итого</div>
                        <div>{{ $total_price }}р.</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Доставка</div>
                        <div>0р.</div>
                    </div>
                </div>


            </div>
        @endauth
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectedBooks = [];

            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                if (checkbox.checked) {
                    selectedBooks.push(JSON.parse(checkbox.value));
                }

                checkbox.addEventListener('change', function () {
                    const book = JSON.parse(this.value);

                    if (this.checked) {
                        selectedBooks.push(book);
                    } else {
                        const index = selectedBooks.findIndex(item => item.id === book.id);
                        if (index > -1) {
                            selectedBooks.splice(index, 1);
                        }
                    }
                    console.log(selectedBooks);
                });
            });

            document.getElementById('bookForm').addEventListener('submit', function () {
                document.getElementById('basket').value = JSON.stringify(selectedBooks);
            });
        });


    </script>
@endsection
