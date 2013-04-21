<?php

namespace Malenki\Ruche\Controller;
use Malenki\Model\Project as Project;
use RedBean_Facade as R;

class ApiProjectController extends Controller 
{
    public function postAction()
    {
        $post = (object) $this->req->post();
        /*
        $project = R::dispense('project');
        $project->name = $arr_post['name'];
        $project->short = $arr_post['short'];
        $project->description = $arr_post['description'];
        $project->rcs = $arr_post['rcs'];
        $project->path = $arr_post['path'];
        $project->acl = $arr_post['acl'];
        $project->creation = date('Y-m-d H:i:s');
        $project->slug = $arr_post['name']; //TODO à améliorer !
        $id = R::store($project);
         */
        $prj = new Project();
        $prj->setName($post->name);
        $prj->setShort($post->short);
        $prj->setDescription($post->description);
        $prj->setRcs($post->rcs);
        $prj->setPath($post->path);
        $prj->setAcl($post->acl);
        $id = $prj->save();

        // ou bien
        $prj = Project::create($this->req->post());
        if($prj->isValid())
        {
            $id = $prj->save();
        }

        //si succes uniquement, retourne 201 avec Location
        if($id)
        {
            $this->res->status(201);
            $this->res['Location'] = sprintf('/api/projects/%d', $id);
        }
        else
        {
            $this->res->status(500);
        }
    }



    public function getAction($pid = null)
    {
        $this->res['Content-Type'] = 'text/json; charset=utf-8';
        // Only one
        if($pid)
        {
            $project = R::load('project',$pid);

            if(!$project->id)
            {
                $this->res->status(404);
            }
            else
            {
                $this->res->status(200);
                $this->res->body(json_encode($project->export()));
            }
        }
        // List
        else 
        {
            try
            {
                $arr_projects = R::find('project');
                $arr_out = array();

                foreach($arr_projects as $prj)
                {
                    $arr_out[] = $prj->export();
                }

                $this->res->body(json_encode($arr_out));
            }
            catch(\PDOException $e)
            {
                $this->res->status(500);
                $this->res->body(json_encode($e->getMessage()));
            }

        }
    }
    
    
    public function getBySlugAction($slug)
    {
        $this->res['Content-Type'] = 'text/json; charset=utf-8';
        $project = R::findOne('project', ' slug = ? ', array($slug));

        if(!$project->id)
        {
            $this->res->status(404);
        }
        else
        {
            $this->res->status(200);
            $this->res->body(json_encode($project->export()));
        }
    }
}
