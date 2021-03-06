<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Services\ServiceCategory;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function cardSuccessPopup($product_id)
    {
        $product = Product::find($product_id);

        return view('includes.card_success_popup', [
            'product'  => $product
        ]);
    }

    public function productDetail($product_url){

        $product = Product::productInfoWith()
                            ->with(['images' => function($query){
                                    $query->OrderBy('order', 'ASC');
                                }
                            ])
                            ->where('url', $product_url)
                            ->firstOrFail();

        $reviews = $ratings_groups = false;


        //Похожие товары
        if($product->parent_id){
            $group_products = Product::where('parent_id', $product->parent_id)->productInfoWith()->OrderBy('price')->get();
        }else{
            $group_products = $product->children()->productInfoWith()->OrderBy('price')->get();
        }

        //С этим товаром покупаю
        $products_interested = $product->productAccessories()->productInfoWith()->get();
        if($products_interested->isEmpty())
            $products_interested = $product->productAccessoriesBack()->productInfoWith()->get();


        //Кол-во просмотров
        if(!Helpers::isAdmin())
            $product->increment('view_count');

        //категория
        if($product->parent_id)
        {
            $category = Category::find($product->parent->categories[0]->id);
        }else{
            $category = Category::find($product->categories[0]->id);
        }

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->id, $product->name);

        //seo
        $seo = Seo::productDetail($product, $category);

        if($product->parent_id)
        {
            $product_parent = $product->parent;
            $product->description = $product_parent->description;
            $product->attributes  = $product_parent->attributes;
        }


        return view(Helpers::isMobile() ? 'mobile.product.index' : 'site.product_detail', [
            'product'             => $product,
            'reviews'             => $reviews,
            'ratings_groups'      => $ratings_groups,
            'group_products'      => $group_products,
            'products_interested' => $products_interested,
            'category'            => $category,
            'seo'                 => $seo,
            'breadcrumbs'         => $breadcrumbs,
        ]);
    }

    public function productSearch(Request $request){

        $products = Product::filters(['name' => $request->input('searchText'), 'active' => 1])->limit(10)->get();
        $data = $products->map(function ($item) {
            return [
                'id'      => $item->id,
                'name'    => $item->name,
                'url'     => $item->detailUrlProduct(),
                'photo'   => $item->pathPhoto(true),
                'price'   => Helpers::priceFormat($item->getReducedPrice()),
            ];
        });

        return  $this->sendResponse($data);
    }

    public function productImages($product_id){
        $product = Product::with('images')->findOrFail($product_id);

        $images = $product->images->map(function ($image) {
            return [ $image->imagePath(true) ];
        });

        return  $this->sendResponse([
            'images'  => $images,
            'youtube' => $product->youtube,
            'photo'   => $product->pathPhoto(true)
        ]);
    }

    public function setRating(Request $request){

        $product_id = $request->input('product_id');
        $reviews_rating_avg = $request->input('reviews_rating_avg');
        $reviews_count = $request->input('reviews_count');

        $product = Product::findOrFail($product_id);
        $product->reviews_rating_avg = $reviews_rating_avg;
        $product->reviews_count = $reviews_count;
        $product->save();

        return  $this->sendResponse($request->all());

    }

    public function getProduct($product_id){
        $product = Product::findOrFail($product_id);
        return  $this->sendResponse([
            'product'          => $product,
            'detailUrlProduct' => $product->detailUrlProduct(),
            'pathPhoto'        => $product->pathPhoto(true),
            'price'            => Helpers::priceFormat($product->getReducedPrice()),
            'attributes'       => $product->attributes
        ]);
    }

}
