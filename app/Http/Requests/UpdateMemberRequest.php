<?php
namespace App\Http\Requests;
class UpdateMemberRequest extends StoreMemberRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['email'] = 'required|unique:users,email,' . $this->route('member');
        return $rules;
    }
}
