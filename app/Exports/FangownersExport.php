<?php
namespace App\Exports;

use App\Models\Fangowner;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
// 添加标题
use Maatwebsite\Excel\Concerns\WithHeadings;
// 自动尺寸
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FangownersExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Fangowner::query();
    }

    public function headings(): array
    {
        return [
            'id',
            '房东姓名',
            '性别',
            '年龄',
            '手机号码',
            '身份证号码',
            '家庭住址',
            '身份证图片地址',
            '邮箱',
            '创建时间',
            '更新时间',
        ];
    }
}