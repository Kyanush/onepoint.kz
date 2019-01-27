<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'carrier_id' => 'required|exists:carriers,id',
            'comment'    => 'max:1000',
            'payment_id' => 'required|exists:payments,id',
        ];

        if(!Auth::check())
        {
            $rules['user.email'] = 'required|max:255';
            $rules['user.name']  = 'required|max:255';
            $rules['user.phone'] = 'required|max:17|min:17';
        }

        if($this->input('address.id', 0) > 0){
            $rules['address.id'] = ['required',
                Rule::exists('addresses', 'id')
                    ->where(function ($query) {
                        if(Auth::check())
                            $query->where('user_id', Auth::user()->id);
                    })
            ];
        }else{
            $rules['address.city']     = 'required|max:255';
            $rules['address.address']  = 'required|max:255';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'carrier_id' => "'Способ доставки'",
            'comment'    => "'Комментарий к заказу'",
            'payment_id' => "'Оплата'",
            'user.email'      => "'Email'",
            'user.name'       => "'Имя'",
            'user.phone'      => "'Телефон'",
            'address.id'      => "'Ваш адрес'",
            'address.city'    => "'Город'",
            'address.address' => "'Адрес'",
        ];
    }

}