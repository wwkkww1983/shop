<?php
/**
 * 套餐 控制器
 */

namespace app\admin\controller;

use app\common\model\Devtype as SM;
use think\facade\Request;

class Devtype extends Common
{

    public function __construct() {
        parent::__construct();
        $this->model = new SM();
    }
    /**
     * 列表
     */
    public function index()
    {
        if( Request::instance()->isPost() ) {    //post 方式, 获取数据
            $page = input('page',1,'intval');
            $limit = input('limit',10,'intval');
            
            $dmodel = new $this->model;
            $list = $dmodel->page($page,$limit);

            return apiJson($list);
            
        } else {    //一般 get 请求, 展示页面
            
            return $this->fetch();
        }
        
    }
    
    /*
     * 添加
     */
    public function add()
    {
        if ( Request::instance()->isPost() ) {
            
            $params = input('post.');

            
            $M = new $this->model;
            $M->name = $params['name'];
            $M->factory = $params['factory'];
            $M->connect = $params['connect'];
            $M->intro = $params['intro'];
            
            if ( $M->save() ) {
                return apiJson('', 0, '添加成功');
            } else {
                return apiJson('', 1, '添加出错');
            }
        } else {
            
            //$this->assign('role', AdminRole::all());
            return $this->fetch();
        }
    }

    /**
     * 修改
     */
    public function update()
    {
        if ( Request::instance()->isPost() ) {

            $params = input('post.');

            //验证规则
            //$result = $this->validate($params, 'app\admin\validate\Admin.edit');
            //if ($result !== true) {
            //    return ['status' => 0, 'msg' => $result, 'url' => ''];
            //}

            $M = $this->model::get($params['id']);
            //$M->name = $params['name'];
            //$M->factory = $params['factory'];
            //$M->connect = $params['connect'];
            //$M->intro = $params['intro'];

            if ( $M->data($params)->save() ) {
                return apiJson('',0,'修改成功');
            } else {
                return apiJson('',1,'修改失败');
            }
        } else {
            return apiJson('',1,'没有参数');
        }
    }
    
    

    /**
     * 删除用户信息
     */
    public function del()
    {
        $id = input('param.Id/d', 0);
        $Mobj = SM::get($id);
        $Mobj->lock = SM::ISLOCK_YES;
        if ($Mobj->save()) {
            return apiJson();
        } else {
            return apiJson('', 1, '删除失败');
        }
    }
    
    
}
