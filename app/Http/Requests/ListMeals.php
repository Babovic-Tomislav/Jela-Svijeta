<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Psy\Util\Str;

class ListMeals extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'perPage' => [
                'nullable',
                'int',
                'min:1'
            ],
            'page' => [
                'nullable',
                'int',
                'min:1'
            ],
            'category' => [
                'nullable',
                'string'
            ],
            'tags' => [
                'nullable'
            ],
            'tags.*' => [
                'required',
                'int',
                'distinct'
            ],
            'with' => [
                'nullable'
            ],
            'with.*' => [
                'required',
                'regex:(([a-zA-Z]+,*)+)',
                'string',
                'distinct'
            ],
            'lang' => [
                'bail',
                'required',
                'regex:(([a-zA-Z]+,*)+)',
                'string'
            ],
            'diffTime' => [
                'nullable',
                'int',
                'min:1',
                'max:2147483647'
            ],
        ];
    }




    public function TagsWithMapper()
    {
        $data['tags']=null;
        $data['with']=null;
        $data['diff_time']=null;
        if ($this->input('tags')) {
            $data['tags'] = array_map('intval', explode(',', $this->input('tags')));
        };

        if ($this->input('with')) {
            $data['with'] = explode(',', $this->input('with'));
        };

        if ($this->input('diff_time'))
        {
            $data['diff_time'] = Carbon::createFromTimestamp($this->input('diff_time'))->format('Y-m-d H:i:s');
        }

        return $data;
    }

    
    

    public function RequestChecker()
    {
        $data = $this->TagsWithMapper();


        $requestData = [
            'per_page'=> $this->input('per_page'),
            'page'=> $this->input('page'),
            'lang'=>$this->input('lang'),
            'category' =>$this->input('category'),
            'tags' => $data['tags'],
            'with' => $data['with'],
            'diff_time' => $data['diff_time']
        ];

        return collect($requestData);

    }
}
