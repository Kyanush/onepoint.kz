<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Rule;

class SaveAttributeRequest extends FormRequest
{

    public function rules()
    {
        $attribute_id = $this->input('attribute.id');

        $rules = [
            'attribute.id' => (!empty($attribute_id) ? 'exists:attributes,id' : 'nullable'),

            'attribute.name' => 'required|max:255|unique:attributes,name' . ($attribute_id ? (',' . $attribute_id . ',id') : ''),
            'attribute.code' => 'max:255|unique:attributes,code'          . ($attribute_id ? (',' . $attribute_id . ',id') : ''),

            'attribute.type' => 'required',
            'attribute.use_in_filter' => 'integer|required_if:0,1',
            'attribute.description' => 'max:500',
            'attribute.attribute_group_id' => $this->input('attribute.attribute_group_id')  ? 'required|exists:attribute_groups,id' : 'nullable',
        ];

        if($this->input('attribute.type') == 'multiple_select' or $this->input('attribute.type') == 'dropdown')
        {
            $rules["attribute.values.*.value"]  = 'required|distinct';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'attribute.id'   => "'id'",
            'attribute.name' => "'Название'",
            'attribute.type' => "'Тип'",
            'attribute.code' => "'Код'",
            'attribute.use_in_filter' => "'Показывать в фильтре'",
            'attribute.description' => "'Описание '",
            'attribute.attribute_group_id' => "'Группа'",

            'attribute.values.*.value' => "'Значение по умолчанию'"
        ];
    }

}
