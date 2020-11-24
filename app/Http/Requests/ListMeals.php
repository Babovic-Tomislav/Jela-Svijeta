<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ListMeals extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perPage'  => [
                'nullable',
                'int',
                'min:1'
            ],
            'page'     => [
                'nullable',
                'int',
                'min:1'
            ],
            'category' => [
                'nullable',
                'string'
            ],
            'tags'     => [
                'nullable'
            ],
            'tags.*'   => [
                'required',
                'int',
                'distinct'
            ],
            'with'     => [
                'nullable'
            ],
            'with.*'   => [
                'required',
                Rule::in('category, tags, ingredients'),
            ],
            'lang'     => [
                'bail',
                'required',
                Rule::in('hr', 'en', 'de')
            ],
            'diffTime' => [
                'nullable',
                'int',
                'min:1',
                'max:2147483647'
            ],
        ];
    }

    public function tagsWithMapper()
    {
        $data['tags'] = null;
        $data['with'] = null;
        $data['diff_time'] = null;
        if ($this->input('tags')) {
            $data['tags'] = array_map(
                'intval',
                explode(',', $this->input('tags'))
            );
        }

        if ($this->input('with')) {
            $data['with'] = explode(',', $this->input('with'));
        }

        if ($this->input('diff_time')) {
            $data['diff_time'] = Carbon::createFromTimestamp(
                $this->input('diff_time')
            )->format('Y-m-d H:i:s');
        }
        return $data;
    }

    public function requestChecker()
    {
        $data = $this->TagsWithMapper();
        $requestData = [
            'per_page'  => $this->input('per_page'),
            'page'      => $this->input('page'),
            'lang'      => $this->input('lang'),
            'category'  => $this->input('category'),
            'tags'      => $data['tags'],
            'with'      => $data['with'],
            'diff_time' => $data['diff_time']
        ];
        return collect($requestData);
    }
}
