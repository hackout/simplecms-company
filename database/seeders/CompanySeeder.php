<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use SimpleCMS\Framework\Models\Dict;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getList();
        foreach ($data as $sql) {
            if (!Dict::where('code', $sql['code'])->first()) {
                if ($dict = Dict::create(['name' => $sql['name'], 'code' => $sql['code']])) {
                    $dict->items()->createMany($sql['children']);
                }
            }
        }
    }

    public function getList()
    {
        return [
            [
                'name' => '企业状态',
                'code' => 'company_status',
                'children' => [
                    [
                        'name' => '营业中',
                        'content' => 0,
                    ],
                    [
                        'name' => '歇业',
                        'content' => 1,
                    ],
                    [
                        'name' => '闭业',
                        'content' => 2,
                    ],
                    [
                        'name' => '清退',
                        'content' => 3,
                    ]
                ]
            ],
            [
                'name' => '企业申请状态',
                'code' => 'company_apply_status',
                'children' => [
                    [
                        'name' => '待提交',
                        'content' => 0,
                    ],
                    [
                        'name' => '审核中',
                        'content' => 1,
                    ],
                    [
                        'name' => '审核通过',
                        'content' => 2,
                    ],
                    [
                        'name' => '审核拒绝',
                        'content' => 3,
                    ],
                    [
                        'name' => '关闭',
                        'content' => 4,
                    ]
                ]
            ],
            [
                'name' => '企业日志请求类型',
                'code' => 'company_log_method',
                'children' => [
                    [
                        'name' => 'OPTION',
                        'content' => 0,
                    ],
                    [
                        'name' => 'GET',
                        'content' => 1,
                    ],
                    [
                        'name' => 'POST',
                        'content' => 2,
                    ],
                    [
                        'name' => 'PUT',
                        'content' => 3,
                    ],
                    [
                        'name' => 'PATCH',
                        'content' => 4,
                    ],
                    [
                        'name' => 'DELETE',
                        'content' => 5,
                    ]
                ]
            ],
            [
                'name' => '企业等级标识',
                'code' => 'company_level',
                'children' => [
                    [
                        'name' => 'Lv.0',
                        'content' => 0,
                    ],
                    [
                        'name' => 'Lv.1',
                        'content' => 1,
                    ],
                    [
                        'name' => 'Lv.2',
                        'content' => 2,
                    ],
                    [
                        'name' => 'Lv.3',
                        'content' => 3,
                    ],
                    [
                        'name' => 'Lv.4',
                        'content' => 4,
                    ],
                    [
                        'name' => 'Lv.5',
                        'content' => 5,
                    ]
                ]
            ],
        ];
    }
}
