<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blog = auth()->user()->blog;

        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }

    public function show($id)
    {
        $blog = auth()->user()->blog()->find($id); #Mấy câu query xử lý dữ liệu anh muốn sẽ được đẩy sang service, controller chỉ điều hướng việc xử lý
        #và trả về kết quả (1)

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog is not available! '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $blog->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required'
        ]); # Cái này cũng ok rồi đó.
        # Giờ anh muốn tích hợp validation kiểu khác không như kiểu này, sẽ tạo ra 1 thư mục riêng nằm trong thư mục Requests (2)

        $blog = new Blog();
        $blog->name = $request->name;
        $blog->detail = $request->detail;
        # Nguyên phần này tương tự (1)

        if (auth()->user()->blog()->save($blog))
            return response()->json([
                'success' => true,
                'data' => $blog->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be added!'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $blog = auth()->user()->blog()->find($id); #Tương tự (1)

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be found!'
            ], 400);
        }

        $updated = $blog->fill($request->all())->save(); #Tương tự (1)

        if ($updated)
            return response()->json([
                'success' => true,
                'data' => $blog
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be updated!'
            ], 500);
    }
    public function destroy($id)
    {
        $blog = auth()->user()->blog()->find($id); #Tương tự (1)

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be found!'
            ], 400);
        }

        if ($blog->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be deleted!'
            ], 500);
        }
    }
}
