<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;//База данных 'ds'
use Validator;
use Response;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    // Добавление записи
    public function addItem(Request $request)
    {
        $rules = array(
                'name' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(

                    'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            $data = new Data();
            $data->name = $request->name;
            $data->save();

            return response()->json($data);
        }
    }
    // Чтение записей (Получение всех записей)
    public function readItems(Request $req)
    {
//        $data = Data::where('id', '>', '0')->orderBy('id', 'desc')->get();
        $data = Data::all();

        return view('welcome')->withData($data);
    }
    // Редактирование записи
    public function editItem(Request $req)
    {
        $data = Data::find($req->id);
        $data->name = $req->name;
        $data->save();

        return response()->json($data);
    }
    // Удаление записи
    public function deleteItem(Request $req)
    {
        Data::find($req->id)->delete();

        return response()->json();
    }
}
