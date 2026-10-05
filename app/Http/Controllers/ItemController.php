<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // แสดงรายการของทั้งหมด
    public function index()
    {
        $items = Item::with(['user', 'category'])
            ->latest()
            ->get();

        return response()->json($items);
    }

    // แสดงรายละเอียดของ
    public function show(Item $item)
    {
        $item->load([
            'user',
            'category',
            'comments.user',
            'requests.user'
        ]);

        return response()->json($item);
    }

    // เพิ่มของที่จะส่งต่อ
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition' => 'nullable|string|max:255',

            // รองรับไฟล์รูปภาพ
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:available,reserved,transferred',
        ]);

        // ถ้ามีการอัปโหลดรูป
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store(
                'items',
                'public'
            );

            $validated['image'] = '/storage/' . $path;
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        $item = Item::create($validated);

        return response()->json([
            'message' => 'เพิ่มของสำเร็จ',
            'item' => $item
        ], 201);
    }

    // แก้ไขข้อมูลของ
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'condition' => 'nullable|string|max:255',

            // รองรับไฟล์รูปภาพตอนแก้ไข
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'location' => 'nullable|string|max:255',
            'status' => 'sometimes|in:available,reserved,transferred',
        ]);

        // ถ้ามีรูปใหม่
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store(
                'items',
                'public'
            );

            $validated['image'] = '/storage/' . $path;
        }

        // อัปเดตข้อมูล
        $item->update($validated);

        return response()->json([
            'message' => 'แก้ไขข้อมูลสำเร็จ',
            'item' => $item
        ]);
    }

    // ลบของ
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'ลบข้อมูลสำเร็จ'
        ]);
    }
}
