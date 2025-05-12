@extends('staff.index')
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-80">
            <h2 class="text-center"><i class="fa-solid fa-plus"></i> Thêm link ảnh</h2>
            <form action="" method="post">
                <div class="col-md-12 margin-top-2">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Người nhận</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Người nhận">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 margin-top-2">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Email</p>
                        </div>
                        <div class="col-md-9">

                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 margin-top-2">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Concept</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Concept">
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-12 margin-top-2">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Link ảnh</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Link ảnh">
                        </div>
                    </div>
                        
                </div>
                <div class="col-md-12 margin-top-2">
                    <div class="row">
                        <div class="col-md-3">
                            <p>Lời nhắn</p>
                        </div>
                        <div class="col-md-9">
                           <textarea class="form-control" name="" id=""  rows="3"></textarea>
                        </div>
                    </div>
                </div>
              
                    <input type="submit" value="Gửi" class="btn btn-primary big-btn">

                
                
            </form>
        </div>
    </div>

    <style>
        .w-80 {
            width: 80%;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin: 0 auto;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .margin-top-2 {
            margin-top: 2%;
        }
        .big-btn {
            width: 20%;
            margin: 0 auto;
            margin-top: 2%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
           
            justify-content: center;
            align-items: center;
            display: flex;
        }
      
    </style>
@endsection
