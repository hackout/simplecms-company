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
                $this->addDict($sql);
            }
        }
    }

    private function addDict($data): void
    {
        $dict = Dict::create(['name' => $data['name'], 'code' => $data['code']]);
        $dict->items()->createMany($this->convertChildren($data['children']));

    }

    private function convertChildren(array $data): array
    {
        $result = [];
        foreach ($data as $value => $name) {
            $result[] = [
                'name' => $name,
                'content' => $value
            ];
        }
        return $result;
    }

    private function getList()
    {
        return [
            [
                'name' => '企业状态',
                'code' => 'company_status',
                'children' => ['营业中', '歇业', '闭业', '清退']
            ],
            [
                'name' => '企业申请状态',
                'code' => 'company_apply_status',
                'children' => ['待提交', '审核中', '审核通过', '审核拒绝', '关闭']
            ],
            [
                'name' => '企业日志请求类型',
                'code' => 'company_log_method',
                'children' => ['OPTION', 'GET', 'POST', 'PUT', 'PATCH', 'DELETE']
            ],
            [
                'name' => '企业等级标识',
                'code' => 'company_level',
                'children' => ['Lv.0', 'Lv.1', 'Lv.2', 'Lv.3', 'Lv.4', 'Lv.5']
            ],
        ];
    }
}
