<?php

namespace App\Http\Requests;

use App\Enums\OpenWeatherMapEnum;
use Illuminate\Foundation\Http\FormRequest;

class SearchWeatherRequest extends FormRequest
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'lat' => ['sometimes','numeric'],
            'lon' => ['sometimes','numeric'],
            'q' => ['sometimes','string'],
            'units' => ['sometimes','in:' . implode(',',OpenWeatherMapEnum::UNITS)],
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        if( !empty($this->get('q')) ){
            $this->params['q'] = $this->get('q');
        }

        if( !empty($this->get('lat')) && !empty($this->get('lon')) ){
            $this->params['lat'] = $this->get('lat');
            $this->params['lon'] = $this->get('lon');
        }

        if( !empty($this->get('units')) ){
            $this->params['units'] = OpenWeatherMapEnum::UNITS[$this->get('units')];
        }else{
            $this->params['units'] = OpenWeatherMapEnum::UNIT_METRIC;
        }

        if( !empty($this->get('lang')) ){
            $this->params['lang'] = $this->get('lang');
        }else{
            $this->params['lang'] = OpenWeatherMapEnum::LANG_RU;
        }

        return $this->params;
    }
}
