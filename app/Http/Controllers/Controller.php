<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index()
    {
        return view('welcome');
    }

    public function test() {

        /*if((new User())->findBy('id', 111111111) === null) {
            var_dump('im NULL');
        } else {
            var_dump('im NOT NULL');
        }*/
        var_dump((new User())->findBy('id', 111111111));


        return view('index');
    }
}
