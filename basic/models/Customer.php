<?php
namespace app\models;

use Yii;
use yii\data\Pagination;

class Customer
{
    /**
     * Get customer details by ID.
     */
    public static function findById($makh)
    {
        return Yii::$app->db->createCommand("SELECT * FROM khachhang WHERE makh = :makh")
            ->bindValue(':makh', $makh)
            ->queryOne();
    }

    /**
     * Get paginated invoice data for a customer.
     */
    public static function getPaginatedInvoices($makh)
    {
        $db = Yii::$app->db;

        $sqlCount = "SELECT COUNT(DISTINCT hoadon.sohd)
                     FROM hoadon
                     JOIN cthd ON hoadon.sohd = cthd.sohd
                     JOIN sanpham ON cthd.masp = sanpham.masp
                     JOIN nhanvien ON hoadon.manv = nhanvien.manv";

        if (!empty($makh)) {
            $sqlCount .= " WHERE hoadon.makh = :makh";
        }

        $command = $db->createCommand($sqlCount);
        if (!empty($makh)) {
            $command->bindValue(':makh', $makh);
        }

        $totalCount = $command->queryScalar();

        $pagination = new Pagination([
            'totalCount' => $totalCount ?: 1,
            'pageSize' => 1,
        ]);

        $sqlSohd = "SELECT DISTINCT hoadon.sohd 
                    FROM hoadon
                    JOIN cthd ON hoadon.sohd = cthd.sohd
                    JOIN sanpham ON cthd.masp = sanpham.masp";

        if (!empty($makh)) {
            $sqlSohd .= " WHERE hoadon.makh = :makh";
        }

        $sqlSohd .= " LIMIT :limit OFFSET :offset";

        $command = $db->createCommand($sqlSohd);
        if (!empty($makh)) {
            $command->bindValue(':makh', $makh);
        }
        $command->bindValue(':limit', $pagination->limit);
        $command->bindValue(':offset', $pagination->offset);

        $sohdResults = $command->queryColumn();

        if (empty($sohdResults)) {
            return [[], $pagination];
        }

        $placeholders = implode(',', array_fill(0, count($sohdResults), '?'));

        $sqlData = "SELECT sanpham.masp, sanpham.tensp, sanpham.dvt, sanpham.nuocsx, sanpham.gia, 
                           cthd.soluong, hoadon.sohd, hoadon.ngayhd, nhanvien.manv, nhanvien.hoten
                    FROM hoadon
                    JOIN cthd ON hoadon.sohd = cthd.sohd
                    JOIN sanpham ON cthd.masp = sanpham.masp
                    JOIN nhanvien ON hoadon.manv = nhanvien.manv
                    WHERE hoadon.sohd IN ($placeholders)
                    ORDER BY hoadon.sohd";

        $command = $db->createCommand($sqlData);
        foreach ($sohdResults as $index => $sohd) {
            $command->bindValue($index + 1, $sohd);
        }

        $data = $command->queryAll();

        return [$data, $pagination];
    }
}
