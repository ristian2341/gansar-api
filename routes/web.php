<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


/// User Route
$router->get("/user","UserController@index");
$router->post("/add_user","UserController@create_user");
$router->get("/user_id/{id}","UserController@search_user");
$router->post("/login","UserController@login");
$router->post("/delete/{id}","UserController@delete");

// Barang Route
$router->get("/barang","BarangController@index");
$router->get("/barang/{id}","BarangController@search_data");
$router->post("/add_barang","BarangController@create_barang");
$router->post("/barang_out","BarangController@update_stok");
$router->post("/delete_barang/{id}","BarangController@delete");
$router->get("/barang_ready","BarangController@barangready");

// Kategori Barang
$router->get("/kategori","KategoriController@index");
$router->get("/kategori/{id}","KategoriController@search_user");
$router->post("/add_kategori","KategoriController@create_kategori");
$router->post("/delete_kategori/{id}","KategoriController@delete");

// Pinjam Barang
$router->get("/pinjam","PinjamController@index");
$router->get("/pinjam/{id}","PinjamController@search_data");
$router->post("/add_pinjam","PinjamController@create");
$router->get("/delete_pinjam/{id}","PinjamController@delete");
$router->get("/approve_pinjam/{id}","PinjamController@approve_pinjam");

// Pengembalian Barang
$router->get("/pengembalian","PengembalianController@index");
$router->get("/pengembalian/{id}","PengembalianController@search_data");
$router->post("/add_pengembalian","PengembalianController@create");
$router->get("/delete_pengembalian/{id}","PengembalianController@delete");
$router->get("/barang_pinjam/{id}","PengembalianController@BarangPinjam");
$router->get("/pinjam_data","PengembalianController@pinjam_data");
$router->get("/approve_pengembalian/{id}","PengembalianController@approve_kembali");

// Kondisi Barang
$router->get("/kondisi","KondisiController@index");
$router->get("/kondisi/{id}","KondisiController@search_user");
$router->post("/add_kondisi","KondisiController@create");
$router->post("/delete_kondisi/{id}","KondisiController@delete");

// Laporan Barang //
$router->get("/laporan_barang","LapBarangController@index");
$router->get("/search_laporan/{id}","LapBarangController@search_data");
$router->post("/add_labbarang","LapBarangController@create");
$router->get("/approve_labbarang/{id}","LapBarangController@approve");
$router->get("/delete_labbarang/{id}","LapBarangController@delete");