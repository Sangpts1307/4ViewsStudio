@extends('admin.index')

@section('content')

<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
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
    </div>

</div>

<style>
    .w-95 {
        width: 95%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin: 0 auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-concept {
        background: linear-gradient(to bottom, #e0f5e5, #fff8e1);
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
        color: black;
        text-decoration: none;
        height: 100%;
        width: 100%;
    }

    .margin-top-3 {
        margin-top: 3%;
    }
</style>`
@endsection
