<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emails".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $content
 * @property string $attachment
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'email', 'subject', 'content', 'attachment'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 55],
            [['email', 'subject', 'attachment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'content' => 'Content',
            'attachment' => 'Attachment',
        ];
    }
}
