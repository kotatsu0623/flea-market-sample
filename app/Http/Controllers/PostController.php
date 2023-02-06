<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests\ItemRequest;
use App\Like;
use App\Category;
use App\Http\Requests\ItemEditRequest;
use App\Http\Requests\ItemImageRequest;
use App\Services\FileUploadService;
use App\Order;
 
class PostController extends Controller
{
    //商品一覧
    public function index()
    {
        $user = \Auth::user();
        $items = Item::where('user_id', '<>', $user->id)->latest()->get();
        // $orders = Order::all()->pluck('item_id');
          return view('items.index', [
            'title' => '息をするように買おう',
            'items' => $items,
            'user'=>$user,
            // 'orders' => $orders
          ]);
    }
 
    // 新規投稿フォーム
    public function create()
    {
        return view('items.create', [
          'title' => '商品を出品',
          'categories' => Category::all(),
        ]);
    }
 
    public function store(ItemRequest $request, FileUploadService $service)
    {
        $path = $service->saveImage($request->file('image'));
        $item = Item::create([
            'user_id' => \Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $path,
        ]);
        \Session::flash('success', '商品を追加しました');
        return redirect()->route('items.show', $item);
    }
 
    // 商品詳細
    public function show($id)
    {
        $item = Item::find($id);
        return view('items.show', [
           'title' => '商品詳細', 
           'item' => $item,
        ]);
    }
 
    // 投稿編集フォーム
    public function edit($id)
    {
        $item = Item::find($id);
        return view('items.edit', [
            'title' => '商品情報の編集',
            'item' => $item,
            'categories' => Category::all(),
        ]);
    }
 
    // 投稿更新処理
    public function update(ItemEditRequest $request, $id)
    {
        $item = Item::find($id);
        $item->update($request->only(['name','description','price','category_id']));
        session()->flash('success', '商品情報を編集しました');
        return redirect()->route('items.show', $item);
    }
 
    // 投稿削除処理
    public function destroy($id)
    {
        $item = Item::find($id);
        
        // 画像の削除
        if($item->image !== ''){
            \Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();
        \Session::flash('success', '出品商品を削除しました');
        return redirect()->route('users.exhibitions', \Auth::user());
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function editImage($id)
    {
        $item = Item::find($id);
        return view('items.edit_image', [
           'title' => '画像変更画面',
           'item' => $item,
        ]);
    }
    
    public function updateImage($id, ItemImageRequest $request, FileUploadService $service){
        
        // 画像投稿処理
        $path = $service->saveImage($request->file('image'));
        
        $item = Item::find($id);
        
        // 変更前の画像の削除
        if($item->image !== ''){
            \Storage::disk('public')->delete('photos/' . $item->image);
        }
        
        $item->update([
            'image' => $path, // ファイル名を保存
        ]);
        
        \Session::flash('success', '画像を変更しました');
        return redirect()->route('items.show', $item);
    }
    
    public function toggleLike($id){
        $user = \Auth::user();
        $item = Item::find($id);
 
        if($item->isLikedBy($user)){
            // いいねの取り消し
            $item->likes->where('user_id', $user->id)->first()->delete();
            \Session::flash('success', 'いいねを取り消しました');
        } else {
            // いいねを設定
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            \Session::flash('success', 'いいねしました');
        }
        return redirect('/items');
    }
    
    public function confirm($id)
    {
        $item = Item::find($id);
        return view('items.confirm', [
           'title' => '購入確認画面', 
           'item' => $item,
        ]);
    }
    
    public function purchase($id)
    {
        $item = Item::find($id);
        if ($item->orders->count() > 0) {
            return redirect()->route('items.show', $item)->withErrors('申し訳ありません。ちょっと前に売り切れました。');
        } else {
            Order::create([
                'user_id' => \Auth::user()->id,
                'item_id' => $id,
            ]);
            return view('items.finish', [
                'title' => 'ご購入ありがとうございました',
                'item' => $item,
            ]);
        }
    }
    
}