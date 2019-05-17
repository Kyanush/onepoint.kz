<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Callback;
use Illuminate\Http\Request;

class CallbackController extends AdminController
{
    public function list(Request $request)
    {
        $list =  Callback::search($request->input('search'))
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    public function delete($id)
    {
        return  $this->sendResponse(Callback::destroy($id) ? true : false);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $data = $data['callback'];

        $callback = Callback::findOrNew($data["id"]);
        $callback->fill($data);
        $callback->save();

        return  $this->sendResponse($callback ? $callback->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Callback::findOrFail($id)
        );
    }

    public function newCallbacksCount(){
        return  $this->sendResponse(intval(Callback::where('status', 0)->count()));
    }

}
