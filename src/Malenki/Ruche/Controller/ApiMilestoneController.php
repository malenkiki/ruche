<?php
/*
 * Copyright (c) 2014 Michel Petit <petit.michel@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


namespace Malenki\Ruche\Controller;

use RedBean_Facade as R;

class ApiMilestoneController extends Controller 
{
    public function init()
    {
        $this->res['Content-Type'] = 'text/json; charset=utf-8';
    }

    public function getAction($mid)
    {
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

