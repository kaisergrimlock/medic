<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\Pagination;

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

    public static function getPaginatedStaff($pageSize = 10, $searchTerm = null)
    {
        $query = self::find(); // Start the query
        if (!empty($searchTerm)) {
            $query->andWhere([
            'or',
            ['like', 'hoten', $searchTerm],
            ['like', 'manv', $searchTerm],
            ]);
        }

        // Set up pagination
        $pagination = new Pagination([
            'defaultPageSize' => $pageSize,
            'totalCount' => $query->count(),
        ]);

        // Get customers with the pagination
        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'staffs' => $products,
            'pagination' => $pagination,
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
