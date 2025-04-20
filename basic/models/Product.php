<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    /**
     * Define the associated table name.
     */
    public static function tableName()
    {
        return 'sanpham';
    }

    /**
     * Define validation rules.
     */
    public function rules()
    {
        return [
            [['tensp', 'dvt', 'nuocsx', 'gia'], 'required'],
            [['masp'], 'string', 'max' => 10],
            [['tensp', 'dvt', 'nuocsx'], 'string', 'max' => 255],
            [['gia'], 'integer'],
        ];
    }

    /**
     * Automatically generate a unique product ID (masp) before saving a new record.
     * Format: 'SP' followed by a zero-padded number (e.g., SP01, SP02, etc.).
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (empty($this->masp)) {
                $lastProduct = self::find()
                    ->orderBy(['masp' => SORT_DESC])
                    ->one();

                if ($lastProduct && preg_match('/SP(\d+)/', $lastProduct->masp, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    $nextNumber = 1;
                }

                $this->masp = 'SP' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Define attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'masp' => 'Mã Sản Phẩm',
            'tensp' => 'Tên Sản Phẩm',
            'dvt' => 'Đơn Vị Tính',
            'nuocsx' => 'Nước Sản Xuất',
            'gia' => 'Giá',
        ];
    }
}
