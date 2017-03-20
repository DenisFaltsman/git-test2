<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * MyForm is the model behind the contact form.
 */
class MyForm extends Model
{
    public $name;
    public $email;
    public $file;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],

            ['file', 'file'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

}
