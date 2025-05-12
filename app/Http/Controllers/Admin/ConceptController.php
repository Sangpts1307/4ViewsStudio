<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;



class ConceptController extends Controller
{
    public function conceptCategory()
    {
        $concepts = Concept::all();
        return view("admin.concept-category", compact("concepts"));
    }

    public function conceptDetail(Request $request, $id = null)
    {
        $concept = $id ? Concept::find($id) : new Concept(); // Nếu có ID, lấy dữ liệu; nếu không, tạo mới rỗng
        $isNew = is_null($id); // Xác định trạng thái "Thêm mới"

        return view('admin.concept-detail', compact('concept', 'isNew'));
    }

    public function addConcept(Request $request)
    {
        $param = $request->all();
        $existingConcept = Concept::where('name', $param['name'])->first();
        if ($existingConcept) {
            return redirect()->back()->with('error', 'Tên concept đã tồn tại!');
        }

        $concept = new Concept();
        $concept->name = $param['name'];
        $concept->price = $param['price'];
        $concept->short_content =  $param['short_content'];
        $concept->content = $param['content'];
        $concept->save();

        // Tạo thư mục lưu trữ nếu chưa tồn tại
        $conceptFolder = public_path("image/concepts/concept_{$concept->id}");
        $mainImageFolder = "{$conceptFolder}/main_images";
        $supportImageFolder = "{$conceptFolder}/support_images";

        foreach ([$conceptFolder, $mainImageFolder, $supportImageFolder] as $folder) {
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
        }

        $allowedExtensions = ['png', 'jpg', 'jpeg'];

        // **Lưu ảnh chính**
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, $allowedExtensions)) {
                $fileName = "main_image.{$extension}";
                $mainImagePath = "{$mainImageFolder}/{$fileName}";
                $file->move($mainImageFolder, $fileName);

                Image::create([
                    'concept_id' => $concept->id,
                    'file_name' => "image/concepts/concept_{$concept->id}/main_images/{$fileName}",
                    'role' => 0
                ]);
            }
        }

        // **Lưu nhiều ảnh phụ**
        if ($request->hasFile('support_images')) {
            foreach ($request->file('support_images') as $image) {
                if (!$image->isValid()) continue; // Kiểm tra file hợp lệ

                $extension = strtolower($image->getClientOriginalExtension());
                if (!in_array($extension, $allowedExtensions)) continue;

                $fileName = uniqid('support_') . ".{$extension}";
                $imagePath = "{$supportImageFolder}/{$fileName}";
                $image->move($supportImageFolder, $fileName);

                Image::create([
                    'concept_id' => $concept->id,
                    'file_name' => "image/concepts/concept_{$concept->id}/support_images/{$fileName}",
                    'role' => 1
                ]);
            }
        }

        return redirect('/admin/concept-category')->with('success', 'Concept đã được thêm mới!');
    }

    public function saveConcept(Request $request, $id)
    {
        $param = $request->all();
        $concept = Concept::find($id);
        $concept->name = $param['name'];
        $concept->price = $param['price'];
        $concept->short_content =  $param['short_content'];
        $concept->content = $param['content'];
        $concept->save(); // Cập nhật thông tin concept

        $conceptFolder = public_path("image/concepts/concept_{$concept->id}");
        $supportImageFolder = "{$conceptFolder}/support_images";

        if ($request->hasFile('support_images')) {
            foreach ($request->file('support_images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $fileName = uniqid('support_') . ".{$extension}";
                $imagePath = "{$supportImageFolder}/{$fileName}"; // Đường dẫn tuyệt đối

                // **Di chuyển file vào thư mục**
                $image->move($supportImageFolder, $fileName);

                // **Lưu vào database**
                Image::create([
                    'concept_id' => $concept->id,
                    'file_name' => "image/concepts/concept_{$concept->id}/support_images/{$fileName}",
                    'role' => 1
                ]);
            }
        }


        return redirect('/admin/concept-detail/' . $id)->with('success', 'Concept đã được cập nhật!');
    }

    public function deleteConcept($id)
    {
        $concept = Concept::find($id);
        $conceptFolder = public_path("image/concepts/concept_{$concept->id}");
        if (File::isDirectory($conceptFolder)) {
            // Xóa toàn bộ thư mục và các file trong đó
            File::deleteDirectory($conceptFolder);
        }
        // Xóa ảnh liên quan trong DB
        Image::where('concept_id', $concept->id)->delete();

        // Xóa concept
        $concept->delete();

        return redirect('/admin/concept-category')->with('success', 'Đã xóa concept thành công!');
    }
}
