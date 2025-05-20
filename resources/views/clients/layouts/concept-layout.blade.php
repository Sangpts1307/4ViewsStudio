<div class="conceptt">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="row">
                        <div class="content-concept text-center">
                            <h4>DỊCH VỤ CHỤP HÌNH TẠI 4VIEWS STUDIO</h4>
                            <p>Dưới đây là những concept chụp siêu hot của Studio</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <div class="col-md-12 box-concept">
        <div class="row">
            @foreach($concepts as $concept)
            <div class="col-md-3 box-concept-detail">
                @php
                $mainImagePath = public_path("image/concepts/concept_{$concept->id}/main_images/");
                $mainImageFiles = glob($mainImagePath . 'main_image.*');
                @endphp


                @if (!empty($mainImageFiles))
                @php
                $relativePath = str_replace(public_path(), '', $mainImageFiles[0]);
                @endphp
                <img src="{{ asset(ltrim($relativePath, '/')) }}" alt="Ảnh chính" class="image-concept">
                @else
                <img src="{{ asset('image/avt.png') }}" alt="Ảnh mặc định" class="image-concept">
                @endif
                <a href="{{ url('/clients/concept-detail/' . $concept->id) }}">
                    <button>{{ $concept->name }}</button>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<style>
    .content-concept {
        margin-top: 20px;
    }

    .conceptt {
        background: linear-gradient(to bottom, #fff8e1, white);
    }

    .box-concept {
        margin: 15px 100px 15px 100px;
    }


    .box-concept .row {
        margin-left: 120px;
    }


    .box-concept-detail {
        position: relative;
        text-align: center;
        margin: 10px;
        height: 250px;
        overflow: hidden; /* nếu nội dung vượt quá thì ẩn */
    }


    .box-concept-detail img {
        display: block;
        width: 100%;
        height: auto;
        object-fit: contain;
        max-width: 100%;
        max-height: 100%;
    }


    .box-concept-detail button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        color: black;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        font-weight: bold;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }


    .box-concept-detail button:hover {
        background-color: #f0f0f0;
    }
</style>