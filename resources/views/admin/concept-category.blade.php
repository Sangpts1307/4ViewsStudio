@extends('admin.index')

@section('content')
<div id="header">
    <h2><i class="fa-solid fa-list"></i> Danh mục concept</h2>
</div>
<div class="col-md-12 margin-top-3">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @foreach($concepts as $concept)
                    <div class="col-md-3 item-center">
                        <div class="form-concept">
                            <h5>{{ $concept->name }}</h5>
                            <button class="btn btn-primary">
                                <a href="{{ url('/admin/concept-detail/'.$concept->id) }}">Xem chi tiết</a>
                            </button>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-3 item-center">
                    <div class="form-concept">
                        <a class="add-concept" href="{{ url('/admin/concept-detail') }}">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<style>
    .form-concept {
        background-color: #d49cc6;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
        width: 80%;
        height: 90%;

    }

    .item-center {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-concept button {
        margin-top: 10px;
        background-color: #007bff;

    }

    .form-concept button a {
        color: white;
        text-decoration: none;
    }

    .add-concept {
        font-size: 50px;
        color: #fff;
        text-decoration: none;
        height: 100%;
        width: 100%;
    }

    .margin-top-3 {
        margin-top: 3%;
    }
</style>`
@endsection
