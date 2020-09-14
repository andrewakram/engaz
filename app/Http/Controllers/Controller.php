<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function encrypt(Request $request){
        $data=str_split($request->password);
        $newData = '';
        for($i=0; $i<sizeof($data); $i++){
            if(isset($data[$i+1])){
                if(ctype_lower($data[$i]) && ctype_upper($data[$i+1])){
                    $newData = $newData . $data[$i+1] . $data[$i] . '*';
                    $i++;
                    continue;
                }
            }
            if(is_numeric($data[$i])){
                $newData = $data[$i] . $newData . '0';
            }else{
                $newData = $newData . $data[$i];
            }
        }

        return view('welcome',compact('newData'));
    }

    public function decrypt(Request $request){
        $data=str_split($request->password);
        $newData = '';
        for($i=0; $i<sizeof($data); $i++){
            if(is_numeric($data[$i]) && $data[sizeof($data)-1] == 0){
                $newData = $newData . $data[$i];
                array_pop($data);
                continue;
            }
            if(isset($data[$i+1]) && isset($data[$i+2])){
                if(ctype_upper($data[$i]) && ctype_lower($data[$i+1]) && $data[$i+2]=='*'){
                    $newData =  $data[$i] . $data[$i+1] . $newData;
                    $i=$i+2;
                }
                else{
                    $newData = $data[$i] . $newData;
                }
            }else{
                $newData = $data[$i] . $newData;
            }
        }
        //aaSA22c
        //ASaa220

        return view('welcome',compact('newData'));
    }
}
