<?php

namespace Malenki\Ruche\Model;

use RedBean_Facade as R;

class Project
{
    protected $arr_errors = array();

    public static function create(array $arr)
    {
        if(array_key_exists('id', $arr))
        {
            $prj = new self($arr['id']);
        }
        else
        {
            $prj = new self();
        }

        foreach($arr as $k => $v)
        {
            $str_method = sprintf('set%s', ucfirst($k));
            $prj->$str_method($v);
        }
    }

    public function __construct($id = null)
    {
        if($id > 0)
        {
            $bean = R::load('project', $id);
        }
        else
        {
            $bean = R::dispense('project');
            $bean->creation = date('Y-m-d H:i:s');
        }
    }

    public function setName($str)
    {
        //TODO: Create filters
        if(strlen($str))
        {
            $this->bean->name = $str;
        }
        else
        {
            throw new \InvalidArgumentException(_('Project’s name must be a not null string'));
        }
    }
    
    public function setShort($str)
    {
        //TODO: Create filters
        if(strlen($str))
        {
            $this->bean->short = $str;
        }
    }


    public function setDescription($str)
    {
        //TODO: Create filters
        if(strlen($str))
        {
            $this->bean->description = $str;
        }
    }

    public function setRcs($str)
    {
        $str = strtolower(trim(strip_tags($str)));

        if(in_array($str, self::getAvailableRcs()))
        {
            $this->bean->rcs = $str;
        }
        else
        {
            throw new \InvalidArgumentException(
                _('RCS must be one of this three strings of characters: "svn", "git" or "hg".')
            );
        }

    }

    public static function getAvailableRcs()
    {
        return array('svn', 'git', 'hg');
    }

    public function setPath($str)
    {
        $str = trim(strip_tags($str));

        if(file_exists($str) && is_dir($str) && is_readable($str))
        {
            $this->bean->path = $str;
        }
        else
        {
            throw new \InvalidArgumentException(_('Project path must be a valid directory readable by web server.'));
        }
    }

    //TODO: à définir
    public function setAcl($str)
    {
        $this->bean->acl = $str;
    }

    public function save()
    {
        if($this->bean->id && $this->bean->getMeta('tainted'))
        {
            $this->bean->change = date('Y-m-d H:i:s');
        }
        else
        {
            $this->bean->slug = $this->bean->name; //TODO
        }
        return R::store($this->bean);
    }


    public function __get($name)
    {
        if($name == 'description')
        {
            // traitement spécial, retournera un objet dédié.
        }
        else
        {
            return $this->bean->$name;
        }
    }


    public function hasError()
    {
        return (boolean) count($this->arr_errors);
    }

    // TODO
    public static function getList($limit = null, $offset = null)
    {
    }


}
