<?php

namespace app\quality\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\quality\model\Quality as QualityModel;

class Quality extends Controller
{
    public function index()
    {
        $list = QualityModel::all();
        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据表为空'], 404);
        }
    }
    public function save(Request $request)
    {
        $data   = $request->param();
        $result = QualityModel::create($data);
        return json($result);
    }
    public function read($id)
    {
        if(strlen($id) == 10 ) {
            $data = QualityModel::scope('orderId')->select();
            if ($data) {
                return json($data);
            } else {
                return json(['error' => '条目不存在'], 404);
            }
        } else {
            $data = QualityModel::get($id);
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
            $result = QualityModel::update($data, ['id' => $id]);
            return json($result);
        }
    }
    public function delete($id)
    {
        $result = QualityModel::destroy($id);
        if($result) {
            return json(['success' => '成功删除条目']);
        } else {
            return json(['error' => '条目不存在'], 404);
        }
    }
}
