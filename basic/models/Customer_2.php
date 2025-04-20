<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Customer_2 extends ActiveRecord
{
    /**
     * Define the associated table name.
     */
    public static function tableName()
    {
        return 'khachhang';
    }

    /**
     * Define validation rules.
     */
    public function rules()
    {
        return [
            [['makh', 'ho', 'gioitinh', 'diachi', 'sodt', 'ngaysinh', 'doanhso', 'ngaydk'], 'required'],
            [['makh'], 'string', 'max' => 10],
            [['ho', 'ten', 'diachi', 'nghenghiep'], 'string', 'max' => 255],
            [['sodt'], 'string', 'max' => 15],
            [['gioitinh', 'doanhso'], 'integer'],
            [['ngaysinh', 'ngaydk'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * Define attribute labels (optional but useful).
     */
    public function attributeLabels()
    {
        return [
            'makh' => 'Mã Khách Hàng',
            'ho' => 'Họ',
            'ten' => 'Tên',
            'gioitinh' => 'Giới Tính',
            'diachi' => 'Địa Chỉ',
            'sodt' => 'Số Điện Thoại',
            'ngaysinh' => 'Ngày Sinh',
            'doanhso' => 'Doanh Số',
            'ngaydk' => 'Ngày Đăng Ký',
            'nghenghiep' => 'Nghề Nghiệp',
        ];
    }
}
