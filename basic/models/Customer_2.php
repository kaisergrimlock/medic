<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\Pagination;

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
            [['ho', 'gioitinh', 'diachi', 'sodt', 'ngaysinh', 'doanhso', 'ngaydk'], 'required'],
            [['makh'], 'string', 'max' => 10],
            [['ho', 'ten', 'diachi', 'nghenghiep'], 'string', 'max' => 255],
            [['sodt'], 'string', 'max' => 15],
            [['gioitinh', 'doanhso'], 'integer'],
            [['ngaysinh', 'ngaydk'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public static function getPaginatedCustomers($pageSize = 10, $searchTerm = null)
    {
        // Initialize the query
        $query = self::find();

        // If a search term is provided, filter the results
        if (!empty($searchTerm)) {
            $query->andWhere([
                'or',
                ['like', 'ho', $searchTerm],
                ['like', 'ten', $searchTerm],
                ['like', 'makh', $searchTerm],
                ['like', new \yii\db\Expression("ho || ' ' || ten"), $searchTerm]
            ]);
        }

        // Set up pagination
        $pagination = new Pagination([
            'defaultPageSize' => $pageSize,
            'totalCount' => $query->count(),
        ]);

        // Get customers with the pagination
        $customers = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'customers' => $customers,
            'pagination' => $pagination,
        ];
    }
    
    /**
     * Automatically generate a unique customer ID (makh) before saving a new record.
     * This method checks the last saved customer ID, increments it, and assigns it to the new record.
     * The format is 'KH' followed by a zero-padded number (e.g., KH01, KH02, etc.).
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            // Only auto-generate makh if it's a new record and makh not already set
            if (empty($this->makh)) {
                $lastCustomer = self::find()
                    ->orderBy(['makh' => SORT_DESC])
                    ->one();
    
                if ($lastCustomer && preg_match('/KH(\d+)/', $lastCustomer->makh, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    $nextNumber = 1;
                }
    
                // Format as KH01, KH02, KH10, etc.
                $this->makh = 'KH' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
            }
        }
    
        return parent::beforeSave($insert);
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
