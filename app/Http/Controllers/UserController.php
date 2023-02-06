<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Item;
use App\Services\FileUploadService;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function edit(){
        $user = \Auth::user();
        return view("users.edit", [
            'title' => 'プロフィール編集',
            'user' => $user,
        ]);
    }
    
    public function update(ProfileRequest $request) {
        $user = \Auth::user();
        $user->update(
            $request->only(['name', 'email', 'profile'])
        );
        session()->flash('success', 'プロフィールを更新しました');
        return redirect()->route('users.show', \Auth::user());
    }
    
    public function show($id){
        $user = User::find($id);
        $items = \Auth::user()->items()->count();
        return view("users.show", [
            'title'=>'プロフィール',
            'user' => $user,
            'items' => $items
        ]);
    }
    
    public function editImage(){
        $user = \Auth::user();
        return view("users.edit_image", [
            'title' => '画像編集',
            'user' => $user,
        ]);
    }
    
    public function updateImage(ProfileImageRequest $request, FileUploadService $service){
        $path = $service->saveImage($request->file('image'));
        
        $user = \Auth::user();
        
        if($user->image !== ''){
            \Storage::disk('public')->delete('photos/' . $user->image);
        }
        
        $user->update([
            'image' => $path,    
        ]);
        
        \Session::flash('success', '画像を変更しました');
        return redirect()->route('users.show', \Auth::user());
    }
    
    public function exhibitions($id){
        $user = User::find($id);
        $items = $user->items()->latest()->get();
          return view('users.exhibitions', [
            'title' => $user->name . 'の出品商品一覧',
            'items' => $items,
          ]);
    }
}