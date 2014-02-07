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


class ApiController extends Controller 
{
    public function init(){
        $this->res['Content-Type'] = 'text/json; charset=utf-8';
    }

    /**
     * @todo Ajouter les codes retours, ainsi que les entêtes HTTP
     */
    public function rootAction($lang)
    {
        
        $arr = array(
            array(
                'POST',
                '/api/projects',
                _('Création d’un projet'),
                array(201, 404)
            ),
            array(
                'GET',
                '/api/projects/:pid',    
                _('Obtient les informations d’un projet'),
                array(200, 404)
            ),
            array(
                'GET',
                '/api/projects',
                _('Obtient la liste des projets'),
                array(200, 404)
            ),

            array(
                'POST',
                '/api/projects/:pid/milestones',
                _('Créer un jalon pour un projet'),
                array(201, 404)

            ),
            array(
                'GET',
                '/api/projects/:pid/milestones',
                _('Liste les jalons d’un projet'),
                array(200, 404)
            ),
            array(
                'GET',
                '/api/milestones/:mid',
                _('Récupère les infos d’un jalon'),
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/milestones/:mid',
                _('Mise à jour des infos d’un jalon'),
                array(200, 204, 404)
            ),
            array(
                'GET',
                '/api/milestones/:mid/tickets',
                _('Récupère les tickets d’un jalon'),
                array(200, 404)
            ),

            array(
                'POST',
                '/api/projects/:pid/users',
                'Ajoute un nouveau membre au projet',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/projects/:pid/users/:uid',
                'Obtient les infos d’un membre du projet',
                array(200, 404)
            ),
            array(
                'DELETE',
                '/api/projects/:pid/users/:uid',
                'Supprime un membre du projet',
                array(200, 404)
            ),
            array(
                'GET',
                '/api/projects/:pid/users',
                'Liste les membres d’un projet',
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/projects/:pid/users/:uid/roles/:type/:rule/:status',
                'Change les droits d’un utilisateur dans un projet',
                array(200, 204, 404)
            ),
            array(
                'PUT',
                '/api/projects/:pid/users/:uid/roles',
                'Liste les droits d’un utilisateur dans un projet',
                array(200, 204, 404)
            ),

            array(
                'POST',
                '/api/projects/:pid/tickets',
                'Création d’un nouveau ticket pour un projet',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/projects/:pid/tickets',
                'Liste des tickets du projet',
                array(200, 404)
            ),
            array(
                'GET',
                '/api/tickets/:tid',
                'Obtient un ticket',
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/tickets/:tid',
                'Mise à jour d’un ticket',
                array(200, 204, 404)
            ),
            array(
                'POST',
                '/api/tickets/:tid/comments',
                'Ajout d’un commentaire à un ticket',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/tickets/:tid/comments',
                'Liste des commentaires d’un ticket',
                array(200, 404)
            ),
            array(
                'GET',
                '/api/comments/:cid',
                'Obtient un commentaire',
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/comments/:cid',
                'Mise à jour d’un commentaire',
                array(200, 204, 404)
            ),

            array(
                'POST',
                '/api/ticket/:id/carbon-copies',
                'Ajoute un ou plusieurs destinataires en copie d’un ticket',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/ticket/:id/carbon-copies',
                'Liste les destinataires en copie d’un ticket',
                array(200, 404)
            ),
            array(
                'DELETE',
                '/api/ticket/:id/carbon-copies/:uid',
                'Retire un des destinataires en copie d’un ticket',
                array(200, 404)
            ),
            array(
                'DELETE',
                '/api/ticket/:id/carbon-copies',
                'Retire tous les destinataires en copie d’un ticket',
                array(200, 404)
            ),

            array(
                'POST',
                '/api/users',
                'Création d’un nouvel utilisateur',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/users',
                'Liste des utilisateurs',
                array(200, 404)
            ),
            array(
                'GET',
                '/api/users/:uid',
                'Obtention d’un utilisateur',
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/users/:uid',
                'Mise à jour d’un utilisateur',
                array(200, 204, 404)
            ),
            array(
                'DELETE',
                '/api/users/:uid',
                'Suppression d’un utilisateur',
                array(200, 404)
            ),

            array(
                'POST',
                '/api/users/:uid/emails',
                'Ajout d’un email à un utilisateur',
                array(201, 404)

            ),
            array(
                'GET',
                '/api/users/:uid/emails',
                'Liste les emails d’un utilisateur',
                array(200, 404)
            ),
            array(
                'GET',
                '/api/emails/:mid',
                'Obtient un email',
                array(200, 404)
            ),
            array(
                'PUT',
                '/api/emails/:mid',
                'Met à jour un email',
                array(200, 204, 404)
            ),
            array(
                'DELETE',
                '/api/emails/:mid',
                'Supprime un email',
                array(200, 404)
            ),

            array(
                'GET',
                '/api/users/:uid/projects',
                'Liste les projets dont fait partie un utilisateur',
                array(200, 404)
            )
        );

        if(count($this->req->params()))
        {
            $arr_filtered = array();
            foreach($arr as $row)
            {
                if($this->req->params('method') == strtolower($row[0]))
                {
                    $arr_filtered[] = $row;
                }
                
                if(in_array((integer) $this->req->params('return'), $row[3]))
                {
                    $arr_filtered[] = $row;
                }
            }
            $arr = $arr_filtered;
        }

        $this->res->body(json_encode($arr));
    }

}
