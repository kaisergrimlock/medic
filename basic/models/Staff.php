<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Staff extends ActiveRecord
{
    /**
     * Define the associated table name.
     */
    public static function tableName()
    {
        return 'nhanvien';
    }

    /**
     * Define validation rules.
     */
    public function rules()
    {
        return [
            [['hoten', 'ngayvl', 'sodt'], 'required'],
            [['manv'], 'string', 'max' => 10],
            [['hoten'], 'string', 'max' => 255],
            [['sodt'], 'string', 'max' => 15],
            [['ngayvl'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * Auto-generate a unique staff ID (manv) before saving a new record.
     * Format: NV01, NV02, etc.
     */
    public function beforeSave($insert)
    {
        if ($insert && empty($this->manv)) {
            $lastStaff = self::find()
                ->orderBy(['manv' => SORT_DESC])
                ->one();

            if ($lastStaff && preg_match('/NV(\d+)/', $lastStaff->manv, $matches)) {
                $nextNumber = (int)$matches[1] + 1;
            } else {
                $nextNumber = 1;
            }

            $this->manv = 'NV' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        return parent::beforeSave($insert);
    }

    /**
     * Define attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'manv' => 'Mã Nhân Viên',
            'hoten' => 'Họ Tên',
            'ngayvl' => 'Ngày Vào Làm',
            'sodt' => 'Số Điện Thoại',
        ];
    }
}
