<?php

namespace App\Http\Controllers;

use App\View\Components\ProductCard;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductDummyController extends Controller
{

    /* ini cuman test dummy doang, hapus pas database sudah ada. */

 public function paginateArray(array $items, int $perPage, ?int $page = null): LengthAwarePaginator
   { 
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $offset = ($page - 1) * $perPage;
        $pagedItems = array_slice($items, $offset, $perPage);

        return new LengthAwarePaginator($pagedItems, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function index(Request $request)
    {
        $products = [
            [
                "id" => 1,
                "name" => "produk 1",
                "description" => "deskripsi produk 1",
                "price" => 145,
                "image" => "/images/produk 1.png"
            ],
            [
                "id" => 2,
                "name" => "produk 2",
                "description" => "deskripsi produk 2",
                "price" => 299,
                "image" => "/images/produk 2.png"
            ],
            [
                "id" => 3,
                "name" => "produk 3",
                "description" => "deskripsi produk 3",
                "price" => 199,
                "image" => "/images/produk 3.png"
            ],
            [
                "id" => 4,
                "name" => "produk 4",
                "description" => "deskripsi produk 4",
                "price" => 89,
                "image" => "/images/produk 4.png"
            ],
            [
                "id" => 5,
                "name" => "produk 5",
                "description" => "deskripsi produk 5",
                "price" => 349,
                "image" => "/images/produk 5.png"
            ],
            [
                "id" => 6,
                "name" => "produk 6",
                "description" => "deskripsi produk 6",
                "price" => 129,
                "image" => "/images/produk 6.png"
            ],
            [
                "id" => 7,
                "name" => "produk 7",
                "description" => "deskripsi produk 7",
                "price" => 179,
                "image" => "/images/produk 7.png"
            ],
            [
                "id" => 8,
                "name" => "produk 8",
                "description" => "deskripsi produk 8",
                "price" => 99,
                "image" => "/images/produk 8.png"
            ]
        ];

        $bgColors = [
            'bg-[#B68B4B]', 
            'bg-[#EED2A4]', 
            'bg-[#FFF4E7]', 
            'bg-[#F0EFE7]',
        ];
        $paginatedProducts = $this->paginateArray($products, 4, $request->input('page'));

        return view('userPage.home',  compact('paginatedProducts', 'bgColors'));
    }
}

