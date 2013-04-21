<?php

namespace Malenki\Ruche\Controller;

use RedBean_Facade as R;

class ApiMilestoneController extends Controller 
{
    public function getAction($mid)
    {
        $this->res['Content-Type'] = 'text/json; charset=utf-8';
        $milestone = R::load('milestone',$mid);

        if(!$milestone->id)
        {
            $this->res->status(404);
        }
        else
        {
            $this->res->status(200);
            $this->res->body(json_encode($milestone->export()));
        }
    }

    public function getListAction($pid)
    {
        $arr_milestones = R::find('milestone', 'project_id = ?', array($pid));

        $arr_out = array();

        foreach($arr_milestones as $mls)
        {
            $arr_out[] = $mls->export();
        }

        $this->res->body(json_encode($arr_out));
    }
}

