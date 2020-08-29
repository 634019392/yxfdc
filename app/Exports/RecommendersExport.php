<?php

namespace App\Exports;

use App\Models\Recommender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray; // 指定数组
use Maatwebsite\Excel\Concerns\WithHeadings; // 设置标题
use Maatwebsite\Excel\Concerns\WithCustomValueBinder; // 禁用智能化
use Maatwebsite\Excel\Concerns\WithColumnWidths; // 指定列宽
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // 自动尺寸
use Maatwebsite\Excel\Concerns\ToModel;

class RecommendersExport
    extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder // 禁用智能化(默认所有为问本)
    implements FromArray, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            [
                '全民经纪人'
            ],
            [
                'id',
                '经纪人',
                '经纪人手机号',
                '客户',
                '客户手机号',
                '客户年龄',
                '客户性别',
                '创建时间',
            ]
        ];
    }

    public function __construct($start_time, $end_time)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    public function array(): array
    {
        $rec = Recommender::whereBetween('created_at', [$this->start_time, $this->end_time])->get()->makeHidden('status_arr')->load(['apiuser', 'buyer', 'house'])->toArray();
        $data = [];
        foreach ($rec as $k => $v) {
            $data[$k]['id'] = $v['id'];
            $data[$k]['u_truename'] = $v['apiuser']['truename'];
            $data[$k]['u_phone'] = $v['apiuser']['phone'];
            $data[$k]['b_truename'] = $v['buyer']['truename'];
            $data[$k]['b_phone'] = $v['buyer']['phone'];
            $data[$k]['b_age'] = $v['buyer']['age'];
            $data[$k]['b_sex'] = $v['buyer']['sex'];
            $data[$k]['created_at'] = $v['created_at'];
        }

        return $data;
    }
}

