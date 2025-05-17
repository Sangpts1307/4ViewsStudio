@extends('admin.index')

@section('content')

<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
    <div id="header">
        <h2><i class="fa-solid fa-circle-info"></i> Chi tiết "Tên concept"</h2>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
    <div class="col-md-12 content">
    <form action="{{ $isNew ? url('/admin/concept-add') : url('/admin/concept-save/'.$concept->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label>Tên concept</label>
                <input type="text" class="form-control margin-top-10" name="name" placeholder="Tên concept"
                    value="{{ $concept->name ?? '' }}" required>

                <label for="">Nội dung giới thiệu</label>
                <textarea class="form-control margin-top-10" name="short_content" rows="2" required>{{ $concept->short_content ?? '' }}</textarea>

                <label for="">Ảnh chính</label>
                <div class="main-image">
                    @if($isNew)
                        <div class="add-main-image">
                            <label for="main_image" class="add-concept">
                                <i class="fa-solid fa-plus"></i>
                            </label>
                            <input type="file" id="main_image" name="main_image" class="d-none" onchange="previewMainImage(event)" required>
                        </div>
                        <img id="preview_main" src="" alt="Ảnh chính" style="display:none; width: 320px; height: 250px;">
                    @else
                        @php
                            $mainImage = glob(public_path("image/concepts/concept_{$concept->id}/main_images/main_image.*"));
                        @endphp
                        @if (!empty($mainImage))
                            <img src="{{ asset(str_replace(public_path(), '', $mainImage[0])) }}" alt="Ảnh chính">
                        @else
                            <p class="text-danger">Ảnh chính chưa có. Vui lòng thêm ảnh.</p>
                        @endif                       
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <label for="">Giá concept</label>
                <input type="number" class="form-control margin-top-10" name="price" placeholder="Giá concept"
                    value="{{ $concept->price ?? '' }}" required>

                <label for="">Nội dung chi tiết</label>
                <textarea class="form-control margin-top-10" name="content" rows="14" required>{{ $concept->content ?? '' }}</textarea>
            </div>

            <div class="col-md-12 margin-top-10">
                <label>Ảnh phụ</label>
                <div class="list-image">
                    @if(!$isNew)
                        @php
                            $supportImages = glob(public_path("image/concepts/concept_{$concept->id}/support_images/*"));
                        @endphp
                        @foreach($supportImages as $image)
                            <div class="support-image">
                                <img src="{{ asset(str_replace(public_path(), '', $image)) }}" alt="Ảnh phụ">
                            </div>
                        @endforeach
                    @endif
                    <div class="support-image add-support-image">
                        <label for="support_images">
                            <i class="fa-solid fa-plus"></i>
                        </label>
                        <input type="file" id="support_images" name="support_images[]" multiple class="d-none" onchange="previewSupportImages(event)">
                    </div>
                </div>
            </div>

            <div class="button-container">
                @if($isNew)
                    <button type="submit" class="btn btn-primary btn-add">Thêm mới</button>
                @else
                    <button type="submit" class="btn btn-success btn-save">Lưu thông tin</button>
                    <a href="{{ url('/admin/concept-delete/' . $concept->id) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa concept này không?')">
                        Xóa concept
                    </a>
               
                @endif
            </div>
        </div>
    </form>

    </div>
    </div>

</div>

<script>
    function previewMainImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview_main');
            output.src = reader.result;
            output.style.display = 'block'; // Hiển thị ảnh preview
            document.querySelector('.add-main-image').style.display = 'none'; // Ẩn nút thêm ảnh
        };
        reader.readAsDataURL(input.files[0]);
    }

    let selectedFiles = []; // Mảng lưu tất cả file đã chọn

    function previewSupportImages(event) {
        var files = event.target.files;
        var previewContainer = document.querySelector('.list-image');

        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            // Kiểm tra nếu file đã tồn tại trong danh sách, tránh trùng lặp
            if (!selectedFiles.some(f => f.name === file.name)) {
                selectedFiles.push(file);

                var reader = new FileReader();
                reader.onload = function(e) {
                    var imgContainer = document.createElement('div');
                    imgContainer.classList.add('support-image');

                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('support-image-preview');

                    imgContainer.appendChild(img);
                    previewContainer.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            }
        }

        // **Cập nhật danh sách file ngay trong hàm**
        var fileInput = document.getElementById('support_images');
        var dataTransfer = new DataTransfer();

        selectedFiles.forEach(file => dataTransfer.items.add(file));

        fileInput.files = dataTransfer.files;
    }

    function confirmDelete(event) {
        event.preventDefault(); // Ngăn nút gửi form ngay lập tức
        if (confirm("Bạn có chắc chắn muốn xóa concept này không?")) {
            event.target.form.submit(); // Gửi form nếu xác nhận
        }
    }
</script>




<style>
    /* .content {
                background: linear-gradient(to bottom, #fff8e1, white);

    } */
        .w-95 {
        width: 95%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin: 0 auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .margin-top-10 {
        margin-top: 10px;
    }
    label {
        margin-top: 5px;
        font-weight: 500;
    }
    .main-image {
        margin-top: 10px;
    }
    .main-image img {
        margin-top: 10px;
        height: 40%;
        width: 55%;
        border-radius: 5px;
    }
    .list-image {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .support-image {
        width: 24%;
    }
    .support-image img {
        width: 100%;
        border-radius: 5px;
    }

    .add-main-image, .add-support-image {
        /* width: 24%;
        height: auto; */
        width: 302px; /* Điều chỉnh kích thước phù hợp */
        height: 226px;
        background-color: darkcyan; 
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        border: 1px solid black;
        cursor: pointer;
    }

    .add-main-image label, .add-support-image label {
        font-size: 50px;
        color: white;
        cursor: pointer;
        margin-bottom: 10px;

    }


    .button-container {
        display: flex; 
        justify-content: flex-end; 
        gap: 10px;
        margin-top: 25px;
        margin-right: 20px;
    }
    .btn-delete {
        width: auto;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-save {
        width: auto;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
@endsection
