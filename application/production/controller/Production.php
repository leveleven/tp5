<?php

namespace app\production\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\production\model\Production as ProductionModel;

class Production extends Controller
{
    public function index()
    {
        $list = ProductionModel::all();
        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据表为空'], 404);
        }
    }
    public function save(Request $request)
    {
        $data   = $request->param();
        $result = ProductionModel::create($data);
        return json($result);
    }
    public function read($id)
    {
        if(strlen($id) == 10 ) {
            $data = Db::name('production')->where('orderId', $id)->select();
            if ($data) {
                return json($data);
            } else {
                return json(['error' => '条目不存在'], 404);
            }
        } else {
            $data = ProductionModel::get($id);
            if ($data) {
                return json($data);
            } else {
                return json(['error' => '条目不存在'], 404);
            }
        }

    }
    public function update(Request $request, $id)
    {
        $data   = $request->param();
        unset($data['id']);
        if(strlen($id) == 10 ) {
            Db::name('storage')->where('orderId', $id)->update($data);
            return json($data);
        } else {
            $result = ProductionModel::update($data, ['id' => $id]);
            return json($result);
        }
    }
    public function delete($id)
    {
        $result = ProductionModel::destroy($id);
        if($result) {
            return json(['success' => '成功删除条目']);
        } else {
            return json(['error' => '条目不存在'], 404);
        }
    }
}
