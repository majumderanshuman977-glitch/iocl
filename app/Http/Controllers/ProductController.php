<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list()
    {
        return view('product.list');
    }

    public function add()
    {
        return view('product.add');
    }

    public function categoryList()
    {
        return view('product.categorylist');
    }

    public function addCategory()
    {
        return view('product.addcategory');
    }

    public function subCategoryList()
    {
        return view('product.subcategorylist');
    }

    public function subAddCategory()
    {
        return view('product.subaddcategory');
    }

    public function brandList()
    {
        return view('product.brandlist');
    }

    public function addBrand()
    {
        return view('product.addbrand');
    }

    public function importProduct()
    {
        return view('product.importproduct');
    }

    public function barcode()
    {
        return view('product.barcode');
    }
}
