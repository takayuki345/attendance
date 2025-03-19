<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest2 extends FormRequest
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
    public function rules()
    {
        return [
            'start' => ['required', 'date_format:H:i', 'before:end'],
            'end' => ['required', 'date_format:H:i'],
            'break_start.*' => ['required', 'date_format:H:i', 'before:break_end.*', 'after:start'],
            'break_end.*' => ['required', 'date_format:H:i', 'before:end'],
            'break_start_add' => ['nullable', 'date_format:H:i', 'required_with:break_end_add', 'before:break_end_add', 'after:start'],
            'break_end_add' => ['nullable', 'date_format:H:i', 'required_with:break_start_add', 'before:end'],
            'note' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'start.required' => '出勤時間を入力してください',
            'start.date_format' => '出勤時間を「HH:mm」形式で入力してください',
            'start.before' => '出勤時間もしくは退勤時間が不適切な値です',

            'end.required' => '退勤時間を入力して下さい',
            'end.date_format' => '退勤時間を「HH:mm」形式で入力してください',

            'break_start.*.required' => '開始時間を入力して下さい',
            'break_start.*.date_format' => '開始時間を「HH:mm」形式で入力してください',
            'break_start.*.before' => '開始時間もしくは終了時間が不適切です',
            'break_start.*.after' => '休憩時間が勤務時間外です',

            'break_end.*.required' => '終了時間を入力して下さい',
            'break_end.*.date_format' => '終了時間を「HH:mm」形式で入力してください',
            'break_end.*.before' => '休憩時間が勤務時間外です',

            'break_start_add.date_format' => '開始時間を「HH:mm」形式で入力してください',
            'break_start_add.required_with' => '開始時間を入力して下さい',
            'break_start_add.before' => '開始時間を入力して下さい',
            'break_start_add.after' => '休憩時間が勤務時間外です',

            'break_end_add.date_format' => '終了時間を「HH:mm」形式で入力してください',
            'break_end_add.required_with' => '終了時間を入力して下さい',
            'break_end_add.before' => '休憩時間が勤務時間外です',

            'note.required' => '備考を入力して下さい',
        ];
    }
}
